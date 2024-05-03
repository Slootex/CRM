<?php 

@session_start();

require_once('includes/class_dbbmailer.php');

use setasign\Fpdi\Fpdi;

require_once('includes/fpdf/fpdf.php');
require_once('includes/fpdi/code39.php');
require_once('includes/fpdi/autoload.php');

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

if($_SESSION["user"]["id"] < 1){
	header("Location: " . $systemdata['unuser_index']);
	exit();
}

include('includes/class_page_number.php');

$company_id = 1;

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'"), MYSQLI_ASSOC);

$row_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `admin`.`id`='" . intval($maindata['admin_id']) . "'"), MYSQLI_ASSOC);

$tab = "edit";
$link = "neue-auftraege";

if(isset($_POST["extra_search"])){$_SESSION["user_orders"]["extra_search"] = strip_tags($_POST["extra_search"]);}
if(isset($_POST["keyword"])){$_SESSION["user_orders"]["keyword"] = str_replace(" ", "", strip_tags($_POST["keyword"]));}
if(isset($_POST["email_template"])){$_SESSION["email_template"]["id"] = strip_tags($_POST["email_template"]);}
if(isset($_POST["sorting_field"])){$_SESSION["user_orders"]["sorting_field"] = intval($_POST["sorting_field"]);}
if(isset($_POST["sorting_direction"])){$_SESSION["user_orders"]["sorting_direction"] = intval($_POST["sorting_direction"]);}

$sorting = array();
$sorting[] = array(
	"name" => "Status", 
	"value" => "`status_name`"
);
$sorting[] = array(
	"name" => "Aktualisierungsdatum", 
	"value" => "CAST(`order_orders`.`upd_date` AS UNSIGNED)"
);
$sorting[] = array(
	"name" => "Erstelldatum", 
	"value" => "CAST(`order_orders`.`reg_date` AS UNSIGNED)"
);
/*$sorting[] = array(
	"name" => "Firma", 
	"value" => "`order_orders`.`companyname`"
);
$sorting[] = array(
	"name" => "Vorname", 
	"value" => "`order_orders`.`firstname`"
);
$sorting[] = array(
	"name" => "Nachname", 
	"value" => "`order_orders`.`lastname`"
);
$sorting[] = array(
	"name" => "Adresse", 
	"value" => "`order_orders`.`street`"
);*/
$sorting[] = array(
	"name" => "Auftragsnummer", 
	"value" => "`order_orders`.`order_number`"
);

$sorting_field_name = isset($_SESSION["user_orders"]["sorting_field"]) ? $sorting[$_SESSION["user_orders"]["sorting_field"]]["value"] : $sorting[0]["value"];
$sorting_field_value = isset($_SESSION["user_orders"]["sorting_field"]) ? $_SESSION["user_orders"]["sorting_field"] : 0;

$sorting_field_options = "";
foreach($sorting as $k => $v){
	$sorting_field_options .= "<option value=\"" . $k . "\"" . ($sorting_field_value == $k ? " selected=\"selected\"" : "") . ">" . $v["name"] . "</option>\n";
}

$directions = array(0 => "ASC", 1 => "DESC");

$sorting_direction_name = isset($_SESSION["user_orders"]["sorting_direction"]) ? $directions[$_SESSION["user_orders"]["sorting_direction"]] : "ASC";
$sorting_direction_value = isset($_SESSION["user_orders"]["sorting_direction"]) ? $_SESSION["user_orders"]["sorting_direction"] : 0;

if(isset($param['add']) && $param['add'] == "neuer-auftrag"){
	$_POST['add'] = "hinzufügen";
}

$amount_rows = 500;
if(!isset($param['pos'])){
	$pos = 0;
}else{
	$pos = intval($param['pos']);
}

$pageNumberlist = new pageList();

$user_amount_rows = 10;
if(!isset($param['userpage'])){
	$userpage = 0;
}else{
	$userpage = intval($param['userpage']);
}

$userNumberlist = new pageList();

$interested_amount_rows = 10;
if(!isset($param['interestedpage'])){
	$interestedpage = 0;
}else{
	$interestedpage = intval($param['interestedpage']);
}

$interestedNumberlist = new pageList();

$emsg = "";
$emsg_shipment = "";
$emsg_files = "";

$inp_companyname = "";
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
$inp_differing_shipping_address = "";
$inp_differing_companyname = "";
$inp_differing_firstname = "";
$inp_differing_lastname = "";
$inp_differing_street = "";
$inp_differing_streetno = "";
$inp_differing_zipcode = "";
$inp_differing_city = "";
$inp_differing_country = "";

$inp_pricemwst = "";
$inp_radio_shipping = "";
$inp_radio_payment = "";
$inp_amount = "";
$inp_radio_saturday = "";
$inp_mail_with_pdf = "";
$inp_admin_mail = "";

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

$inp_ref_number = "";
$inp_customer_number = "";
$inp_call_date = "";

// ----- New Email
$inp_new_email_name = "";
$inp_new_email_email = "";
$inp_new_email_subject = "";
$inp_new_email_body = "";
// ----- Customer Message
$inp_message = "";

$companyname = "";
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
$differing_shipping_address = 0;
$differing_companyname = "";
$differing_firstname = "";
$differing_lastname = "";
$differing_street = "";
$differing_streetno = "";
$differing_zipcode = "";
$differing_city = "";
$differing_country = 0;

$machine = "";
$model = "";
$constructionyear = "";
$carid = "";
$kw = "";
$mileage = 0;
$mechanism = 0;
$fuel = 0;

$component = 0;
$manufacturer = "";
$serial = "";
$fromthiscar = 1;
$reason = "";
$description = "";

$pricemwst = "0,00";
$radio_shipping = 1;
$radio_payment = 0;
$amount = 0.00;
$radio_saturday = 0;
$mail_with_pdf = 0;
$admin_mail = 0;

$ref_number = "";
$customer_number = "";
$call_date = 0;
// ----- New Email
$new_email_name = "";
$new_email_email = "";
$new_email_subject = "";
$new_email_body = "";
// ----- Customer Message
$message = "";
// ----- Shipping Quotes
$shipping_quotes_shippingcost = 0.00;

$html_new_email = "";
$html_new_status = "";
$html_new_shipping = "";
$html_new_shipping_form = "";
$html_new_shipping_options = "";
$html_new_shipping_shippingcost = "";
$html_new_shipping_result = "";
$html_add_user = "";
$html_add_interested = "";

if(isset($param['id']) && intval($param['id']) > 0){

	$tab = "add_user";
	$link = "neue-auftraege";

	$_POST['id'] = intval($param['id']);
	$_POST['edit'] = "bearbeiten";

}

if(isset($param['edit']) && intval($param['edit']) == "bearbeiten" && isset($param['id']) && intval($param['id']) > 0){

	$tab = "edit";
	$link = "neue-auftraege";

	$_POST['id'] = intval($param['id']);
	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['id']) && $_POST['id'] > 0){

	$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `order_orders`.`user_id`='" . $_SESSION["user"]["id"] . "' AND `order_orders`.`id`='" . intval($_POST['id']) . "'"), MYSQLI_ASSOC);

}

if(isset($_POST['multi_status']) && $_POST['multi_status'] == "durchführen" && isset($_POST['status']) && intval($_POST['status']) > 0){

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

		$ids = explode(",", strip_tags($_POST['ids']));

		for($i = 0;$i < count($ids);$i++){

			$time = time();

			$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `order_orders`.`user_id`='" . $_SESSION["user"]["id"] . "' AND `order_orders`.`id`'=" . intval($ids[$i]) . "'"), MYSQLI_ASSOC);
			$row_reason = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `reasons` WHERE `reasons`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `reasons`.`id`='" . intval($row_order['component']) . "'"), MYSQLI_ASSOC);
			$row_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . intval($row_order['country']) . "'"), MYSQLI_ASSOC);
			$row_differing_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . intval($row_order['differing_country']) . "'"), MYSQLI_ASSOC);
			$row_status = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `statuses`.`id`='" . intval($_POST['status']) . "'"), MYSQLI_ASSOC);
			$row_template = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `templates` WHERE `templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `templates`.`id`='" . intval($row_status['email_template']) . "'"), MYSQLI_ASSOC);

			$row_template['body'] .= $row_admin['email_signature'];

			$status_number = intval($maindata['admin_id']) . "A" . date("dmYHis", time());

			$domain = isset($_SERVER['HTTPS']) ? "https://" . $_SERVER['HTTP_HOST'] : "http://" . $_SERVER['HTTP_HOST'];

			$uploaddir = 'uploads/';

			$files = "";
			$links = "";
			$docs = "";
			$allowed = explode(",", str_replace(".", "", str_replace(", ", ",", $maindata['input_file_accept'])));
			if(isset($_FILES["file"]["error"])){
				foreach($_FILES["file"]["error"] as $key => $error) {
					if ($j <= 5 && $_FILES["file"]["name"][$key] != "") {
						$ext = pathinfo($_FILES["file"]["name"][$key], PATHINFO_EXTENSION);
						if(in_array($ext, $allowed)){
							$random = rand(1, 100000);
							$_FILES["file"]["name"][$key] = preg_replace("/[^a-z0-9\_\-\.]/i", '', strip_tags(basename($_FILES["file"]["name"][$key])));
							move_uploaded_file($_FILES["file"]["tmp_name"][$key], $uploaddir . "company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/document/" . basename($random . '_' . $_FILES["file"]["name"][$key]));
							$files .= $files == "" ? $random . '_' . $_FILES["file"]["name"][$key] : "\r\n" . $random . '_' . $_FILES["file"]["name"][$key];
							$links .= $links == "" ? "<a href=\"" . $domain . "/uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/document/" . $random . '_' . $_FILES["file"]["name"][$key] . "\">" . $random . '_' . $_FILES["file"]["name"][$key] . "</a>\n" : "<br /><a href=\"" . $domain . "/uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/document/" . $random . '_' . $_FILES["file"]["name"][$key] . "\">" . $random . '_' . $_FILES["file"]["name"][$key] . "</a>\n";
							$docs .= $docs == "" ? $random . '_' . $_FILES["file"]["name"][$key] : ", " . $random . '_' . $_FILES["file"]["name"][$key];
							mysqli_query($conn, "	INSERT 	`order_orders_files` 
													SET 	`order_orders_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
															`order_orders_files`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "', 
															`order_orders_files`.`file`='" . mysqli_real_escape_string($conn, $random . '_' . $_FILES["file"]["name"][$key]) . "'");
						}
					}
					$j++;
				}
			}

			$links = $links == "" ? "" : "	<table cellspacing=\"3\" cellpadding=\"3\" border=\"0\"><tr><td width=\"200\" valign=\"top\"><span>Dateien:</span></td><td>" . $links . "</td></tr></table><br />\n";

			$fields = array('subject', 'body', 'admin_mail_subject');

			for($j = 0;$j < count($fields);$j++){

				$row_template[$fields[$j]] = str_replace("[id]", $row_order['order_number'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[date]", date("d.m.Y (H:i)", $time), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[status_id]", $status_number, $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[status]", $row_status['name'], $row_template[$fields[$j]]);

				$row_template[$fields[$j]] = str_replace("[machine]", strip_tags($row_order['machine']), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[model]", strip_tags($row_order['model']), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[constructionyear]", strip_tags($row_order['constructionyear']), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[carid]", strip_tags($row_order['carid']), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[vin_html]", htmlentities($row_order['vin_html']), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[kw]", strip_tags($row_order['kw']), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[mileage]", number_format(intval($row_order['mileage']), 0, '', '.') . " km", $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[mechanism]", ($row_order['mechanism'] == 0 ? "Schaltung" : "Automatik"), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[fuel]", ($row_order['fuel'] == 0 ? "Benzin" : "Diesel"), $row_template[$fields[$j]]);

				$row_template[$fields[$j]] = str_replace("[component]", strip_tags($row_reason['name']), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[manufacturer]", strip_tags($row_order['manufacturer']), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[serial]", strip_tags($row_order['serial']), $row_template[$fields[$j]]);
				$radio_fromthiscar = array(	0 => "Nein, stammt aus einem anderen Fahrzeug.", 
											1 => "ja, stammt aus diesem Fahrzeug.");
				$row_template[$fields[$j]] = str_replace("[fromthiscar]", $radio_fromthiscar[$row_order['fromthiscar']], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[reason]", $row_order['reason'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[files]", $links, $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[description]", $row_order['description'], $row_template[$fields[$j]]);

				$row_template[$fields[$j]] = str_replace("[companyname]", $row_order['companyname'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[gender]", ($row_order['gender'] == 1 ? "Sehr geehrte Frau" : "Sehr geehrter Herr"), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[sexual]", ($row_order['gender'] == 1 ? "Frau" : "Herr"), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[firstname]", $row_order['firstname'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[lastname]", $row_order['lastname'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[street]", $row_order['street'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[streetno]", $row_order['streetno'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[zipcode]", $row_order['zipcode'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[city]", $row_order['city'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[country]", $row_country['name'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[phonenumber]", $row_order['phonenumber'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[mobilnumber]", $row_order['mobilnumber'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[email]", "<a href=\"mailto: " . $row_order['email'] . "\">" . $row_order['email'] . "</a>\n", $row_template[$fields[$j]]);

				$html_differing_shipping_address = 	$differing_shipping_address == 0 ? 
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

				$row_template[$fields[$j]] = str_replace("[differing_shipping_address]", $html_differing_shipping_address, $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_companyname]", $row_order['differing_companyname'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_firstname]", $row_order['differing_firstname'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_lastname]", $row_order['differing_lastname'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_street]", $row_order['differing_street'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_streetno]", $row_order['differing_streetno'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_zipcode]", $row_order['differing_zipcode'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_city]", $row_order['differing_city'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_country]", $row_differing_country['name'], $row_template[$fields[$j]]);

				$row_template[$fields[$j]] = str_replace("[pricemwst]", number_format($row_order['pricemwst'], 2, ',', '') . " €", $row_template[$fields[$j]]);
				$radio_radio_shipping = array(	0 => "Expressversand", 
												1 => "Standardversand", 
												2 => "International", 
												3 => "Abholung");
				$row_template[$fields[$j]] = str_replace("[radio_shipping]", $radio_radio_shipping[$row_order['radio_shipping']], $row_template[$fields[$j]]);
				$radio_radio_payment = array(	0 => "Überweisung (Sie überweisen den Rechnungsbetrag per Überweisung)", 
												1 => "Nachnahme", 
												2 => "Bar");
				$row_template[$fields[$j]] = str_replace("[radio_payment]", $radio_radio_payment[$row_order['radio_payment']], $row_template[$fields[$j]]);

			}

			mysqli_query($conn, "	INSERT 	`order_orders_statuses` 
									SET 	`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
											`order_orders_statuses`.`order_id`='" . mysqli_real_escape_string($conn, intval($ids[$i])) . "', 
											`order_orders_statuses`.`status_number`='" . mysqli_real_escape_string($conn, $status_number) . "', 
											`order_orders_statuses`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
											`order_orders_statuses`.`status_id`='" . mysqli_real_escape_string($conn, $row_status['id']) . "', 
											`order_orders_statuses`.`template`='" . mysqli_real_escape_string($conn, $row_template['name']) . "', 
											`order_orders_statuses`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
											`order_orders_statuses`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
											`order_orders_statuses`.`public`='1', 
											`order_orders_statuses`.`time`='" . $time . "'");

			$_SESSION["status"]["id"] = $conn->insert_id;

			mysqli_query($conn, "	INSERT 	`order_orders_events` 
									SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
											`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
											`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($ids[$i])) . "', 
											`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
											`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Verlauf, " . $row_status['name'] . ", ID [#" . $_SESSION["status"]["id"] . "]") . "', 
											`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
											`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
											`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

			$tracking_image = "<img src=\"" . $domain . "/email-logo/" . $_SESSION["admin"]["company_id"] . "/" . $row_order['order_number'] . "/" . $status_number . "\" width=\"0\" height=\"0\" border=\"0\" />\n";

			if($row_template['mail_with_pdf'] == 1){

				$filename = "begleitschein.pdf";

				$pdf = new Fpdi();

				$pdf->AddPage();

				require('includes/email_template_pdf_code_' . $row_template['id'] . '.php');

				$pdfdoc = $pdf->Output("", "S");

				if($row_status['usermail'] == 1 && $row_order['email'] != "" && !isset($_POST['no_email'])){

					$mail = new dbbMailer();

					$mail->host = $maindata['smtp_host'];
					$mail->username = $maindata['smtp_username'];
					$mail->password = $maindata['smtp_password'];
					$mail->secure = $maindata['smtp_secure'];
					$mail->port = intval($maindata['smtp_port']);
					$mail->charset = $maindata['smtp_charset'];
	 
					$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
					$mail->addAddress($row_order['email'], $row_order['firstname'] . " " . $row_order['lastname']);

					//$mail->addAttachment(dirname(__FILE__) . "/../../temp/condition.tar");

					$mail->addStringAttachment($pdfdoc, $filename, 'base64', 'application/pdf');

					$mail->subject = strip_tags($row_template['subject']);

					$mail->body = str_replace("[track]", "", $row_template['body']);

					if(!$mail->send()){

					}

				}

				if($row_status['adminmail'] == 1 && !isset($_POST['no_email'])){

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

				if($row_status['usermail'] == 1 && $row_order['email'] != "" && !isset($_POST['no_email'])){

					$mail = new dbbMailer();

					$mail->host = $maindata['smtp_host'];
					$mail->username = $maindata['smtp_username'];
					$mail->password = $maindata['smtp_password'];
					$mail->secure = $maindata['smtp_secure'];
					$mail->port = intval($maindata['smtp_port']);
					$mail->charset = $maindata['smtp_charset'];
	 
					$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
					$mail->addAddress($row_order['email'], $row_order['firstname'] . " " . $row_order['lastname']);

					$mail->subject = strip_tags($row_template['subject']);

					$mail->body = str_replace("[track]", $tracking_image, $row_template['body']);

					if(!$mail->send()){

					}

				}

				if($row_status['adminmail'] == 1 && !isset($_POST['no_email'])){

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

		}

	}

}

if(isset($_POST['save']) && $_POST['save'] == "speichern"){

	$tab = "edit";
	$link = "neuer-auftrag";

	if(strlen($_POST['companyname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Firmenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_companyname = " is-invalid";
	} else {
		$companyname = strip_tags($_POST['companyname']);
	}

	if(strlen($_POST['firstname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Vorname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_firstname = " is-invalid";
	} else {
		$firstname = strip_tags($_POST['firstname']);
	}

	if(strlen($_POST['lastname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Nachname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_lastname = " is-invalid";
	} else {
		$lastname = strip_tags($_POST['lastname']);
	}

	if(strlen($_POST['street']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Straßenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_street = " is-invalid";
	} else {
		$street = strip_tags($_POST['street']);
	}

	if(strlen($_POST['streetno']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Hausnummer ein. (max. 10 Zeichen)</small><br />\n";
		$inp_streetno = " is-invalid";
	} else {
		$streetno = strip_tags($_POST['streetno']);
	}

	if(strlen($_POST['zipcode']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Postleitzahl ein. (max. 10 Zeichen)</small><br />\n";
		$inp_zipcode = " is-invalid";
	} else {
		$zipcode = strip_tags($_POST['zipcode']);
	}

	if(strlen($_POST['city']) > 128){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Ort ein. (max. 128 Zeichen)</small><br />\n";
		$inp_city = " is-invalid";
	} else {
		$city = strip_tags($_POST['city']);
	}

	if(strlen($_POST['country']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihr Land ein. (max. 11 Zeichen)</small><br />\n";
		$inp_country = " is-invalid";
	} else {
		$country = intval($_POST['country']);
	}

	if(strlen($_POST['phonenumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Telefonnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_phonenumber = " is-invalid";
	} else {
		$phonenumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['phonenumber']));
	}

	if(strlen($_POST['mobilnumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Mobilnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_mobilnumber = " is-invalid";
	} else {
		$mobilnumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['mobilnumber']));
	}

	if($_POST['email'] == "" || preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,26})$/", $_POST['email'])){
		$email = strip_tags($_POST['email']);
	} else {
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre E-Mail-Adresse ein.</small><br />\n";
		$inp_email = " is-invalid";
	}

	if(strlen($_POST['differing_shipping_address']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie hier ob eine abweichender Lieferadresse verwendet werden soll. (max. 1 Zeichen)</small><br />\n";
		$inp_differing_shipping_address = " is-invalid";
	} else {
		$differing_shipping_address = intval($_POST['differing_shipping_address']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_companyname']) > 256) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_companyname']) > 256))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Firmenname der abweichender Lieferadresse ein. (max. 256 Zeichen)</small><br />\n";
		$inp_differing_companyname = " is-invalid";
	} else {
		$differing_companyname = strip_tags($_POST['differing_companyname']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_firstname']) > 256) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_firstname']) > 256))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Vorname der abweichender Lieferadresse ein. (max. 256 Zeichen)</small><br />\n";
		$inp_differing_firstname = " is-invalid";
	} else {
		$differing_firstname = strip_tags($_POST['differing_firstname']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_lastname']) > 256) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_lastname']) > 256))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Nachname der abweichender Lieferadresse ein. (max. 256 Zeichen)</small><br />\n";
		$inp_differing_lastname = " is-invalid";
	} else {
		$differing_lastname = strip_tags($_POST['differing_lastname']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_street']) > 256) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_street']) > 256))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Straßenname der abweichender Lieferadresse ein. (max. 256 Zeichen)</small><br />\n";
		$inp_differing_street = " is-invalid";
	} else {
		$differing_street = strip_tags($_POST['differing_street']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['streetno']) > 10) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_streetno']) > 10))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Hausnummer der abweichender Lieferadresse ein. (max. 10 Zeichen)</small><br />\n";
		$inp_differing_streetno = " is-invalid";
	} else {
		$differing_streetno = strip_tags($_POST['differing_streetno']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_zipcode']) > 10) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_zipcode']) > 10))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Postleitzahl der abweichender Lieferadresse ein. (max. 10 Zeichen)</small><br />\n";
		$inp_differing_zipcode = " is-invalid";
	} else {
		$differing_zipcode = strip_tags($_POST['differing_zipcode']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_city']) > 128) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_city']) > 128))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Ort der abweichender Lieferadresse ein. (max. 128 Zeichen)</small><br />\n";
		$inp_differing_city = " is-invalid";
	} else {
		$differing_city = strip_tags($_POST['differing_city']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_country']) > 11) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_country']) > 11))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihr Land der abweichender Lieferadresse ein. (max. 11 Zeichen)</small><br />\n";
		$inp_differing_country = " is-invalid";
	} else {
		$differing_country = intval($_POST['differing_country']);
	}

	if(strlen($_POST['pricemwst']) > 20){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Betrag ein.</small><br />\n";
		$inp_pricemwst = " is-invalid";
	} else {
		$pricemwst = str_replace(",", ".", $_POST['pricemwst']);
	}

	if(strlen($_POST['radio_shipping']) < 1 || strlen($_POST['radio_shipping']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie den Typ für den DE Rückversand.</small><br />\n";
		$inp_radio_shipping = " is-invalid";
	} else {
		$radio_shipping = intval($_POST['radio_shipping']);
	}

	if(strlen($_POST['radio_payment']) < 1 || strlen($_POST['radio_payment']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie die Bezahlungsart.</small><br />\n";
		$inp_radio_payment = " is-invalid";
	} else {
		$radio_payment = intval($_POST['radio_payment']);
	}

	if(strlen($_POST['machine']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte die Automarke eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_machine = " is-invalid";
	} else {
		$machine = strip_tags($_POST['machine']);
	}

	if(strlen($_POST['model']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte die Automodell eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_model = " is-invalid";
	} else {
		$model = strip_tags($_POST['model']);
	}

	if(strlen($_POST['constructionyear']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte das Baujahr eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_constructionyear = " is-invalid";
	} else {
		$constructionyear = strip_tags($_POST['constructionyear']);
	}

	if(strlen($_POST['carid']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte die Fahrzeug-Identifizierungsnummer eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_carid = " is-invalid";
	} else {
		$carid = strtoupper(strip_tags($_POST['carid']));
	}

	if(strlen($_POST['kw']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte die Fahrleistung (PS) eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_kw = " is-invalid";
	} else {
		$kw = strip_tags($_POST['kw']);
	}

	if(strlen($_POST['mileage']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte den Kilometerstand eingeben. (max. 10 Zeichen)</small><br />\n";
		$inp_mileage = " is-invalid";
	} else {
		$mileage = intval(str_replace(".", "", $_POST['mileage']));
	}

	if(strlen($_POST['mechanism']) < 1 || strlen($_POST['mechanism']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte das Getriebe auswählen.</small><br />\n";
		$inp_mechanism = " is-invalid";
	} else {
		$mechanism = intval($_POST['mechanism']);
	}

	if(strlen($_POST['fuel']) < 1 || strlen($_POST['fuel']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte die Kraftstoffart auswählen.</small><br />\n";
		$inp_fuel = " is-invalid";
	} else {
		$fuel = intval($_POST['fuel']);
	}

	if(strlen($_POST['component']) < 1 || strlen($_POST['component']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte das defekte Bauteil auswählen. (max. 256 Zeichen)</small><br />\n";
		$inp_component = " is-invalid";
	} else {
		$component = intval($_POST['component']);
	}

	if(strlen($_POST['manufacturer']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte den Hersteller eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_manufacturer = " is-invalid";
	} else {
		$manufacturer = strtoupper(strip_tags($_POST['manufacturer']));
	}

	if(strlen($_POST['serial']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte die Teile.-/Herstellernummer eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_serial = " is-invalid";
	} else {
		$serial = strip_tags($_POST['serial']);
	}

	if(strlen($_POST['fromthiscar']) < 1 || strlen($_POST['fromthiscar']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie ob das Gerät aus dem angegebenen KFZ stammt.</small><br />\n";
		$inp_fromthiscar = " is-invalid";
	} else {
		$fromthiscar = intval($_POST['fromthiscar']);
	}

	if(strlen($_POST['reason']) > 700){
		$emsg .= "<small class=\"error text-muted\">Bitte die Fehlerursache/welche Funktionen gehen nicht eingeben. (max. 700 Zeichen)</small><br />\n";
		$inp_reason = " is-invalid";
	} else {
		$reason = str_replace("\r\n", " - ", strip_tags($_POST['reason']));
	}

	if(strlen($_POST['description']) > 700){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein was am Fahrzeug bereits gemacht wurde. (max. 700 Zeichen)</small><br />\n";
		$inp_description = " is-invalid";
	} else {
		$description = str_replace("\r\n", " - ", strip_tags($_POST['description']));
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

		$hash = bin2hex(random_bytes(32));

		$row_reason = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `reasons` WHERE `reasons`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `reasons`.`id`='" . intval($component) . "'"), MYSQLI_ASSOC);
		$row_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . intval($country) . "'"), MYSQLI_ASSOC);
		$row_differing_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . intval($differing_country) . "'"), MYSQLI_ASSOC);

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

		$domain = isset($_SERVER['HTTPS']) ? "https://" . $_SERVER['HTTP_HOST'] : "http://" . $_SERVER['HTTP_HOST'];

		$uploaddir = 'uploads/';

		$files = "";
		$links = "";
		$docs = "";

		$j = 1;

		$_SESSION["files"] = array();

		$allowed = explode(",", str_replace(".", "", str_replace(", ", ",", $maindata['input_file_accept'])));

		if(isset($_FILES["file"]["error"])){
			foreach($_FILES["file"]["error"] as $key => $error) {
				if ($j <= 5 && $_FILES["file"]["name"][$key] != "") {
					$ext = pathinfo($_FILES["file"]["name"][$key], PATHINFO_EXTENSION);
					if(in_array($ext, $allowed)){
						$random = rand(1, 100000);
						$_FILES["file"]["name"][$key] = preg_replace("/[^a-z0-9\_\-\.]/i", '', strip_tags(basename($_FILES["file"]["name"][$key])));
						move_uploaded_file($_FILES["file"]["tmp_name"][$key], $uploaddir . "company/" . intval($company_id) . "/order/" . $order_number . "/userdata/" . basename($random . '_' . $_FILES["file"]["name"][$key]));
						$files .= $files == "" ? $random . '_' . $_FILES["file"]["name"][$key] : "\r\n" . $random . '_' . $_FILES["file"]["name"][$key];
						$links .= $links == "" ? "<a href=\"" . $domain . "/uploads/company/" . intval($company_id) . "/order/" . $order_number . "/userdata/" . $random . '_' . $_FILES["file"]["name"][$key] . "\">" . $random . '_' . $_FILES["file"]["name"][$key] . "</a>\n" : "<br /><a href=\"" . $domain . "/uploads/company/" . intval($company_id) . "/order/" . $order_number . "/userdata/" . $random . '_' . $_FILES["file"]["name"][$key] . "\">" . $random . '_' . $_FILES["file"]["name"][$key] . "</a>\n";
						$docs .= $docs == "" ? $random . '_' . $_FILES["file"]["name"][$key] : ", " . $random . '_' . $_FILES["file"]["name"][$key];
						$_SESSION["files"][] = $random . '_' . $_FILES["file"]["name"][$key];
					}
				}
				$j++;
			}
		}

		mysqli_query($conn, "	INSERT 	`order_orders` 
								SET 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
										`order_orders`.`mode`='0', 
										`order_orders`.`order_number`='" . mysqli_real_escape_string($conn, $order_number) . "', 
										`order_orders`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`order_orders`.`user_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["user"]["id"])) . "', 

										`order_orders`.`companyname`='" . mysqli_real_escape_string($conn, $companyname) . "', 
										`order_orders`.`gender`='" . mysqli_real_escape_string($conn, intval(isset($_POST['gender']) ? $_POST['gender'] : 0)) . "', 
										`order_orders`.`firstname`='" . mysqli_real_escape_string($conn, $firstname) . "', 
										`order_orders`.`lastname`='" . mysqli_real_escape_string($conn, $lastname) . "', 
										`order_orders`.`street`='" . mysqli_real_escape_string($conn, $street) . "', 
										`order_orders`.`streetno`='" . mysqli_real_escape_string($conn, $streetno) . "', 
										`order_orders`.`zipcode`='" . mysqli_real_escape_string($conn, $zipcode) . "', 
										`order_orders`.`city`='" . mysqli_real_escape_string($conn, $city) . "', 
										`order_orders`.`country`='" . mysqli_real_escape_string($conn, $country) . "', 
										`order_orders`.`phonenumber`='" . mysqli_real_escape_string($conn, $phonenumber) . "', 
										`order_orders`.`mobilnumber`='" . mysqli_real_escape_string($conn, $mobilnumber) . "', 
										`order_orders`.`email`='" . mysqli_real_escape_string($conn, $email) . "', 
										`order_orders`.`differing_shipping_address`='" . mysqli_real_escape_string($conn, $differing_shipping_address) . "', 
										`order_orders`.`differing_companyname`='" . mysqli_real_escape_string($conn, $differing_companyname) . "', 
										`order_orders`.`differing_gender`='" . mysqli_real_escape_string($conn, intval(isset($_POST['differing_gender']) ? $_POST['differing_gender'] : 0)) . "', 
										`order_orders`.`differing_firstname`='" . mysqli_real_escape_string($conn, $differing_firstname) . "', 
										`order_orders`.`differing_lastname`='" . mysqli_real_escape_string($conn, $differing_lastname) . "', 
										`order_orders`.`differing_street`='" . mysqli_real_escape_string($conn, $differing_street) . "', 
										`order_orders`.`differing_streetno`='" . mysqli_real_escape_string($conn, $differing_streetno) . "', 
										`order_orders`.`differing_zipcode`='" . mysqli_real_escape_string($conn, $differing_zipcode) . "', 
										`order_orders`.`differing_city`='" . mysqli_real_escape_string($conn, $differing_city) . "', 
										`order_orders`.`differing_country`='" . mysqli_real_escape_string($conn, $differing_country) . "', 

										`order_orders`.`pricemwst`='" . mysqli_real_escape_string($conn, $pricemwst) . "', 
										`order_orders`.`radio_shipping`='" . mysqli_real_escape_string($conn, intval(isset($_POST['radio_shipping']) ? $_POST['radio_shipping'] : 0)) . "', 
										`order_orders`.`radio_payment`='" . mysqli_real_escape_string($conn, intval(isset($_POST['radio_payment']) ? $_POST['radio_payment'] : 0)) . "', 

										`order_orders`.`machine`='" . mysqli_real_escape_string($conn, $machine) . "', 
										`order_orders`.`model`='" . mysqli_real_escape_string($conn, $model) . "', 
										`order_orders`.`constructionyear`='" . mysqli_real_escape_string($conn, $constructionyear) . "', 
										`order_orders`.`carid`='" . mysqli_real_escape_string($conn, $carid) . "', 
										`order_orders`.`kw`='" . mysqli_real_escape_string($conn, $kw) . "', 
										`order_orders`.`mileage`='" . mysqli_real_escape_string($conn, $mileage) . "', 
										`order_orders`.`mechanism`='" . mysqli_real_escape_string($conn, $mechanism) . "', 
										`order_orders`.`fuel`='" . mysqli_real_escape_string($conn, $fuel) . "', 

										`order_orders`.`component`='" . mysqli_real_escape_string($conn, $component) . "', 
										`order_orders`.`manufacturer`='" . mysqli_real_escape_string($conn, $manufacturer) . "', 
										`order_orders`.`serial`='" . mysqli_real_escape_string($conn, $serial) . "', 
										`order_orders`.`fromthiscar`='" . mysqli_real_escape_string($conn, $fromthiscar) . "', 

										`order_orders`.`reason`='" . mysqli_real_escape_string($conn, $reason) . "', 
										`order_orders`.`description`='" . mysqli_real_escape_string($conn, $description) . "', 
										`order_orders`.`userdata`='" . mysqli_real_escape_string($conn, $files) . "', 

										`order_orders`.`ref_number`='" . mysqli_real_escape_string($conn, ($ref_number != "" ? $ref_number : $order_number)) . "', 
										`order_orders`.`customer_number`='" . mysqli_real_escape_string($conn, $customer_number) . "', 
										`order_orders`.`call_date`='" . mysqli_real_escape_string($conn, strtotime($call_date)) . "', 

										`order_orders`.`hash`='" . mysqli_real_escape_string($conn, strip_tags($hash)) . "', 
										`order_orders`.`transfer_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
										`order_orders`.`run_date`='" . mysqli_real_escape_string($conn, intval($_POST['run_date'])) . "', 
										`order_orders`.`reg_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
										`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$_POST["id"] = $conn->insert_id;

		$j = 1;

		foreach($_SESSION["files"] as $key => $val) {
			if ($j <= 5 && $_SESSION["files"][$key] != "") {
				mysqli_query($conn, "	INSERT 	`order_orders_files` 
										SET 	`order_orders_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
												`order_orders_files`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
												`order_orders_files`.`file`='" . mysqli_real_escape_string($conn, $_SESSION["files"][$key]) . "'");
			}
			$j++;
		}

		$links = $links == "" ? "" : "	<table cellspacing=\"3\" cellpadding=\"3\" border=\"0\"><tr><td width=\"200\" valign=\"top\"><span>Dateien:</span></td><td>" . $links . "</td></tr></table><br />\n";

		$row_status = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `statuses`.`id`='" . $maindata['order_status'] . "'"), MYSQLI_ASSOC);

		$row_template = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `templates` WHERE `templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `templates`.`id`='" . $row_status['email_template'] . "'"), MYSQLI_ASSOC);

		$row_template['body'] .= $row_admin['email_signature'];

		$status_number = intval($maindata['admin_id']) . "A" . date("dmYHis", time());

		$fields = array('subject', 'body', 'admin_mail_subject');

		for($j = 0;$j < count($fields);$j++){

			$row_template[$fields[$j]] = str_replace("[status_id]", $status_number, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[status]", $row_status["name"], $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[id]", $order_number, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[date]", date("d.m.Y (H:i)", $time), $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[companyname]", $companyname, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[gender]", (isset($_POST['gender']) && $_POST['gender'] == 1 ? "Sehr geehrte Frau" : "Sehr geehrter Herr"), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[sexual]", (isset($_POST['gender']) && $_POST['gender'] == 1 ? "Frau" : "Herr"), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[firstname]", $firstname, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[lastname]", $lastname, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[street]", $street, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[streetno]", $streetno, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[zipcode]", $zipcode, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[city]", $city, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[country]", $row_country['name'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[phonenumber]", $phonenumber, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[mobilnumber]", $mobilnumber, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[email]", "<a href=\"mailto: " . $email . "\">" . $email . "</a>\n", $row_template[$fields[$j]]);

			$differing_shipping_address = 	$differing_shipping_address == 0 ? 
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
			$row_template[$fields[$j]] = str_replace("[differing_companyname]", $differing_companyname, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_firstname]", $differing_firstname, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_lastname]", $differing_lastname, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_street]", $differing_street, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_streetno]", $differing_streetno, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_zipcode]", $differing_zipcode, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_city]", $differing_city, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_country]", $row_differing_country['name'], $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[pricemwst]", number_format($pricemwst, 2, ',', '') . " €", $row_template[$fields[$j]]);
			$radio_radio_shipping = array(	0 => "Expressversand", 
											1 => "Standardversand", 
											2 => "International", 
											3 => "Abholung");
			$row_template[$fields[$j]] = str_replace("[radio_shipping]", $radio_radio_shipping[$radio_shipping], $row_template[$fields[$j]]);
			$radio_radio_payment = array(	0 => "Überweisung (Sie überweisen den Rechnungsbetrag per Überweisung)", 
											1 => "Nachnahme", 
											2 => "Bar");
			$row_template[$fields[$j]] = str_replace("[radio_payment]", $radio_radio_payment[$radio_payment], $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[machine]", strip_tags($machine), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[model]", strip_tags($model), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[constructionyear]", strip_tags($constructionyear), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[carid]", strip_tags($carid), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[vin_html]", htmlentities($row_order['vin_html']), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[kw]", strip_tags($kw), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[mileage]", number_format(intval($mileage), 0, '', '.') . " km", $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[mechanism]", ($mechanism == 0 ? "Schaltung" : "Automatik"), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[fuel]", ($fuel == 0 ? "Benzin" : "Diesel"), $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[reason]", $reason, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[description]", $description, $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[files]", $links, $row_template[$fields[$j]]);

		}

		mysqli_query($conn, "	INSERT 	`order_orders_statuses` 
								SET 	`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
										`order_orders_statuses`.`order_id`='" . mysqli_real_escape_string($conn, $_POST["id"]) . "', 
										`order_orders_statuses`.`status_number`='" . mysqli_real_escape_string($conn, $status_number) . "', 
										`order_orders_statuses`.`admin_id`='" . mysqli_real_escape_string($conn, $maindata['admin_id']) . "', 
										`order_orders_statuses`.`status_id`='" . mysqli_real_escape_string($conn, $row_status['id']) . "', 
										`order_orders_statuses`.`template`='" . mysqli_real_escape_string($conn, $row_template['name']) . "', 
										`order_orders_statuses`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
										`order_orders_statuses`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
										`order_orders_statuses`.`public`='1', 
										`order_orders_statuses`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

		$_SESSION["status"]["id"] = $conn->insert_id;

		mysqli_query($conn, "	INSERT 	`order_orders_events` 
								SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
										`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
										`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag (Intern), erstellt, ID [#" . $_SESSION["status"]["id"] . "]") . "', 
										`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
										`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
										`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

		if($row_template['mail_with_pdf'] == 1){

			$filename = "begleitschein.pdf";

			$pdf = new Fpdi();

			$pdf->AddPage();

			require('includes/email_template_pdf_code_' . $row_template['id'] . '.php');

			$pdfdoc = $pdf->Output("", "S");

			if($row_status['usermail'] == 1 && $email != ""){

				$mail = new dbbMailer();

				$mail->host = $maindata['smtp_host'];
				$mail->username = $maindata['smtp_username'];
				$mail->password = $maindata['smtp_password'];
				$mail->secure = $maindata['smtp_secure'];
				$mail->port = intval($maindata['smtp_port']);
				$mail->charset = $maindata['smtp_charset'];
 
				$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
				$mail->addAddress($email, $firstname . " " . $lastname);

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

			if($row_status['usermail'] == 1 && $email != ""){

				$mail = new dbbMailer();

				$mail->host = $maindata['smtp_host'];
				$mail->username = $maindata['smtp_username'];
				$mail->password = $maindata['smtp_password'];
				$mail->secure = $maindata['smtp_secure'];
				$mail->port = intval($maindata['smtp_port']);
				$mail->charset = $maindata['smtp_charset'];
 
				$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
				$mail->addAddress($email, $firstname . " " . $lastname);

				$mail->subject = strip_tags($row_template['subject']);

				$mail->body = str_replace("[track]", "", $row_template['body']);

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

		$emsg = "<p>Der neue Auftrag wurde erfolgreich hinzugefügt!</p>\n";

		$_POST["edit"] = "bearbeiten";

	}else{

		$_POST["add"] = "hinzufügen";

	}

}

if(isset($_POST['add']) && $_POST['add'] == "hinzufügen"){

	$link = "neuer-auftrag";
	
}

if(isset($_POST['update']) && $_POST['update'] == "speichern"){

	$tab = "edit";
	$link = "neue-auftraege";

	$time = time();

	if(strlen($_POST['companyname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Firmenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_companyname = " is-invalid";
	} else {
		$companyname = strip_tags($_POST['companyname']);
	}

	if(strlen($_POST['firstname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Vorname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_firstname = " is-invalid";
	} else {
		$firstname = strip_tags($_POST['firstname']);
	}

	if(strlen($_POST['lastname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Nachname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_lastname = " is-invalid";
	} else {
		$lastname = strip_tags($_POST['lastname']);
	}

	if(strlen($_POST['street']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Straßenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_street = " is-invalid";
	} else {
		$street = strip_tags($_POST['street']);
	}

	if(strlen($_POST['streetno']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Hausnummer ein. (max. 10 Zeichen)</small><br />\n";
		$inp_streetno = " is-invalid";
	} else {
		$streetno = strip_tags($_POST['streetno']);
	}

	if(strlen($_POST['zipcode']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Postleitzahl ein. (max. 10 Zeichen)</small><br />\n";
		$inp_zipcode = " is-invalid";
	} else {
		$zipcode = strip_tags($_POST['zipcode']);
	}

	if(strlen($_POST['city']) > 128){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Ort ein. (max. 128 Zeichen)</small><br />\n";
		$inp_city = " is-invalid";
	} else {
		$city = strip_tags($_POST['city']);
	}

	if(strlen($_POST['country']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihr Land ein. (max. 11 Zeichen)</small><br />\n";
		$inp_country = " is-invalid";
	} else {
		$country = intval($_POST['country']);
	}

	if(strlen($_POST['phonenumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Telefonnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_phonenumber = " is-invalid";
	} else {
		$phonenumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['phonenumber']));
	}

	if(strlen($_POST['mobilnumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Mobilnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_mobilnumber = " is-invalid";
	} else {
		$mobilnumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['mobilnumber']));
	}

	if(preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,26})$/", $_POST['email']) && $_POST['email'] != ""){
		$email = strip_tags($_POST['email']);
	} else {
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre E-Mail-Adresse ein.</small><br />\n";
		$inp_email = " is-invalid";
	}

	if(strlen($_POST['differing_shipping_address']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie hier ob eine abweichender Lieferadresse verwendet werden soll. (max. 1 Zeichen)</small><br />\n";
		$inp_differing_shipping_address = " is-invalid";
	} else {
		$differing_shipping_address = intval($_POST['differing_shipping_address']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_companyname']) > 256) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_companyname']) > 256))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Firmenname der abweichender Lieferadresse ein. (max. 256 Zeichen)</small><br />\n";
		$inp_differing_companyname = " is-invalid";
	} else {
		$differing_companyname = strip_tags($_POST['differing_companyname']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_firstname']) > 256) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_firstname']) > 256))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Vorname der abweichender Lieferadresse ein. (max. 256 Zeichen)</small><br />\n";
		$inp_differing_firstname = " is-invalid";
	} else {
		$differing_firstname = strip_tags($_POST['differing_firstname']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_lastname']) > 256) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_lastname']) > 256))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Nachname der abweichender Lieferadresse ein. (max. 256 Zeichen)</small><br />\n";
		$inp_differing_lastname = " is-invalid";
	} else {
		$differing_lastname = strip_tags($_POST['differing_lastname']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_street']) > 256) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_street']) > 256))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Straßenname der abweichender Lieferadresse ein. (max. 256 Zeichen)</small><br />\n";
		$inp_differing_street = " is-invalid";
	} else {
		$differing_street = strip_tags($_POST['differing_street']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['streetno']) > 10) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_streetno']) > 10))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Hausnummer der abweichender Lieferadresse ein. (max. 10 Zeichen)</small><br />\n";
		$inp_differing_streetno = " is-invalid";
	} else {
		$differing_streetno = strip_tags($_POST['differing_streetno']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_city']) > 128) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_city']) > 128))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Ort der abweichender Lieferadresse ein. (max. 128 Zeichen)</small><br />\n";
		$inp_differing_city = " is-invalid";
	} else {
		$differing_city = strip_tags($_POST['differing_city']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_country']) > 11) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_country']) > 11))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihr Land der abweichender Lieferadresse ein. (max. 11 Zeichen)</small><br />\n";
		$inp_differing_country = " is-invalid";
	} else {
		$differing_country = intval($_POST['differing_country']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_zipcode']) > 10) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_zipcode']) > 10))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Postleitzahl der abweichender Lieferadresse ein. (max. 10 Zeichen)</small><br />\n";
		$inp_differing_zipcode = " is-invalid";
	} else {
		$differing_zipcode = strip_tags($_POST['differing_zipcode']);
	}

	if(strlen($_POST['pricemwst']) > 20){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Betrag ein.</small><br />\n";
		$inp_pricemwst = " is-invalid";
	} else {
		$pricemwst = str_replace(",", ".", $_POST['pricemwst']);
	}

	if(strlen($_POST['radio_shipping']) < 1 || strlen($_POST['radio_shipping']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie den Typ für den DE Rückversand.</small><br />\n";
		$inp_radio_shipping = " is-invalid";
	} else {
		$radio_shipping = intval($_POST['radio_shipping']);
	}

	if(strlen($_POST['radio_payment']) < 1 || strlen($_POST['radio_payment']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie die Bezahlungsart.</small><br />\n";
		$inp_radio_payment = " is-invalid";
	} else {
		$radio_payment = intval($_POST['radio_payment']);
	}

	if(strlen($_POST['ref_number']) > 128){
		$emsg .= "<small class=\"error text-muted\">Bitte eine Referenznummer eingeben. (max. 128 Zeichen)</small><br />\n";
		$inp_ref_number = " is-invalid";
	} else {
		$ref_number = strip_tags($_POST['ref_number']);
	}

	if(strlen($_POST['call_date']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte die Automarke eingeben. (max. 10 Zeichen)</small><br />\n";
		$inp_call_date = " is-invalid";
	} else {
		$call_date = strtotime($_POST['call_date']);
	}

	if($emsg == ""){

		mysqli_query($conn, "	UPDATE 	`order_orders` 
								SET 	`order_orders`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`order_orders`.`user_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["user"]["id"])) . "', 
										`order_orders`.`ref_number`='" . mysqli_real_escape_string($conn, $ref_number) . "', 
										`order_orders`.`call_date`='" . mysqli_real_escape_string($conn, $call_date) . "', 
										`order_orders`.`companyname`='" . mysqli_real_escape_string($conn, $companyname) . "', 
										`order_orders`.`gender`='" . mysqli_real_escape_string($conn, intval(isset($_POST['gender']) ? $_POST['gender'] : 0)) . "', 
										`order_orders`.`firstname`='" . mysqli_real_escape_string($conn, $firstname) . "', 
										`order_orders`.`lastname`='" . mysqli_real_escape_string($conn, $lastname) . "', 
										`order_orders`.`street`='" . mysqli_real_escape_string($conn, $street) . "', 
										`order_orders`.`streetno`='" . mysqli_real_escape_string($conn, $streetno) . "', 
										`order_orders`.`zipcode`='" . mysqli_real_escape_string($conn, $zipcode) . "', 
										`order_orders`.`city`='" . mysqli_real_escape_string($conn, $city) . "', 
										`order_orders`.`country`='" . mysqli_real_escape_string($conn, $country) . "', 
										`order_orders`.`phonenumber`='" . mysqli_real_escape_string($conn, $phonenumber) . "', 
										`order_orders`.`mobilnumber`='" . mysqli_real_escape_string($conn, $mobilnumber) . "', 
										`order_orders`.`email`='" . mysqli_real_escape_string($conn, $email) . "', 
										`order_orders`.`differing_shipping_address`='" . mysqli_real_escape_string($conn, intval(isset($_POST['differing_shipping_address']) ? $_POST['differing_shipping_address'] : 0)) . "', 
										`order_orders`.`differing_companyname`='" . mysqli_real_escape_string($conn, $differing_companyname) . "', 
										`order_orders`.`differing_gender`='" . mysqli_real_escape_string($conn, intval(isset($_POST['differing_gender']) ? $_POST['differing_gender'] : 0)) . "', 
										`order_orders`.`differing_firstname`='" . mysqli_real_escape_string($conn, $differing_firstname) . "', 
										`order_orders`.`differing_lastname`='" . mysqli_real_escape_string($conn, $differing_lastname) . "', 
										`order_orders`.`differing_street`='" . mysqli_real_escape_string($conn, $differing_street) . "', 
										`order_orders`.`differing_streetno`='" . mysqli_real_escape_string($conn, $differing_streetno) . "', 
										`order_orders`.`differing_zipcode`='" . mysqli_real_escape_string($conn, $differing_zipcode) . "', 
										`order_orders`.`differing_city`='" . mysqli_real_escape_string($conn, $differing_city) . "', 
										`order_orders`.`differing_country`='" . mysqli_real_escape_string($conn, $differing_country) . "', 
										`order_orders`.`pricemwst`='" . mysqli_real_escape_string($conn, $pricemwst) . "', 
										`order_orders`.`radio_shipping`='" . mysqli_real_escape_string($conn, intval(isset($_POST['radio_shipping']) ? $_POST['radio_shipping'] : 0)) . "', 
										`order_orders`.`radio_payment`='" . mysqli_real_escape_string($conn, intval(isset($_POST['radio_payment']) ? $_POST['radio_payment'] : 0)) . "', 
										`order_orders`.`upd_date`='" . $time . "' 
								WHERE 	`order_orders`.`id`='" . intval($_POST['id']) . "' 
								AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

		mysqli_query($conn, "	INSERT 	`order_orders_events` 
								SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
										`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
										`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag, Kundendaten geändert, ID [#" . intval($_POST["id"]) . "]") . "', 
										`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag, Kundendaten geändert, ID [#" . intval($_POST["id"]) . "]") . "', 
										`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
										`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

		$emsg = "<p>Der Auftrag wurde erfolgreich geändert!</p>\n";

	}

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['order_data']) && $_POST['order_data'] == "speichern"){

	$tab = "order_data";
	$link = "neue-auftraege";

	$time = time();

	if(strlen($_POST['machine']) < 1 || strlen($_POST['machine']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte die Automarke eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_machine = " is-invalid";
	} else {
		$machine = strip_tags($_POST['machine']);
	}

	if(strlen($_POST['model']) < 1 || strlen($_POST['model']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte die Automodell eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_model = " is-invalid";
	} else {
		$model = strip_tags($_POST['model']);
	}

	if(strlen($_POST['constructionyear']) < 1 || strlen($_POST['constructionyear']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte das Baujahr eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_constructionyear = " is-invalid";
	} else {
		$constructionyear = strip_tags($_POST['constructionyear']);
	}

	if(strlen($_POST['carid']) < 1 || strlen($_POST['carid']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte die Fahrzeug-Identifizierungsnummer eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_carid = " is-invalid";
	} else {
		$carid = strtoupper(strip_tags($_POST['carid']));
	}

	if(strlen($_POST['kw']) < 1 || strlen($_POST['kw']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte die Fahrleistung (PS) eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_kw = " is-invalid";
	} else {
		$kw = strip_tags($_POST['kw']);
	}

	if(strlen($_POST['mileage']) < 1 || strlen($_POST['mileage']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte den Kilometerstand eingeben. (max. 10 Zeichen)</small><br />\n";
		$inp_mileage = " is-invalid";
	} else {
		$mileage = intval(str_replace(".", "", $_POST['mileage']));
	}

	if(strlen($_POST['mechanism']) < 1 || strlen($_POST['mechanism']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte das Getriebe auswählen.</small><br />\n";
		$inp_mechanism = " is-invalid";
	} else {
		$mechanism = intval($_POST['mechanism']);
	}

	if(strlen($_POST['fuel']) < 1 || strlen($_POST['fuel']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte die Kraftstoffart auswählen.</small><br />\n";
		$inp_fuel = " is-invalid";
	} else {
		$fuel = intval($_POST['fuel']);
	}

	if(strlen($_POST['component']) < 1 || strlen($_POST['component']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte das defekte Bauteil auswählen. (max. 256 Zeichen)</small><br />\n";
		$inp_component = " is-invalid";
	} else {
		$component = intval($_POST['component']);
	}

	if(strlen($_POST['manufacturer']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte den Hersteller eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_manufacturer = " is-invalid";
	} else {
		$manufacturer = strtoupper(strip_tags($_POST['manufacturer']));
	}

	if(strlen($_POST['serial']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte die Teile.-/Herstellernummer eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_serial = " is-invalid";
	} else {
		$serial = strip_tags($_POST['serial']);
	}

	if(strlen($_POST['fromthiscar']) < 1 || strlen($_POST['fromthiscar']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie ob das Gerät aus dem angegebenen KFZ stammt. (max. 256 Zeichen)</small><br />\n";
		$inp_fromthiscar = " is-invalid";
	} else {
		$fromthiscar = strip_tags($_POST['fromthiscar']);
	}

	if(strlen($_POST['reason']) > 700){
		$emsg .= "<small class=\"error text-muted\">Bitte die Fehlerursache/welche Funktionen gehen nicht eingeben. (max. 700 Zeichen)</small><br />\n";
		$inp_reason = " is-invalid";
	} else {
		$reason = str_replace("\r\n", " - ", strip_tags($_POST['reason']));
	}

	if(strlen($_POST['description']) > 700){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein was am Fahrzeug bereits gemacht wurde. (max. 700 Zeichen)</small><br />\n";
		$inp_description = " is-invalid";
	} else {
		$description = str_replace("\r\n", " - ", strip_tags($_POST['description']));
	}

	if($emsg == ""){

		mysqli_query($conn, "	UPDATE 	`order_orders` 
								SET 	`order_orders`.`machine`='" . mysqli_real_escape_string($conn, $machine) . "', 
										`order_orders`.`model`='" . mysqli_real_escape_string($conn, $model) . "', 
										`order_orders`.`constructionyear`='" . mysqli_real_escape_string($conn, $constructionyear) . "', 
										`order_orders`.`carid`='" . mysqli_real_escape_string($conn, $carid) . "', 
										`order_orders`.`kw`='" . mysqli_real_escape_string($conn, $kw) . "', 
										`order_orders`.`mileage`='" . mysqli_real_escape_string($conn, $mileage) . "', 
										`order_orders`.`mechanism`='" . mysqli_real_escape_string($conn, $mechanism) . "', 
										`order_orders`.`fuel`='" . mysqli_real_escape_string($conn, $fuel) . "', 
										`order_orders`.`component`='" . mysqli_real_escape_string($conn, $component) . "', 
										`order_orders`.`manufacturer`='" . mysqli_real_escape_string($conn, $manufacturer) . "', 
										`order_orders`.`serial`='" . mysqli_real_escape_string($conn, $serial) . "', 
										`order_orders`.`fromthiscar`='" . mysqli_real_escape_string($conn, $fromthiscar) . "', 
										`order_orders`.`reason`='" . mysqli_real_escape_string($conn, $reason) . "', 
										`order_orders`.`description`='" . mysqli_real_escape_string($conn, $description) . "', 
										`order_orders`.`upd_date`='" . $time . "' 
								WHERE 	`order_orders`.`id`='" . intval($_POST['id']) . "' 
								AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

		mysqli_query($conn, "	INSERT 	`order_orders_events` 
								SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
										`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
										`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag, Auftragsdaten geändert, ID [#" . intval($_POST["id"]) . "]") . "', 
										`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag, Auftragsdaten geändert, ID [#" . intval($_POST["id"]) . "]") . "', 
										`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
										`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

		$emsg = "<p>Der Auftrag wurde erfolgreich geändert!</p>\n";

	}

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['delete']) && $_POST['delete'] == "Auftrag unwiederuflich löschen"){

	$link = "neue-auftraege";

	$arr_files = explode("\r\n", $row_order['userdata']);

	for($i = 0;$i < count($arr_files);$i++){
		@unlink("uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/userdata/" . $arr_files[$i]);
	}

	$arr_files = explode("\r\n", $row_order['files']);

	for($i = 0;$i < count($arr_files);$i++){
		@unlink("uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/document/" . $arr_files[$i]);
	}

	$arr_files = explode("\r\n", $row_order['audio']);

	for($i = 0;$i < count($arr_files);$i++){
		@unlink("uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/audio/" . $arr_files[$i]);
	}

	// delete order_orders
	mysqli_query($conn, "	DELETE FROM	`order_orders` 
							WHERE 		`order_orders`.`id`='" . intval($_POST['id']) . "' 
							AND 		`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

	// delete order_orders_*
	mysqli_query($conn, "	DELETE FROM	`order_orders_statuses` 
							WHERE 		`order_orders_statuses`.`order_id`='" . intval($_POST['id']) . "' 
							AND 		`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

	mysqli_query($conn, "	DELETE FROM	`order_orders_emails` 
							WHERE 		`order_orders_emails`.`order_id`='" . intval($_POST['id']) . "' 
							AND 		`order_orders_emails`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

	mysqli_query($conn, "	DELETE FROM	`order_orders_history` 
							WHERE 		`order_orders_history`.`order_id`='" . intval($_POST['id']) . "' 
							AND 		`order_orders_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

	mysqli_query($conn, "	DELETE FROM	`order_orders_customer_messages` 
							WHERE 		`order_orders_customer_messages`.`order_id`='" . intval($_POST['id']) . "' 
							AND 		`order_orders_customer_messages`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

	mysqli_query($conn, "	DELETE FROM	`order_orders_shipments` 
							WHERE 		`order_orders_shipments`.`order_id`='" . intval($_POST['id']) . "' 
							AND 		`order_orders_shipments`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

	mysqli_query($conn, "	DELETE FROM	`order_orders_events` 
							WHERE 		`order_orders_events`.`order_id`='" . intval($_POST['id']) . "' 
							AND 		`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

	// delete interested_interesteds_*
	mysqli_query($conn, "	DELETE FROM	`interested_interesteds_statuses` 
							WHERE 		`interested_interesteds_statuses`.`interested_id`='" . intval($_POST['id']) . "' 
							AND 		`interested_interesteds_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

	mysqli_query($conn, "	DELETE FROM	`interested_interesteds_emails` 
							WHERE 		`interested_interesteds_emails`.`interested_id`='" . intval($_POST['id']) . "' 
							AND 		`interested_interesteds_emails`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

	mysqli_query($conn, "	DELETE FROM	`interested_interesteds_history` 
							WHERE 		`interested_interesteds_history`.`interested_id`='" . intval($_POST['id']) . "' 
							AND 		`interested_interesteds_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

	mysqli_query($conn, "	DELETE FROM	`interested_interesteds_customer_messages` 
							WHERE 		`interested_interesteds_customer_messages`.`interested_id`='" . intval($_POST['id']) . "' 
							AND 		`interested_interesteds_customer_messages`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

	mysqli_query($conn, "	DELETE FROM	`interested_interesteds_events` 
							WHERE 		`interested_interesteds_events`.`interested_id`='" . intval($_POST['id']) . "' 
							AND 		`interested_interesteds_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

	$result = mysqli_query($conn, "SELECT * FROM `order_orders_files` WHERE `order_orders_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `order_orders_files`.`order_id`='" . intval($_POST['id']) . "'");

	while($row_file = $result->fetch_array(MYSQLI_ASSOC)){
		@unlink("uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/userdata/" . $row_file['file']);
		@unlink("uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/document/" . $row_file['file']);
		@unlink("uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/audio/" . $row_file['file']);
	}

	@unlink("uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/userdata/.htaccess");
	@rmdir("uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/userdata");
	@unlink("uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/document/.htaccess");
	@rmdir("uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/document");
	@unlink("uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/audio/.htaccess");
	@rmdir("uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/audio");
	@rmdir("uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number']);

	mysqli_query($conn, "	DELETE FROM	`order_orders_files` 
							WHERE 		`order_orders_files`.`order_id`='" . intval($_POST['id']) . "' 
							AND 		`order_orders_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

}

if((isset($_POST['move']) && $_POST['move'] == "ins Archiv") || (isset($_POST['move']) && $_POST['move'] == "Archiv")){

	$link = "neue-auftraege";

	$time = time();

	mysqli_query($conn, "	UPDATE	`order_orders` 
							SET 	`order_orders`.`mode`=1 
							WHERE 	`order_orders`.`id`='" . intval($_POST['id']) . "' 
							AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

	mysqli_query($conn, "	INSERT 	`order_orders_events` 
							SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
									`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
									`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
									`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
									`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag, ins Archiv verschoben, ID [#" . intval($_POST["id"]) . "]") . "', 
									`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag, ins Archiv verschoben, ID [#" . intval($_POST["id"]) . "]") . "', 
									`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
									`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

}

if(isset($_POST['upload']) && $_POST['upload'] == "hochladen"){

	$tab = "files";
	$link = "neue-auftraege";

	$emsg_files = "";

	$time = time();

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
			$emsg_files = "<p>Die upload Datengröße ist zu hoch. Es sind nur " . $upload_max_filesize . "MB insgesammt erlaubt!</p>";
		}
	}

	$uploaddir = 'uploads/';

	$files = "";

	$j = 1;

	$allowed = explode(",", str_replace(".", "", str_replace(", ", ",", $maindata['input_file_accept'])));

	if($emsg == ""){
		if(isset($_FILES["file"]["error"])){
			foreach($_FILES["file"]["error"] as $key => $error) {
				if ($j <= 5 && $_FILES["file"]["name"][$key] != "") {
					$ext = pathinfo($_FILES["file"]["name"][$key], PATHINFO_EXTENSION);
					if(in_array($ext, $allowed)){
						$random = rand(1, 100000);
						$_FILES["file"]["name"][$key] = preg_replace("/[^a-z0-9\_\-\.]/i", '', strip_tags(basename($_FILES["file"]["name"][$key])));
						move_uploaded_file($_FILES["file"]["tmp_name"][$key], $uploaddir . "company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/usaerdata/" . basename($random . '_' . $_FILES["file"]["name"][$key]));
						$files .= $files == "" ? $random . '_' . $_FILES["file"]["name"][$key] : "\r\n" . $random . '_' . $_FILES["file"]["name"][$key];
						mysqli_query($conn, "	INSERT 	`order_orders_files` 
												SET 	`order_orders_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
														`order_orders_files`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
														`order_orders_files`.`file`='" . mysqli_real_escape_string($conn, $random . '_' . $_FILES["file"]["name"][$key]) . "'");
					}else{
						$emsg_files .= "<p>Der Dateityp " . $ext . " ist nicht erlaubt, " . $_FILES["file"]["name"][$key] . "</p>\n";
					}
				}
				$j++;
			}
		}
	}

	if($emsg_files == "" && $files != ""){

		mysqli_query($conn, "	UPDATE 	`order_orders` 
								SET 	`order_orders`.`userdata`='" . mysqli_real_escape_string($conn, ($row_order['userdata'] == "" ? $files : $row_order['userdata'] . "\r\n" . $files)) . "' 
								WHERE 	`order_orders`.`id`='" . intval($_POST['id']) . "' 
								AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

		mysqli_query($conn, "	INSERT 	`order_orders_events` 
								SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
										`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
										`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag, Dateien hochgeladen, ID [#" . intval($_POST["id"]) . "]") . "', 
										`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag, Dateien hochgeladen, ID [#" . intval($_POST["id"]) . "]") . "', 
										`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "Dateien: [" . str_replace("\r\n", ", ", $files) . "]") . "', 
										`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

		$emsg_files = "<p>Der Auftrag wurde erfolgreich geändert!</p>\n";

	}

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['userdata_delete']) && $_POST['userdata_delete'] == "X"){

	$tab = "files";
	$link = "neue-auftraege";

	$time = time();

	$files = "";

	$arr_files = explode("\r\n", $row_order['userdata']);

	$file_id = 0;
	$file_name = "";

	for($i = 0;$i < count($arr_files);$i++){
		if($i == intval($_POST['item'])){
			@unlink("uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/userdata/" . $arr_files[$i]);
			$file_id = ($i + 1);
			$file_name = $arr_files[$i];
		}else{
			$files .= $files == "" ? $arr_files[$i] : "\r\n" . $arr_files[$i];
		}
	}

	mysqli_query($conn, "	UPDATE 	`order_orders` 
							SET 	`order_orders`.`userdata`='" . mysqli_real_escape_string($conn, $files) . "' 
							WHERE 	`order_orders`.`id`='" . intval($_POST['id']) . "' 
							AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

	mysqli_query($conn, "	INSERT 	`order_orders_events` 
							SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
									`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
									`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
									`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
									`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Dateien, Datei entfernt, ID [#" . $file_id . "]") . "', 
									`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Dateien, Datei entfernt, ID [#" . $file_id . "]") . "', 
									`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "Name [" . $file_name . "]") . "', 
									`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['audio_delete']) && $_POST['audio_delete'] == "X"){

	$tab = "audio";
	$link = "neue-interessenten";

	$time = time();

	$files = "";

	$arr_files = explode("\r\n", $row_interested['audio']);

	$file_id = 0;
	$file_name = "";

	for($i = 0;$i < count($arr_files);$i++){
		if($i == intval($_POST['item'])){
			@unlink("uploads/company/" . intval($company_id) . "/order/" . $row_interested['order_number'] . "/document/" . $arr_files[$i]);
			$file_id = ($i + 1);
			$file_name = $arr_files[$i];
		}else{
			$files .= $files == "" ? $arr_files[$i] : "\r\n" . $arr_files[$i];
		}
	}

	mysqli_query($conn, "	UPDATE 	`order_orders` 
							SET 	`order_orders`.`audio`='" . mysqli_real_escape_string($conn, $files) . "' 
							WHERE 	`order_orders`.`id`='" . intval($_POST['id']) . "' 
							AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

	mysqli_query($conn, "	INSERT 	`order_orders_events` 
							SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
									`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
									`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
									`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
									`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Interessent, Dateien, Datei entfernt, ID [#" . $file_id . "]") . "', 
									`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Interessent, Dateien, Datei entfernt, ID [#" . $file_id . "]") . "', 
									`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "Name [" . $file_name . "]") . "', 
									`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['new_email']) && $_POST['new_email'] == "öffnen"){

	$tab = "new_status";
	$link = "neue-auftraege";

	$_POST['edit'] = "bearbeiten";

}

if((isset($_POST['new_email']) && $_POST['new_email'] == "senden") || (isset($_POST['new_email']) && $_POST['new_email'] == "sofort senden")){

	$tab = "new_status";
	$link = "neue-auftraege";

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

	if($_POST['new_email'] == "senden"){

		if(strlen($_POST['new_email_subject']) < 1 || strlen($_POST['new_email_subject']) > 128){
			$emsg .= "<small class=\"error text-muted\">Bitte einen Betreff eingeben. (max. 128 Zeichen)</small><br />\n";
			$inp_new_email_subject = " is-invalid";
		} else {
			$new_email_subject = strip_tags($_POST['new_email_subject']);
		}

		if(strlen($_POST['new_email_body']) < 1){
			$emsg .= "<small class=\"error text-muted\">Bitte eine Nachricht eingeben.</small><br />\n";
			$inp_new_email_body = " is-invalid";
		} else {
			$new_email_body = $_POST['new_email_body'];
		}

	}

	if($emsg == ""){

		$row_reason = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `reasons` WHERE `reasons`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `reasons`.`id`='" . intval($row_order['component']) . "'"), MYSQLI_ASSOC);
		$row_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . intval($row_order['country']) . "'"), MYSQLI_ASSOC);
		$row_differing_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . intval($row_order['differing_country']) . "'"), MYSQLI_ASSOC);

		$row_status = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `statuses`.`id`='" . $maindata['email_status'] . "'"), MYSQLI_ASSOC);

		$time = time();

		$status_number = intval($maindata['admin_id']) . "A" . date("dmYHis", time());

		$domain = isset($_SERVER['HTTPS']) ? "https://" . $_SERVER['HTTP_HOST'] : "http://" . $_SERVER['HTTP_HOST'];

		$uploaddir = 'uploads/';

		$files = "";
		$links = "";
		$docs = "";
		$allowed = explode(",", str_replace(".", "", str_replace(", ", ",", $maindata['input_file_accept'])));
		if(isset($_FILES["file"]["error"])){
			foreach($_FILES["file"]["error"] as $key => $error) {
				if ($j <= 5 && $_FILES["file"]["name"][$key] != "") {
					$ext = pathinfo($_FILES["file"]["name"][$key], PATHINFO_EXTENSION);
					if(in_array($ext, $allowed)){
						$random = rand(1, 100000);
						$_FILES["file"]["name"][$key] = preg_replace("/[^a-z0-9\_\-\.]/i", '', strip_tags(basename($_FILES["file"]["name"][$key])));
						move_uploaded_file($_FILES["file"]["tmp_name"][$key], $uploaddir . "company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/userdata/" . basename($random . '_' . $_FILES["file"]["name"][$key]));
						$files .= $files == "" ? $random . '_' . $_FILES["file"]["name"][$key] : "\r\n" . $random . '_' . $_FILES["file"]["name"][$key];
						$links .= $links == "" ? "<a href=\"" . $domain . "/uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/userdata/" . $random . '_' . $_FILES["file"]["name"][$key] . "\">" . $random . '_' . $_FILES["file"]["name"][$key] . "</a>\n" : "<br /><a href=\"" . $domain . "/uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/userdata/" . $random . '_' . $_FILES["file"]["name"][$key] . "\">" . $random . '_' . $_FILES["file"]["name"][$key] . "</a>\n";
						$docs .= $docs == "" ? $random . '_' . $_FILES["file"]["name"][$key] : ", " . $random . '_' . $_FILES["file"]["name"][$key];
						mysqli_query($conn, "	INSERT 	`order_orders_files` 
												SET 	`order_orders_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
														`order_orders_files`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "', 
														`order_orders_files`.`file`='" . mysqli_real_escape_string($conn, $random . '_' . $_FILES["file"]["name"][$key]) . "'");
					}
				}
				$j++;
			}
		}
		$links = $links == "" ? "" : "	<table cellspacing=\"3\" cellpadding=\"3\" border=\"0\"><tr><td width=\"200\" valign=\"top\"><span>Dateien:</span></td><td>" . $links . "</td></tr></table><br />\n";

		$row_template = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `templates` WHERE `templates`.`id`='" . intval($_POST['email_template']) . "'"), MYSQLI_ASSOC);

		if($_POST['new_email'] == "senden"){

			$row_template['subject'] = $new_email_subject;

			$row_template['body'] = $new_email_body;

		}

		$row_template['body'] .= $row_admin['email_signature'];

		$fields = array('subject', 'body', 'admin_mail_subject');

		for($j = 0;$j < count($fields);$j++){

			$row_template[$fields[$j]] = str_replace("[status_id]", $status_number, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[status]", $row_status["name"], $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[id]", $row_order['order_number'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[date]", date("d.m.Y (H:i)", $time), $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[machine]", strip_tags($row_order['machine']), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[model]", strip_tags($row_order['model']), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[constructionyear]", strip_tags($row_order['constructionyear']), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[carid]", strip_tags($row_order['carid']), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[vin_html]", htmlentities($row_order['vin_html']), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[kw]", strip_tags($row_order['kw']), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[mileage]", number_format(intval($row_order['mileage']), 0, '', '.') . " km", $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[mechanism]", ($row_order['mechanism'] == 0 ? "Schaltung" : "Automatik"), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[fuel]", ($row_order['fuel'] == 0 ? "Benzin" : "Diesel"), $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[reason]", $row_order['reason'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[description]", $row_order['description'], $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[files]", $links, $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[companyname]", $row_order['companyname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[gender]", (isset($_POST['gender']) && $_POST['gender'] == 1 ? "Sehr geehrte Frau" : "Sehr geehrter Herr"), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[sexual]", (isset($_POST['gender']) && $_POST['gender'] == 1 ? "Frau" : "Herr"), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[firstname]", $row_order['firstname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[lastname]", $row_order['lastname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[street]", $row_order['street'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[streetno]", $row_order['streetno'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[zipcode]", $row_order['zipcode'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[city]", $row_order['city'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[country]", $row_country['name'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[phonenumber]", $row_order['phonenumber'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[mobilnumber]", $row_order['mobilnumber'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[email]", "<a href=\"mailto: " . $row_order['email'] . "\">" . $row_order['email'] . "</a>\n", $row_template[$fields[$j]]);

			$html_differing_shipping_address = 	$differing_shipping_address == 0 ? 
											"" : 
											"<h4>Abweichende Lieferadresse</h4>\n" . 
											"<table cellspacing=\"3\" cellpadding=\"3\" border=\"0\">\n" . 
											"	<tr><td width=\"200\"><span>Firma:</span></td><td><strong>[differing_companyname]</strong></td></tr>\n" . 
											"	<tr><td><span>Vorname:</span></td><td><strong>[differing_firstname]</strong></td></tr>\n" . 
											"	<tr><td><span>Nachname:</span></td><td><strong>[differing_lastname]</strong></td></tr>\n" . 
											"	<tr><td><span>Straße:</span></td><td><strong>[differing_street]</strong></td></tr>\n" . 
											"	<tr><td><span>Hausnummer:</span></td><td><strong>[differing_streetno]</strong></td></tr>\n" . 
											"	<tr><td><span>PLZ:</span></td><td><strong>[differing_zipcode]</strong></td></tr>\n" . 
											"	<tr><td><span>Ort:</span></td><td><strong>[differing_city]</strong></td></tr>\n" . 
											"	<tr><td><span>Land:</span></td><td><strong>[differing_country]</strong></td></tr>\n" . 
											"</table>\n" . 
											"<br />\n";

			$row_template[$fields[$j]] = str_replace("[differing_shipping_address]", $html_differing_shipping_address, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_companyname]", $row_order['differing_companyname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_firstname]", $row_order['differing_firstname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_lastname]", $row_order['differing_lastname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_street]", $row_order['differing_street'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_streetno]", $row_order['differing_streetno'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_zipcode]", $row_order['differing_zipcode'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_city]", $row_order['differing_city'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_country]", $row_differing_country['name'], $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[pricemwst]", number_format($row_order['pricemwst'], 2, ',', '') . " €", $row_template[$fields[$j]]);
			$radio_radio_shipping = array(	0 => "Expressversand", 
											1 => "Standardversand", 
											2 => "International", 
											3 => "Abholung");
			$row_template[$fields[$j]] = str_replace("[radio_shipping]", $radio_radio_shipping[$row_order['radio_shipping']], $row_template[$fields[$j]]);
			$radio_radio_payment = array(	0 => "Überweisung (Sie überweisen den Rechnungsbetrag per Überweisung)", 
											1 => "Nachnahme", 
											2 => "Bar");
			$row_template[$fields[$j]] = str_replace("[radio_payment]", $radio_radio_payment[$row_order['radio_payment']], $row_template[$fields[$j]]);

		}

		mysqli_query($conn, "	INSERT 	`order_orders_statuses` 
								SET 	`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
										`order_orders_statuses`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
										`order_orders_statuses`.`status_number`='" . mysqli_real_escape_string($conn, $status_number) . "', 
										`order_orders_statuses`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`order_orders_statuses`.`status_id`='" . mysqli_real_escape_string($conn, $maindata['email_status']) . "', 
										`order_orders_statuses`.`template`='" . mysqli_real_escape_string($conn, $row_template['name']) . "', 
										`order_orders_statuses`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
										`order_orders_statuses`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
										`order_orders_statuses`.`public`='1', 
										`order_orders_statuses`.`time`='" . $time . "'");

		$_SESSION["status"]["id"] = $conn->insert_id;

		mysqli_query($conn, "	INSERT 	`order_orders_emails` 
								SET 	`order_orders_emails`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
										`order_orders_emails`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`order_orders_emails`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
										`order_orders_emails`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
										`order_orders_emails`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
										`order_orders_emails`.`time`='" . $time . "'");

		$_SESSION["emails"]["id"] = $conn->insert_id;

		mysqli_query($conn, "	INSERT 	`order_orders_events` 
								SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
										`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
										`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "E-Mail - " . $row_template['name'] . ", gesendet, ID [#" . $_SESSION["emails"]["id"] . "]") . "', 
										`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
										`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
										`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

		if(($_POST['new_email'] == "senden" && isset($_POST['mail_with_pdf']) && intval($_POST['mail_with_pdf']) == 1) || ($_POST['new_email'] == "sofort senden" && $row_template['mail_with_pdf'] == 1)){

			$filename = "begleitschein.pdf";

			$pdf = new Fpdi();

			$pdf->AddPage();

			require('includes/email_template_pdf_code_' . $row_template['id'] . '.php');

			$pdfdoc = $pdf->Output("", "S");

			if(($_POST['new_email'] == "senden" && isset($_POST['usermail']) && intval($_POST['usermail']) == 1 && $row_order['email'] != "") || ($_POST['new_email'] == "sofort senden" && $row_status['usermail'] == 1 && $row_order['email'] != "")){

				$mail = new dbbMailer();

				$mail->host = $maindata['smtp_host'];
				$mail->username = $maindata['smtp_username'];
				$mail->password = $maindata['smtp_password'];
				$mail->secure = $maindata['smtp_secure'];
				$mail->port = intval($maindata['smtp_port']);
				$mail->charset = $maindata['smtp_charset'];
 
				$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
				$mail->addAddress($row_order['email'], $row_order['firstname'] . " " . $row_order['lastname']);

				//$mail->addAttachment(dirname(__FILE__) . "/../../temp/condition.tar");

				$mail->addStringAttachment($pdfdoc, $filename, 'base64', 'application/pdf');

				$mail->subject = strip_tags($row_template['subject']);

				$mail->body = str_replace("[track]", "", $row_template['body']);

				if(!$mail->send()){

				}

			}

			if(($_POST['new_email'] == "senden" && isset($_POST['adminmail']) && intval($_POST['adminmail']) == 1) || ($_POST['new_email'] == "sofort senden" && $row_status['adminmail'] == 1)){

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

			if(($_POST['new_email'] == "senden" && isset($_POST['usermail']) && intval($_POST['usermail']) == 1 && $row_order['email'] != "") || ($_POST['new_email'] == "sofort senden" && $row_status['usermail'] == 1 && $row_order['email'] != "")){

				$mail = new dbbMailer();

				$mail->host = $maindata['smtp_host'];
				$mail->username = $maindata['smtp_username'];
				$mail->password = $maindata['smtp_password'];
				$mail->secure = $maindata['smtp_secure'];
				$mail->port = intval($maindata['smtp_port']);
				$mail->charset = $maindata['smtp_charset'];
 
				$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
				$mail->addAddress($row_order['email'], $row_order['firstname'] . " " . $row_order['lastname']);

				$mail->subject = strip_tags($row_template['subject']);

				$mail->body = str_replace("[track]", "", $row_template['body']);

				if(!$mail->send()){

				}

			}

			if(($_POST['new_email'] == "senden" && isset($_POST['adminmail']) && intval($_POST['adminmail']) == 1) || ($_POST['new_email'] == "sofort senden" && $row_status['adminmail'] == 1)){

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

	}else{

		$_POST['new_email'] = "öffnen";

	}

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['new_status']) && $_POST['new_status'] == "öffnen"){

	$tab = "new_status";
	$link = "neue-auftraege";

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['new_status']) && $_POST['new_status'] == "durchführen"){

	$tab = "new_status";
	$link = "neue-auftraege";

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

		$time = time();

		$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `order_orders`.`user_id`='" . $_SESSION["user"]["id"] . "' AND `order_orders`.`id`='" . intval($_POST['id']) . "'"), MYSQLI_ASSOC);
		$row_reason = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `reasons` WHERE `reasons`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `reasons`.`id`='" . intval($row_order['component']) . "'"), MYSQLI_ASSOC);
		$row_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . intval($row_order['country']) . "'"), MYSQLI_ASSOC);
		$row_differing_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . intval($row_order['differing_country']) . "'"), MYSQLI_ASSOC);
		$row_status = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `statuses`.`id`='" . intval($_POST['status_id']) . "'"), MYSQLI_ASSOC);
		$row_template = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `templates` WHERE `templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'  AND `templates`.`id`='" . intval($row_status['email_template']) . "'"), MYSQLI_ASSOC);

		$row_template['body'] .= $row_admin['email_signature'];

		$status_number = intval($maindata['admin_id']) . "A" . date("dmYHis", time());

		$domain = isset($_SERVER['HTTPS']) ? "https://" . $_SERVER['HTTP_HOST'] : "http://" . $_SERVER['HTTP_HOST'];

		$uploaddir = 'uploads/';

		$files = "";
		$links = "";
		$docs = "";
		$allowed = explode(",", str_replace(".", "", str_replace(", ", ",", $maindata['input_file_accept'])));
		if(isset($_FILES["file"]["error"])){
			foreach($_FILES["file"]["error"] as $key => $error) {
				if ($j <= 5 && $_FILES["file"]["name"][$key] != "") {
					$ext = pathinfo($_FILES["file"]["name"][$key], PATHINFO_EXTENSION);
					if(in_array($ext, $allowed)){
						$random = rand(1, 100000);
						$_FILES["file"]["name"][$key] = preg_replace("/[^a-z0-9\_\-\.]/i", '', strip_tags(basename($_FILES["file"]["name"][$key])));
						move_uploaded_file($_FILES["file"]["tmp_name"][$key], $uploaddir . "company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/userdata/" . basename($random . '_' . $_FILES["file"]["name"][$key]));
						$files .= $files == "" ? $random . '_' . $_FILES["file"]["name"][$key] : "\r\n" . $random . '_' . $_FILES["file"]["name"][$key];
						$links .= $links == "" ? "<a href=\"" . $domain . "/uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/userdata/" . $random . '_' . $_FILES["file"]["name"][$key] . "\">" . $random . '_' . $_FILES["file"]["name"][$key] . "</a>\n" : "<br /><a href\"" . $domain . "/uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/userdata/" . $random . '_' . $_FILES["file"]["name"][$key] . "\">" . $random . '_' . $_FILES["file"]["name"][$key] . "</a>\n";
						$docs .= $docs == "" ? $random . '_' . $_FILES["file"]["name"][$key] : ", " . $random . '_' . $_FILES["file"]["name"][$key];
						mysqli_query($conn, "	INSERT 	`order_orders_files` 
												SET 	`order_orders_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
														`order_orders_files`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "', 
														`order_orders_files`.`file`='" . mysqli_real_escape_string($conn, $random . '_' . $_FILES["file"]["name"][$key]) . "'");
					}
				}
				$j++;
			}
		}

		$links = $links == "" ? "" : "	<table cellspacing=\"3\" cellpadding=\"3\" border=\"0\"><tr><td width=\"200\" valign=\"top\"><span>Dateien:</span></td><td>" . $links . "</td></tr></table><br />\n";

		$fields = array('subject', 'body', 'admin_mail_subject');

		for($j = 0;$j < count($fields);$j++){

			$row_template[$fields[$j]] = str_replace("[id]", $row_order['order_number'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[date]", date("d.m.Y (H:i)", $time), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[status_id]", $status_number, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[status]", $row_status['name'], $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[machine]", strip_tags($row_order['machine']), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[model]", strip_tags($row_order['model']), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[constructionyear]", strip_tags($row_order['constructionyear']), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[carid]", strip_tags($row_order['carid']), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[vin_html]", htmlentities($row_order['vin_html']), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[kw]", strip_tags($row_order['kw']), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[mileage]", number_format(intval($row_order['mileage']), 0, '', '.') . " km", $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[mechanism]", ($row_order['mechanism'] == 0 ? "Schaltung" : "Automatik"), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[fuel]", ($row_order['fuel'] == 0 ? "Benzin" : "Diesel"), $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[reason]", $row_order['reason'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[description]", $row_order['description'], $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[files]", $links, $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[companyname]", $row_order['companyname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[gender]", ($row_order['gender'] == 1 ? "Sehr geehrte Frau" : "Sehr geehrter Herr"), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[sexual]", ($row_order['gender'] == 1 ? "Frau" : "Herr"), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[firstname]", $row_order['firstname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[lastname]", $row_order['lastname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[street]", $row_order['street'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[streetno]", $row_order['streetno'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[zipcode]", $row_order['zipcode'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[city]", $row_order['city'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[country]", $row_country['name'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[phonenumber]", $row_order['phonenumber'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[mobilnumber]", $row_order['mobilnumber'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[email]", "<a href=\"mailto: " . $row_order['email'] . "\">" . $row_order['email'] . "</a>\n", $row_template[$fields[$j]]);

			$html_differing_shipping_address = 	$differing_shipping_address == 0 ? 
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

			$row_template[$fields[$j]] = str_replace("[differing_shipping_address]", $html_differing_shipping_address, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_companyname]", $row_order['differing_companyname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_firstname]", $row_order['differing_firstname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_lastname]", $row_order['differing_lastname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_street]", $row_order['differing_street'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_streetno]", $row_order['differing_streetno'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_zipcode]", $row_order['differing_zipcode'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_city]", $row_order['differing_city'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_country]", $row_differing_country['name'], $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[pricemwst]", number_format($row_order['pricemwst'], 2, ',', '') . " €", $row_template[$fields[$j]]);
			$radio_radio_shipping = array(	0 => "Expressversand", 
											1 => "Standardversand", 
											2 => "International", 
											3 => "Abholung");
			$row_template[$fields[$j]] = str_replace("[radio_shipping]", $radio_radio_shipping[$row_order['radio_shipping']], $row_template[$fields[$j]]);
			$radio_radio_payment = array(	0 => "Überweisung (Sie überweisen den Rechnungsbetrag per Überweisung)", 
											1 => "Nachnahme", 
											2 => "Bar");
			$row_template[$fields[$j]] = str_replace("[radio_payment]", $radio_radio_payment[$row_order['radio_payment']], $row_template[$fields[$j]]);

		}

		mysqli_query($conn, "	INSERT 	`order_orders_statuses` 
								SET 	`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
										`order_orders_statuses`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
										`order_orders_statuses`.`status_number`='" . mysqli_real_escape_string($conn, $status_number) . "', 
										`order_orders_statuses`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`order_orders_statuses`.`status_id`='" . mysqli_real_escape_string($conn, $row_status['id']) . "', 
										`order_orders_statuses`.`template`='" . mysqli_real_escape_string($conn, $row_template['name']) . "', 
										`order_orders_statuses`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
										`order_orders_statuses`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
										`order_orders_statuses`.`public`='1', 
										`order_orders_statuses`.`time`='" . $time . "'");

		$_SESSION["status"]["id"] = $conn->insert_id;

		mysqli_query($conn, "	INSERT 	`order_orders_events` 
								SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
										`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
										`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Verlauf, " . $row_status['name'] . ", ID [#" . $_SESSION["status"]["id"] . "]") . "', 
										`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
										`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
										`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

		if(isset($_POST['mail_with_pdf']) && intval($_POST['mail_with_pdf']) == 1){

			$filename = "begleitschein.pdf";

			$pdf = new Fpdi();

			$pdf->AddPage();

			require('includes/email_template_pdf_code_' . $row_template['id'] . '.php');

			$pdfdoc = $pdf->Output("", "S");

			if(isset($_POST['usermail']) && intval($_POST['usermail']) == 1 && $row_order['email'] != ""){

				$mail = new dbbMailer();

				$mail->host = $maindata['smtp_host'];
				$mail->username = $maindata['smtp_username'];
				$mail->password = $maindata['smtp_password'];
				$mail->secure = $maindata['smtp_secure'];
				$mail->port = intval($maindata['smtp_port']);
				$mail->charset = $maindata['smtp_charset'];
 
				$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
				$mail->addAddress($row_order['email'], $row_order['firstname'] . " " . $row_order['lastname']);

				//$mail->addAttachment(dirname(__FILE__) . "/../../temp/condition.tar");

				$mail->addStringAttachment($pdfdoc, $filename, 'base64', 'application/pdf');

				$mail->subject = strip_tags($row_template['subject']);

				$mail->body = str_replace("[track]", "", $row_template['body']);

				if(!$mail->send()){

				}

			}

			if(isset($_POST['adminmail']) && intval($_POST['adminmail']) == 1){

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

			if(isset($_POST['usermail']) && intval($_POST['usermail']) == 1 && $row_order['email'] != ""){

				$mail = new dbbMailer();

				$mail->host = $maindata['smtp_host'];
				$mail->username = $maindata['smtp_username'];
				$mail->password = $maindata['smtp_password'];
				$mail->secure = $maindata['smtp_secure'];
				$mail->port = intval($maindata['smtp_port']);
				$mail->charset = $maindata['smtp_charset'];
 
				$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
				$mail->addAddress($row_order['email'], $row_order['firstname'] . " " . $row_order['lastname']);

				$mail->subject = strip_tags($row_template['subject']);

				$mail->body = str_replace("[track]", "", $row_template['body']);

				if(!$mail->send()){

				}

			}

			if(isset($_POST['adminmail']) && intval($_POST['adminmail']) == 1){

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

	}else{

		$_POST['new_email'] = "öffnen";

	}

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['customer_message']) && $_POST['customer_message'] == "speichern"){

	$tab = "customer_message";
	$link = "neue-auftraege";

	if(strlen($_POST['message']) < 1 || strlen($_POST['message']) > 65536){
		$emsg .= "<small class=\"error text-muted\">Bitte eine Nachricht eingeben. (max. 65536 Zeichen)</small><br />\n";
		$inp_message = " is-invalid";
	} else {
		$message = $_POST['message'];
	}

	if($emsg == ""){

		$time = time();

		mysqli_query($conn, "	INSERT 	`order_orders_customer_messages` 
								SET 	`order_orders_customer_messages`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
										`order_orders_customer_messages`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`order_orders_customer_messages`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
										`order_orders_customer_messages`.`message`='" . mysqli_real_escape_string($conn, $message) . "', 
										`order_orders_customer_messages`.`time`='" . $time . "'");

		$_SESSION["customer_messages"]["id"] = $conn->insert_id;

		mysqli_query($conn, "	INSERT 	`order_orders_events` 
								SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
										`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
										`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Kundenhistory, Nachricht erstellt, ID [#" . $_SESSION["customer_messages"]["id"] . "]") . "', 
										`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Kundenhistory, Nachricht erstellt, ID [#" . $_SESSION["customer_messages"]["id"] . "]") . "', 
										`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, $message) . "', 
										`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

	}

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['customer_history_delete']) && $_POST['customer_history_delete'] == "X"){

	$tab = "customer_message";
	$link = "neue-auftraege";

	$time = time();

	mysqli_query($conn, "	DELETE FROM `order_orders_customer_messages` 
							WHERE 		`order_orders_customer_messages`.`id`='" . intval($_POST['customer_history_id']) . "' 
							AND 		`order_orders_customer_messages`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

	mysqli_query($conn, "	INSERT 	`order_orders_events` 
							SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
									`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
									`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, $_POST['id']) . "', 
									`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 2) . "', 
									`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Kundenhistorie, Nachricht entfernt, ID [#" . intval($_POST['customer_history_id']) . "]") . "', 
									`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Kundenhistorie, Nachricht entfernt, ID [#" . intval($_POST['customer_history_id']) . "]") . "', 
									`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
									`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['history']) && $_POST['history'] == "speichern"){

	$tab = "history";
	$link = "neue-auftraege";

	if(strlen($_POST['message']) < 1 || strlen($_POST['message']) > 65536){
		$emsg .= "<small class=\"error text-muted\">Bitte eine Nachricht eingeben. (max. 65536 Zeichen)</small><br />\n";
		$inp_message = " is-invalid";
	} else {
		$message = $_POST['message'];
	}

	if($emsg == ""){

		$time = time();

		mysqli_query($conn, "	INSERT 	`order_orders_history` 
								SET 	`order_orders_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
										`order_orders_history`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`order_orders_history`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
										`order_orders_history`.`message`='" . mysqli_real_escape_string($conn, $message) . "', 
										`order_orders_history`.`time`='" . $time . "'");

		$_SESSION["history"]["id"] = $conn->insert_id;

		mysqli_query($conn, "	INSERT 	`order_orders_events` 
								SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
										`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
										`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftragshistory, Nachricht erstellt, ID [#" . $_SESSION["history"]["id"] . "]") . "', 
										`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftragshistory, Nachricht erstellt, ID [#" . $_SESSION["history"]["id"] . "]") . "', 
										`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, $message) . "', 
										`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

	}

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['history_status']) && $_POST['history_status'] == "speichern"){

	$tab = "history";
	$link = "neue-auftraege";

	$time = time();

	mysqli_query($conn, "	UPDATE 	`order_orders_history` 
							SET 	`order_orders_history`.`status`='" . mysqli_real_escape_string($conn, intval($_POST['status'])) . "' 
							WHERE 	`order_orders_history`.`id`='" . intval($_POST['history_id']) . "' 
							AND 	`order_orders_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

	mysqli_query($conn, "	INSERT 	`order_orders_events` 
							SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
									`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
									`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
									`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
									`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftragshistorie, Nachricht, Status geändert, ID [#" . intval($_POST['history_id']) . "]") . "', 
									`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftragshistorie, Nachricht, Status geändert, ID [#" . intval($_POST['history_id']) . "]") . "', 
									`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
									`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['history_delete']) && $_POST['history_delete'] == "X"){

	$tab = "history";
	$link = "neue-auftraege";

	$time = time();

	mysqli_query($conn, "	DELETE FROM 	`order_orders_history` 
							WHERE 			`order_orders_history`.`id`='" . intval($_POST['history_id']) . "' 
							AND 			`order_orders_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

	mysqli_query($conn, "	INSERT 	`order_orders_events` 
							SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
									`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
									`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, $_POST['id']) . "', 
									`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 2) . "', 
									`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftragshistorie, Nachricht entfernt, ID [#" . intval($_POST['history_id']) . "]") . "', 
									`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftragshistorie, Nachricht entfernt, ID [#" . intval($_POST['history_id']) . "]") . "', 
									`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
									`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['new_shipping']) && $_POST['new_shipping'] == "öffnen"){

	$tab = "new_shipping_tab";
	$link = "neue-auftraege";

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['tracking_tab']) && $_POST['tracking_tab'] == "öffnen"){

	$tab = "tracking_tab";
	$link = "neue-auftraege";

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['user_search']) && $_POST['user_search'] == "suchen"){

	$tab = "add_user";
	$link = "neue-auftraege";

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['add_user']) && $_POST['add_user'] == "zuweisen"){

	$tab = "add_user";
	$link = "neue-auftraege";

	$time = time();

	if($emsg == ""){

		mysqli_query($conn, "	UPDATE 	`order_orders` 
								SET 	`order_orders`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`order_orders`.`user_id`='" . mysqli_real_escape_string($conn, intval($_SESSION['user']['id'])) . "', 
										`order_orders`.`upd_date`='" . $time . "' 
								WHERE 	`order_orders`.`id`='" . intval($_POST['id']) . "' 
								AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

		mysqli_query($conn, "	INSERT 	`order_orders_events` 
								SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
										`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
										`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag, Kunde zugewiesen, ID [#" . intval($_POST["id"]) . "]") . "', 
										`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag, Kunde zugewiesen, ID [#" . intval($_POST["id"]) . "]") . "', 
										`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
										`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

		$emsg = "<p>Der Auftrag wurde erfolgreich geändert!</p>\n";

	}

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['interested_search']) && $_POST['interested_search'] == "suchen"){

	$tab = "add_interested";
	$link = "neue-auftraege";

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['add_interested']) && $_POST['add_interested'] == "zuweisen"){

	$tab = "add_interested";
	$link = "neue-auftraege";

	$time = time();

	if($emsg == ""){

		mysqli_query($conn, "	UPDATE 	`order_orders` 
								SET 	`order_orders`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`order_orders`.`interested_id`='" . mysqli_real_escape_string($conn, intval($_POST['interested_id'])) . "', 
										`order_orders`.`upd_date`='" . $time . "' 
								WHERE 	`order_orders`.`id`='" . intval($_POST['id']) . "' 
								AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

		mysqli_query($conn, "	INSERT 	`order_orders_events` 
								SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
										`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
										`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag, Interessent zugewiesen, ID [#" . intval($_POST["id"]) . "]") . "', 
										`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag, Interessent zugewiesen, ID [#" . intval($_POST["id"]) . "]") . "', 
										`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
										`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

		$emsg = "<p>Der Auftrag wurde erfolgreich geändert!</p>\n";

	}

	$_POST['edit'] = "bearbeiten";

}

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$list = "";

$where = 	isset($_SESSION["user_orders"]["keyword"]) && $_SESSION["user_orders"]["keyword"] != "" ? 
			"WHERE 	(`order_orders`.`id` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`order_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`ref_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`customer_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`call_date` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`machine` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`constructionyear` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`carid` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`mileage` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`component` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`manufacturer` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`serial` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`fromthiscar` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`reason` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`description` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`files` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`companyname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`firstname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`lastname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`street` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`streetno` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`zipcode` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`city` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`country` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`phonenumber` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`mobilnumber` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`email` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`differing_shipping_address` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`differing_companyname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`differing_firstname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`differing_lastname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`differing_street` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`differing_streetno` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`differing_zipcode` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`differing_city` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`differing_country` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%') " : 
			"";

$and = $where == "" ? "WHERE `order_orders`.`mode`=0 " : " AND `order_orders`.`mode`=0 ";
$and .= "AND `order_orders`.`user_id`='" . $_SESSION['user']['id'] . "' ";
$and .= isset($_SESSION["user_orders"]["extra_search"]) && $_SESSION["user_orders"]["extra_search"] > 0 ? "AND (SELECT 	(SELECT `statuses`.`id` AS id FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `statuses`.`id`=`order_orders_statuses`.`status_id`) AS id FROM `order_orders_statuses` WHERE `order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `order_orders_statuses`.`order_id`=`order_orders`.`id` ORDER BY CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC limit 0, 1)=" . $_SESSION["user_orders"]["extra_search"] : "";

$query = 	"	SELECT 		`order_orders`.`id` AS id, 
							`order_orders`.`order_number` AS order_number, 
							`order_orders`.`companyname` AS companyname, 
							`order_orders`.`firstname` AS firstname, 
							`order_orders`.`lastname` AS lastname, 
							`order_orders`.`run_date` AS run_date, 
							`order_orders`.`reg_date` AS reg_date, 
							`order_orders`.`cpy_date` AS cpy_date, 
							`order_orders`.`upd_date` AS time, 

							(SELECT `admin`.`name` AS name FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `admin`.`id`=`order_orders`.`admin_id`) AS admin_name, 

							(	SELECT 	(SELECT `statuses`.`name` AS name FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `statuses`.`id`=`order_orders_statuses`.`status_id`) AS name 
								FROM 	`order_orders_statuses` 
								WHERE 	`order_orders_statuses`.`order_id`=`order_orders`.`id` 
								AND 	`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
								ORDER BY CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_name, 

							(	SELECT 	(SELECT `statuses`.`color` AS color FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `statuses`.`id`=`order_orders_statuses`.`status_id`) AS color 
								FROM 	`order_orders_statuses` 
								WHERE 	`order_orders_statuses`.`order_id`=`order_orders`.`id` 
								AND 	`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
								ORDER BY CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_color, 

							(	SELECT 	(SELECT `statuses`.`id` AS id FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `statuses`.`id`=`order_orders_statuses`.`status_id`) AS id 
								FROM 	`order_orders_statuses` 
								WHERE 	`order_orders_statuses`.`order_id`=`order_orders`.`id` 
								AND 	`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
								ORDER BY CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_id, 

							`order_orders`.`admin_id` AS admin_id 
							
				FROM 		`order_orders` 
				" . $where . $and . " 
				AND 		`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
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

if($rows > 0){

	while($row_orders = $result->fetch_array(MYSQLI_ASSOC)){

		$list .= 	"<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
					"	<tr" . (isset($_POST['id']) && $_POST['id'] == $row_orders['id'] ? " class=\"bg-primary text-white\"" : "") . " onclick=\"$('#order_list_" . $row_orders['id'] . "').prop('checked', !$('#order_list_" . $row_orders['id'] . "').prop('checked'))\">\n" . 
					"		<td scope=\"row\">\n" . 
					"			<div class=\"custom-control custom-checkbox mt-1 ml-2\">\n" . 
					"				<input type=\"checkbox\" id=\"order_list_" . $row_orders['id'] . "\" data-id=\"" . $row_orders['id'] . "\" class=\"custom-control-input order-list\" />\n" . 
					"				<label class=\"custom-control-label\" for=\"order_list_" . $row_orders['id'] . "\"></label>\n" . 
					"			</div>\n" . 
					"		</td>\n" . 
					"		<td scope=\"row\" align=\"center\">\n" . 
					"			" . intval(($row_orders['cpy_date'] - $row_orders['run_date']) / 60) . "\n" . 
					"		</td>\n" . 
					"		<td scope=\"row\" align=\"center\">\n" . 
					"			<small>" . $row_orders['order_number'] . "</small>\n" . 
					"		</td>\n" . 
					"		<td>\n" . 
					"			<small>" . date("d.m.Y", $row_orders['time']) . "</small> <small class=\"text-muted\">" . date("(H:i)", $row_orders['time']) . "</small>\n" . 
					"		</td>\n" . 
					"		<td>\n" . 
					"			<small>" . $row_orders['admin_name'] . "</small>\n" . 
					"		</td>\n" . 
					"		<td align=\"center\">\n" . 
					"			<span class=\"badge badge-pill\" style=\"background-color: " . $row_orders['status_color'] . "\">" . $row_orders['status_name'] . "</span>\n" . 
					"		</td>\n" . 
					"		<td>\n" . 
					"			<small>" . ($row_orders['companyname'] != "" ? $row_orders['companyname'] . ", " : "") . $row_orders['firstname'] . " " . $row_orders['lastname'] . "</small>\n" . 
					"		</td>\n" . 
					"		<td align=\"center\">\n" . 
					"			<input type=\"hidden\" name=\"id\" value=\"" . $row_orders['id'] . "\" />\n" . 
					"			<button type=\"submit\" name=\"edit\" value=\"ansehen\" class=\"btn btn-sm btn-success\">ansehen</button>\n" . 
					"		</td>\n" . 
					"	</tr>\n" . 
					"</form>\n";

	}

}else{

	$list = isset($_POST['search']) && $_POST['search'] == "suchen" ? "<script>alert('Es wurden keine mit Ihrer Suchanfrage - " . $_SESSION["user_orders"]["keyword"] . " - übereinstimmende Aufträge gefunden.')</script>\n" : "";

}

$result_statuses = mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `statuses`.`type`='1' AND `statuses`.`extra_search`='1' ORDER BY CAST(`statuses`.`id` AS UNSIGNED) ASC");

$extra_search_options = "						<option value=\"0\"" . (isset($_SESSION['user_orders']['extra_search']) && $_SESSION['user_orders']['extra_search'] == 0 ? " selected=\"selected\"" : "") . ">Alle Vorgänge</option>\n";

while($row = $result_statuses->fetch_array(MYSQLI_ASSOC)){
	$extra_search_options .= "						<option value=\"" . $row['id'] . "\"" . (isset($_SESSION['user_orders']['extra_search']) && $_SESSION['user_orders']['extra_search'] == $row['id'] ? " selected=\"selected\"" : "") . ">" . $row['name'] . "</option>\n";
}

$result_statuses = mysqli_query($conn, "	SELECT 		* 
											FROM 		`statuses` 
											WHERE 		`statuses`.`type`='1' 
											AND 		`statuses`.`multi_status`='1' 
											AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
											ORDER BY 	CAST(`statuses`.`id` AS UNSIGNED) ASC");

$multi_search_options = "";

while($row = $result_statuses->fetch_array(MYSQLI_ASSOC)){
	$multi_search_options .= "						<option value=\"" . $row['id'] . "\">" . $row['name'] . "</option>\n";
}

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">\n" . 
		"		" . (!isset($_POST['delete']) && isset($_POST['id']) && intval($_POST['id']) > 0 ? "<h3>Auftragsnummer: " . $row_order['order_number'] . "</h3><p id=\"user_info\" class=\"mb-0\">" . ($row_order['companyname'] != "" ? "Firma: " . $row_order['companyname'] . ", " : "") . "Name: " . ($row_order['gender'] == 1 ? "Frau" : "Herr") . " " . $row_order['firstname'] . " " . $row_order['lastname'] . "</p>" : (isset($_POST['add']) && $_POST['add'] == "hinzufügen" ? "<h3>Neuer Auftrag</h3>" : "<h3>Auftragsübersicht</h3>")) . "\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<hr />\n" . 
		"<div class=\"row\">\n" . 
		"	<div class=\"col-sm-7\">\n" . 
		"		<ul class=\"nav nav-pills\">\n" . 
		"			<li class=\"nav-item\"><a href=\"/kunden/auftraege\" class=\"nav-link" . ($link == "neue-auftraege" ? " active" : "") . "\">Aufträge</a></li>\n" . 
		"			<li class=\"nav-item\"><a href=\"/kunden/auftraege-archiv\" class=\"nav-link\">Archiv</a></li>\n" . 
		"			<li class=\"nav-item\"><a href=\"/kunden/auftraege/neuer-auftrag\" class=\"nav-link" . ($link == "neuer-auftrag" ? " active" : "") . "\">Neuer Auftrag</a></li>\n" . 
		"		</ul>\n" . 
		"	</div>\n" . 
		"	<div class=\"col-sm-5 text-right\">\n" . 
		"		<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"			<div class=\"form-group row mb-0\">\n" . 
		"				<div class=\"col-sm-12\">\n" . 
		"					<div class=\"btn-group\">\n" . 
		"						<input type=\"text\" id=\"keyword\" name=\"keyword\" value=\"" . (isset($_SESSION['user_orders']['keyword']) && $_SESSION['user_orders']['keyword'] != "" ? $_SESSION['user_orders']['keyword'] : "") . "\" placeholder=\"Suchbegriff / Barcode\" aria-label=\"Suchbegriff / Barcode\" class=\"form-control bg-" . $row_admin["bgcolor_select"] . " text-" . $row_admin["color_select"] . " border border-" . $row_admin["border_select"] . "\" style=\"border-radius: .25rem 0 0 .25rem\" />\n" . 
		"						<button type=\"submit\" name=\"search\" value=\"suchen\" class=\"btn btn-primary\"><i class=\"fa fa-search\" aria-hidden=\"true\"></i></button>\n" . 
		"						<button type=\"button\" class=\"btn btn-secondary dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" onclick=\"$('.my-dropdown-menu').slideToggle(0)\"></button>\n" . 
		"						<div class=\"my-dropdown-menu bg-white rounded-bottom border border-primary p-3\" style=\"position: absolute;top: 40px;right: 0px;display: none;box-shadow: 0 0 4px #000;z-Index: 1000\">\n" . 
		"							<h6 class=\"text-left\">Einträge&nbsp;pro&nbsp;Seite</h6>\n" . 
		"							<select id=\"rows\" name=\"rows\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 
		"								<option value=\"10\"" . ($amount_rows == 10 ? " selected=\"selected\"" : "") . ">10</option>\n" . 
		"								<option value=\"20\"" . ($amount_rows == 20 ? " selected=\"selected\"" : "") . ">20</option>\n" . 
		"								<option value=\"40\"" . ($amount_rows == 40 ? " selected=\"selected\"" : "") . ">40</option>\n" . 
		"								<option value=\"50\"" . ($amount_rows == 50 ? " selected=\"selected\"" : "") . ">50</option>\n" . 
		"								<option value=\"60\"" . ($amount_rows == 60 ? " selected=\"selected\"" : "") . ">60</option>\n" . 
		"								<option value=\"80\"" . ($amount_rows == 80 ? " selected=\"selected\"" : "") . ">80</option>\n" . 
		"								<option value=\"100\"" . ($amount_rows == 100 ? " selected=\"selected\"" : "") . ">100</option>\n" . 
		"								<option value=\"200\"" . ($amount_rows == 200 ? " selected=\"selected\"" : "") . ">200</option>\n" . 
		"								<option value=\"400\"" . ($amount_rows == 400 ? " selected=\"selected\"" : "") . ">400</option>\n" . 
		"								<option value=\"500\"" . ($amount_rows == 500 ? " selected=\"selected\"" : "") . ">500</option>\n" . 
		"							</select>\n" . 
		"							<h6 class=\"text-left mt-2\">Sortierfeld</h6>\n" . 
		"							<select id=\"sorting_field\" name=\"sorting_field\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 

		$sorting_field_options . 

		"							</select>\n" . 
		"							<h6 class=\"text-left mt-2\">Sortierrichtung</h6>\n" . 
		"							<select id=\"sorting_direction\" name=\"sorting_direction\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 
		"								<option value=\"0\"" . ($sorting_direction_value == 0 ? " selected=\"selected\"" : "") . ">Aufsteigend</option>\n" . 
		"								<option value=\"1\"" . ($sorting_direction_value == 1 ? " selected=\"selected\"" : "") . ">Absteigend</option>\n" . 
		"							</select>\n" . 
		"							<hr />\n" . 
		"							<select id=\"extra_search\" name=\"extra_search\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 

		$extra_search_options . 

		"							</select>\n" . 
		"						</div>\n" . 
		"					</div>\n" . 
		"				</div>\n" . 
		"			</div>\n" . 
		"		</form>\n" . 
		"	</div>\n" . 
		"</div>\n";

if(!isset($_POST['add']) && !isset($_POST['edit']) && !isset($_POST['save']) && !isset($_POST['update'])){

	$html .= 	"<hr />\n" . 

				$pageNumberlist->getInfo() . 

				"<br />\n" . 

				$pageNumberlist->getNavi() . 

				"<div class=\"table-responsive\">\n" . 
				"	<table class=\"table table-" . $row_admin["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
				"		<thead><tr class=\"bg-" . $row_admin["bgcolor_table_head"] . " text-" . $row_admin["color_table_head"] . "\">\n" . 
				"			<th width=\"40\" scope=\"col\">\n" . 
				"				<div class=\"custom-control custom-checkbox mt-0 ml-2\">\n" . 
				"					<input type=\"checkbox\" id=\"order_sel_all_top\" class=\"custom-control-input\" onclick=\"$('.order-list, #order_sel_all_bottom').prop('checked', this.checked)\" />\n" . 
				"					<label class=\"custom-control-label\" for=\"order_sel_all_top\"></label>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th width=\"40\" scope=\"col\" align=\"center\">\n" . 
				"				<div style=\"width: 40px;height: 24px;font-size: 1rem\" class=\"text-" . $row_admin["color_table_head"] . " text-center\"><i class=\"fa fa-clock-o\"> </i></div>\n" . 
				"			</th>\n" . 
				"			<th width=\"60\" scope=\"col\" class=\"text-center\">\n" . 
				"				<strong>Nr</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"130\" scope=\"col\">\n" . 
				"				<strong>Letzter Status</strong>\n" . 
				"			</th>\n" . 
				"			<th scope=\"col\">\n" . 
				"				<strong>Mitarbeiter</strong>\n" . 
				"			</th>\n" . 
				"			<th scope=\"col\">\n" . 
				"				<strong>Status</strong>\n" . 
				"			</th>\n" . 
				"			<th scope=\"col\">\n" . 
				"				<strong>Kunde</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" align=\"center\" scope=\"col\" class=\"text-center\">\n" . 
				"				<strong>Aktion</strong>\n" . 
				"			</th>\n" . 
				"		</tr></thead>\n" . 

				$list . 

				"	</table>\n" . 
				"	<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"		<table class=\"table table-" . $row_admin["bgcolor_table"] . " table-sm mb-0\">\n" . 
				"			<tr class=\"text-primary\">\n" . 
				"				<td width=\"40\">\n" . 
				"					<div class=\"custom-control custom-checkbox mt-1 ml-2\">\n" . 
				"						<input type=\"checkbox\" id=\"order_sel_all_bottom\" class=\"custom-control-input\" onclick=\"$('.order-list, #order_sel_all_top').prop('checked', this.checked)\" />\n" . 
				"						<label class=\"custom-control-label\" for=\"order_sel_all_bottom\"></label>\n" . 
				"					</div>\n" . 
				"				</td>\n" . 
				"				<td width=\"350\">\n" . 
				"					<label for=\"order_sel_all_bottom\" class=\"mt-1\">alle auswählen (" . (1+($pos > $rows ? $rows : $pos)) . " bis " . (($pos + $amount_rows) > $rows ? $rows : ($pos + $amount_rows)) . " von " . $rows . " Einträgen)</label>\n" . 
				"				</td>\n" . 
				"				<td width=\"260\">\n" . 
				"					<select name=\"status\" class=\"custom-select custom-select-sm text-primary border border-primary\" style=\"width: 200px\">\n" . 

				$multi_search_options . 

				"					</select> \n" . 
				"					<input type=\"hidden\" id=\"ids\" name=\"ids\" value=\"\" />\n" . 
				"					<button type=\"submit\" name=\"multi_status\" value=\"durchführen\" class=\"btn btn-sm btn-primary\" onclick=\"var ids='';$('.order-list').each(function(){if($(this).prop('checked')){ids+=ids==''?$(this).data('id'):','+$(this).data('id');}});$('#ids').val(ids);if(ids==''){alert('Bitte wählen Sie für diese Funktion ein oder mehrere Einträge aus!');return false;}else{return confirm('Wollen Sie wirklich den gewählten Status für die ausgewählten Einträge durchführen?');}\"><i class=\"fa fa-check\" aria-hidden=\"true\"></i></button>\n" . 
				"				</td>\n" . 
				"				<td width=\"200\">\n" . 
				"					<div class=\"custom-control custom-checkbox mt-1 ml-2\">\n" . 
				"						<input type=\"checkbox\" id=\"no_email\" name=\"no_email\" value=\"1\" class=\"custom-control-input\" />\n" . 
				"						<label class=\"custom-control-label\" for=\"no_email\">keine E-Mail</label>\n" . 
				"					</div>\n" . 
				"				</td>\n" . 
				"				<td>\n" . 
				"					&nbsp;\n" . 
				"				</td>\n" . 
				"			</tr>\n" . 
				"		</table>\n" . 
				"	</form>\n" . 
				"</div>\n" . 
				"<br />\n" . 

				$pageNumberlist->getNavi();

}

if(isset($_POST['add']) && $_POST['add'] == "hinzufügen"){

	$link = "neuer-auftrag";

	$options_admin_id = "";

	$admin_name = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`admin` 
									WHERE 		`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
									ORDER BY 	CAST(`admin`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$options_admin_id .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (intval($_POST['admin_id']) == $row['id'] ? " selected=\"selected\"" : "") : ($maindata['admin_id'] == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";
		if((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['admin_id']) : $maindata['admin_id']) == $row['id']){
			$admin_name = $row['name'];
		}
	}

	$options_component = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`reasons` 
									WHERE 		`reasons`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
									ORDER BY 	CAST(`reasons`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$options_component .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['component']) && $_POST['component'] == $row['id'] ? " selected=\"selected\"" : "") : "") . ">" . $row['name'] . "</option>\n";
	}

	$options_countries = "";
	$options_differing_countries = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`countries` 
									WHERE 		`countries`.`frontend`='1' 
									ORDER BY 	`countries`.`name` ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$options_countries .= "								<option value=\"" . $row['id'] . "\" data-code=\"" . $row['code'] . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['country']) && $_POST['country'] == $row['id'] ? " selected=\"selected\"" : "") : "") . ">" . $row['name'] . "</option>\n";
		$options_differing_countries .= "								<option value=\"" . $row['id'] . "\" data-code=\"" . $row['code'] . "\"" . (isset($_POST['edit']) && $_POST['edit'] == "speichern" ? (intval($_POST['differing_country']) == $row['id'] ? " selected=\"selected\"" : "") : (intval($row_order["differing_country"]) == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";
	}

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $row_admin["bgcolor_card"] . " text-" . $row_admin["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Hinzufügen</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "\" method=\"post\" enctype=\"multipart/form-data\" onsubmit=\"var sumsize=0;for(var i=0;i<document.getElementById('file_document_add').files.length;i++){sumsize+=document.getElementById('file_document_add').files[i].size;}if(sumsize>(" . (int)ini_get("upload_max_filesize") . "*1024*1024)){alert('Die upload Datengröße ist zu hoch. Es sind nur " . (int)ini_get("upload_max_filesize") . "MB insgesammt erlaubt!');return false;}else{return true;}\">\n" . 

				"					<div class=\"row\">\n" . 
				"						<div class=\"col-6 border-right\">\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"date\" class=\"col-sm-2 col-form-label\">Datum</label>\n" . 
				"								<div class=\"col-sm-3\">\n" . 
				"									<input type=\"text\" id=\"date\" name=\"date_1\" value=\"" . date("d.m.Y", time()) . "\" class=\"form-control\" disabled=\"disabled\" />\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-1\">\n" . 
				"								</div>\n" . 
				"								<label for=\"admin_id\" class=\"col-sm-2 col-form-label\">Mitarbeiter</label>\n" . 
				"								<div class=\"col-sm-3\">\n" . 
				"									<select id=\"admin_id_1\" name=\"admin_id\" class=\"custom-select d-none\">\n" . 

				$options_admin_id . 

				"									</select>\n" . 
				"									<input type=\"text\" id=\"admin_id\" name=\"admin_id_1\" value=\"" . $admin_name . "\" disabled=\"disabled\" class=\"form-control\" />\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-1\">\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-12\">\n" . 
				"									<strong>Rechnungsanschrift</strong>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-12\">\n" . 
				"									<input type=\"text\" id=\"companyname\" name=\"companyname\" value=\"" . $companyname . "\" class=\"form-control" . $inp_companyname . "\" placeholder=\"Firma\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-4 mt-2\">\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"gender_0\" name=\"gender\" value=\"0\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['gender']) : 0) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"gender_0\">\n" . 
				"											Herr\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"gender_1\" name=\"gender\" value=\"1\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['gender']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"gender_1\">\n" . 
				"											Frau\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<input type=\"text\" id=\"firstname\" name=\"firstname\" value=\"" . $firstname . "\" class=\"form-control" . $inp_firstname . "\" placeholder=\"Vorname\" />\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<input type=\"text\" id=\"lastname\" name=\"lastname\" value=\"" . $lastname . "\" class=\"form-control" . $inp_lastname . "\" placeholder=\"Nachname\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-9\">\n" . 
				"									<input type=\"text\" id=\"street\" name=\"street\" value=\"" . $street . "\" class=\"form-control" . $inp_street . "\" placeholder=\"Straße\" />\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-3\">\n" . 
				"									<input type=\"text\" id=\"streetno\" name=\"streetno\" value=\"" . $streetno . "\" class=\"form-control" . $inp_streetno . "\" placeholder=\"Nr\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<input type=\"text\" id=\"zipcode\" name=\"zipcode\" value=\"" . $zipcode . "\" class=\"form-control" . $inp_zipcode . "\" placeholder=\"Postleitzahl\" />\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<input type=\"text\" id=\"city\" name=\"city\" value=\"" . $city . "\" class=\"form-control" . $inp_city . "\" placeholder=\"Ort\" />\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<select id=\"country\" name=\"country\" class=\"custom-select" . $inp_country . "\">\n" . 

				$options_countries . 

				"									</select>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<input type=\"email\" id=\"email\" name=\"email\" value=\"" . $email . "\" class=\"form-control" . $inp_email . "\" placeholder=\"Email\" />\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<input type=\"text\" id=\"mobilnumber\" name=\"mobilnumber\" value=\"" . $mobilnumber . "\" class=\"form-control" . $inp_mobilnumber . "\" placeholder=\"Mobil\" />\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<input type=\"text\" id=\"phonenumber\" name=\"phonenumber\" value=\"" . $phonenumber . "\" class=\"form-control" . $inp_phonenumber . "\" placeholder=\"Festnetz\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\">Andere Lieferadresse</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"										<input type=\"checkbox\" id=\"differing_shipping_address\" name=\"differing_shipping_address\" value=\"1\"" . ($differing_shipping_address == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" onclick=\"\$('#differing_shipping_address_hide').toggleClass('d-none').toggleClass('d-block');\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"differing_shipping_address\">\n" . 
				"											Ja\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div id=\"differing_shipping_address_hide\" class=\"" . ($differing_shipping_address == 1 ? "d-block" : "d-none") . "\">\n" . 

				"								<div class=\"form-group row\">\n" . 
				"									<div class=\"col-sm-12\">\n" . 
				"										<input type=\"text\" id=\"differing_companyname\" name=\"differing_companyname\" value=\"" . $differing_companyname . "\" class=\"form-control" . $inp_differing_companyname . "\" placeholder=\"Firma\" />\n" . 
				"									</div>\n" . 
				"								</div>\n" . 

				"								<div class=\"form-group row\">\n" . 
				"									<div class=\"col-sm-4 mt-2\">\n" . 
				"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"											<input type=\"radio\" id=\"differing_gender_0\" name=\"differing_gender\" value=\"0\"" . ((isset($_POST['edit']) && $_POST['edit'] == "speichern" ? intval($_POST['differing_gender']) : 0) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"											<label class=\"custom-control-label\" for=\"differing_gender_0\">\n" . 
				"												Herr\n" . 
				"											</label>\n" . 
				"										</div>\n" . 
				"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"											<input type=\"radio\" id=\"differing_gender_1\" name=\"differing_gender\" value=\"1\"" . ((isset($_POST['edit']) && $_POST['edit'] == "speichern" ? intval($_POST['differing_gender']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"											<label class=\"custom-control-label\" for=\"differing_gender_1\">\n" . 
				"												Frau\n" . 
				"											</label>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"col-sm-4\">\n" . 
				"										<input type=\"text\" id=\"differing_firstname\" name=\"differing_firstname\" value=\"" . $differing_firstname . "\" class=\"form-control" . $inp_differing_firstname . "\" placeholder=\"Vorname\" />\n" . 
				"									</div>\n" . 
				"									<div class=\"col-sm-4\">\n" . 
				"										<input type=\"text\" id=\"differing_lastname\" name=\"differing_lastname\" value=\"" . $differing_lastname . "\" class=\"form-control" . $inp_differing_lastname . "\" placeholder=\"Nachname\" />\n" . 
				"									</div>\n" . 
				"								</div>\n" . 

				"								<div class=\"form-group row\">\n" . 
				"									<div class=\"col-sm-9\">\n" . 
				"										<input type=\"text\" id=\"differing_street\" name=\"differing_street\" value=\"" . $differing_street . "\" class=\"form-control" . $inp_differing_street . "\" placeholder=\"Straße\" />\n" . 
				"									</div>\n" . 
				"									<div class=\"col-sm-3\">\n" . 
				"										<input type=\"text\" id=\"differing_streetno\" name=\"differing_streetno\" value=\"" . $differing_streetno . "\" class=\"form-control" . $inp_differing_streetno . "\" placeholder=\"Nr\" />\n" . 
				"									</div>\n" . 
				"								</div>\n" . 

				"								<div class=\"form-group row\">\n" . 
				"									<div class=\"col-sm-4\">\n" . 
				"										<input type=\"text\" id=\"differing_zipcode\" name=\"differing_zipcode\" value=\"" . $differing_zipcode . "\" class=\"form-control" . $inp_differing_zipcode . "\" placeholder=\"Postleitzahl\" />\n" . 
				"									</div>\n" . 
				"									<div class=\"col-sm-4\">\n" . 
				"										<input type=\"text\" id=\"differing_city\" name=\"differing_city\" value=\"" . $differing_city . "\" class=\"form-control" . $inp_differing_city . "\" placeholder=\"Ort\" />\n" . 
				"									</div>\n" . 
				"									<div class=\"col-sm-4\">\n" . 
				"										<select id=\"differing_country\" name=\"differing_country\" class=\"custom-select" . $inp_differing_country . "\">\n" . 

				$options_differing_countries . 

				"										</select>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 

				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"pricemwst\" class=\"col-sm-4 col-form-label\">Reparaturfreigabe bis</label>\n" . 
				"								<div class=\"col-sm-5\">\n" . 
				"									<div class=\"input-group\">\n" . 
				"										<input type=\"text\" id=\"pricemwst\" name=\"pricemwst\" value=\"" . number_format($pricemwst, 2, ',', '') . "\" class=\"form-control" . $inp_pricemwst . "\" />\n" . 
				"										<div class=\"input-group-append\">\n" . 
				"											<span class=\"input-group-text\">&euro;</span>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\">Versand</label>\n" . 
				"								<div class=\"col-sm-8 mt-2\">\n" . 

				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"radio_shipping_standart\" name=\"radio_shipping\" value=\"1\"" . ($radio_shipping == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"radio_shipping_standart\">\n" . 
				"											Standard\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"radio_shipping_express\" name=\"radio_shipping\" value=\"0\"" . ($radio_shipping == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"radio_shipping_express\">\n" . 
				"											Express\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"radio_shipping_international\" name=\"radio_shipping\" value=\"2\"" . ($radio_shipping == 2 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"radio_shipping_international\">\n" . 
				"											International\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline\">\n" . 
				"										<input type=\"radio\" id=\"radio_shipping_self\" name=\"radio_shipping\" value=\"3\"" . ($radio_shipping == 3 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"radio_shipping_self\">\n" . 
				"											Abholung\n" . 
				"										</label>\n" . 
				"									</div>\n" . 

				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\">Zahlart</label>\n" . 
				"								<div class=\"col-sm-8 mt-2\">\n" . 

				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"radio_payment_nachnahme\" name=\"radio_payment\" value=\"1\"" . ($radio_payment == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"radio_payment_nachnahme\">\n" . 
				"											Nachnahme\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"radio_payment_ueberweisung\" name=\"radio_payment\" value=\"0\"" . ($radio_payment == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"radio_payment_ueberweisung\">\n" . 
				"											Überweisung\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline\">\n" . 
				"										<input type=\"radio\" id=\"radio_payment_bar\" name=\"radio_payment\" value=\"2\"" . ($radio_payment == 3 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"radio_payment_bar\">\n" . 
				"											Bar\n" . 
				"										</label>\n" . 
				"									</div>\n" . 

				"								</div>\n" . 
				"							</div>\n" . 

				"						</div>\n" . 
				"						<div class=\"col-6\">\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-12\">\n" . 
				"									<strong>Fahrzeugdaten</strong>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"machine\" class=\"col-sm-4 col-form-label\">Automarke</label>\n" . 
				"								<div class=\"col-sm-5\">\n" . 
				"									<input type=\"text\" id=\"machine\" name=\"machine\" value=\"" . $machine . "\" class=\"form-control" . $inp_machine . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"model\" class=\"col-sm-4 col-form-label\">Automodell</label>\n" . 
				"								<div class=\"col-sm-5\">\n" . 
				"									<input type=\"text\" id=\"model\" name=\"model\" value=\"" . $model . "\" class=\"form-control" . $inp_model . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"constructionyear\" class=\"col-sm-4 col-form-label\">Baujahr</label>\n" . 
				"								<div class=\"col-sm-5\">\n" . 
				"									<input type=\"text\" id=\"constructionyear\" name=\"constructionyear\" value=\"" . $constructionyear . "\" class=\"form-control" . $inp_constructionyear . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"carid\" class=\"col-sm-4 col-form-label\">FIN / VIN</label>\n" . 
				"								<div class=\"col-sm-5\">\n" . 
				"									<input type=\"text\" id=\"carid\" name=\"carid\" value=\"" . strtoupper($carid) . "\" class=\"form-control" . $inp_carid . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"kw\" class=\"col-sm-4 col-form-label\">Fahrleistung (PS)</label>\n" . 
				"								<div class=\"col-sm-5\">\n" . 
				"									<input type=\"text\" id=\"kw\" name=\"kw\" value=\"" . $kw . "\" class=\"form-control" . $inp_kw . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"mileage\" class=\"col-sm-4 col-form-label\">Kilometerstand</label>\n" . 
				"								<div class=\"col-sm-5\">\n" . 
				"									<div class=\"input-group date\">\n" . 
				"										<input type=\"text\" id=\"mileage\" name=\"mileage\" value=\"" . number_format(intval($mileage), 0, '', '.') . "\" class=\"form-control" . $inp_mileage . "\" />\n" . 
				"									    <span class=\"input-group-append\">\n" . 
				"											<span class=\"input-group-text\">KM</span>\n" . 
				"										</span>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\">Getriebe</label>\n" . 
				"								<div class=\"col-sm-5 mt-2\">\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"mechanism_0\" name=\"mechanism\" value=\"0\"" . ($mechanism == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"mechanism_0\">\n" . 
				"											Schaltung\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"mechanism_1\" name=\"mechanism\" value=\"1\"" . ($mechanism == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"mechanism_1\">\n" . 
				"											Automatik\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\">Kraftstoffart</label>\n" . 
				"								<div class=\"col-sm-5 mt-2\">\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"fuel_0\" name=\"fuel\" value=\"0\"" . ($fuel == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"fuel_0\">\n" . 
				"											Benzin\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"fuel_1\" name=\"fuel\" value=\"1\"" . ($fuel == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"fuel_1\">\n" . 
				"											Diesel\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-12\">\n" . 
				"									<strong>Gerätedaten</strong>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"component\" class=\"col-sm-4 col-form-label\">Defektes Bauteil</label>\n" . 
				"								<div class=\"col-sm-5\">\n" . 
				"									<select id=\"component\" name=\"component\" class=\"custom-select" . $inp_component . "\">\n" . 
				"										<option value=\"0\">Bitte auswählen</option>\n" . 

				$options_component . 

				"									</select>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"manufacturer\" class=\"col-sm-4 col-form-label\">Hersteller</label>\n" . 
				"								<div class=\"col-sm-5\">\n" . 
				"									<input type=\"text\" id=\"manufacturer\" name=\"manufacturer\" value=\"" . $manufacturer . "\" class=\"form-control" . $inp_manufacturer . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"serial\" class=\"col-sm-4 col-form-label\">Teile.-/Herstellernummer</label>\n" . 
				"								<div class=\"col-sm-5\">\n" . 
				"									<input type=\"text\" id=\"serial\" name=\"serial\" value=\"" . $serial . "\" class=\"form-control" . $inp_serial . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\">Stammt das Gerät aus dem angegebenen Fahrzeug</label>\n" . 
				"								<div class=\"col-sm-5 mt-2\">\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"fromthiscar_yes\" name=\"fromthiscar\" value=\"1\"" . ($fromthiscar == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"fromthiscar_yes\">\n" . 
				"											Ja\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline\">\n" . 
				"										<input type=\"radio\" id=\"fromthiscar_no\" name=\"fromthiscar\" value=\"0\"" . ($fromthiscar == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"fromthiscar_no\">\n" . 
				"											Nein\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-12\">\n" . 
				"									<strong>Fehlerbeschreibung</strong>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"reason\" class=\"col-sm-4 col-form-label\">Fehlerursache</label>\n" . 
				"								<div class=\"col-sm-8 text-right\">\n" . 
				"									<textarea id=\"reason\" name=\"reason\" style=\"height: 160px\" class=\"form-control" . $inp_reason . "\" onkeyup=\"if(this.value.length >= 700){this.value = this.value.substr(0, 700);alert('Die maximale Anzahl an erlaubten Zeichen wurde erreicht!');}$('#reason_length').html(this.value.length);\">" . $reason . "</textarea>\n" . 
				"									<small>(<span id=\"reason_length\">" . strlen($reason) . "</span> von 700 Zeichen)</small>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 
				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"description\" class=\"col-sm-4 col-form-label\">Fehlerspeicher</label>\n" . 
				"								<div class=\"col-sm-8 text-right\">\n" . 
				"									<textarea id=\"description\" name=\"description\" style=\"height: 160px\" class=\"form-control" . $inp_description . "\" onkeyup=\"if(this.value.length >= 700){this.value = this.value.substr(0, 700);alert('Die maximale Anzahl an erlaubten Zeichen wurde erreicht!');}$('#description_length').html(this.value.length);\">" . $description . "</textarea>\n" . 
				"									<small>(<span id=\"description_length\">" . strlen($description) . "</span> von 700 Zeichen)</small>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"file_document_add\" class=\"col-sm-12 col-form-label\">Datenupload</label>\n" . 
				"								<div class=\"col-sm-12 px-3 pt-0 pb-3\">\n" . 
				"									<input type=\"file\" id=\"file_document_add\" name=\"file[]\" multiple=\"multiple\" accept=\"" . str_replace(", ", ",", $maindata['input_file_accept']) . "\" class=\"form-control\" onchange=\"var sumsize=0;for(var i=0;i<this.files.length;i++){sumsize+=this.files[i].size;}if(sumsize>(" . (int)ini_get("upload_max_filesize") . "*1024*1024)){alert('Die upload Datengröße ist zu hoch. Es sind nur " . (int)ini_get("upload_max_filesize") . "MB insgesammt erlaubt!');}\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 
				
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"hidden\" name=\"run_date\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['run_date']) : time()) . "\" />\n" . 
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

if(isset($_POST['edit']) && $_POST['edit'] == "ansehen"){

	$row_order = mysqli_fetch_array(mysqli_query($conn, "	SELECT 	*, 
																	(SELECT 	(SELECT `statuses`.`name` AS name FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `statuses`.`id`=`order_orders_statuses`.`status_id`) AS name 
																		FROM 	`order_orders_statuses` 
																		WHERE 	`order_orders_statuses`.`order_id`=`order_orders`.`id` 
																		AND 	`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
																		ORDER BY CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_name 
															FROM 	`order_orders` 
															WHERE 	`order_orders`.`user_id`='" . $_SESSION['user']['id'] . "' 
															AND 	`order_orders`.`id`='" . intval($_POST['id']) . "' 
															AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'"), MYSQLI_ASSOC);

	$carriers_services = array(
		'11' => 'UPS Standard', 
		'65' => 'UPS Saver'
	);

	$list_shipments = "";

	$result_shipments = mysqli_query($conn, "	SELECT 		`order_orders_shipments`.`id` AS id, 
															(
																SELECT 	name 
																FROM 	`admin` `admin` 
																WHERE 	`admin`.`id`=`order_orders_shipments`.`admin_id` 
																AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
															) AS admin_name, 
															`order_orders_shipments`.`shipments_id` AS shipments_id, 
															`order_orders_shipments`.`carrier_tracking_no` AS carrier_tracking_no, 
															`order_orders_shipments`.`label_url` AS label_url, 
															`order_orders_shipments`.`graphic_image_jpeg` AS graphic_image_jpeg, 
															`order_orders_shipments`.`graphic_image_gif` AS graphic_image_gif, 
															`order_orders_shipments`.`price` AS price, 
															`order_orders_shipments`.`total_charges_with_taxes` AS total_charges_with_taxes, 
															`order_orders_shipments`.`carrier` AS carrier, 
															`order_orders_shipments`.`service` AS service, 
															`order_orders_shipments`.`reference_number` AS reference_number, 
															`order_orders_shipments`.`notification_email` AS notification_email, 
															`order_orders_shipments`.`component` AS component, 
															`order_orders_shipments`.`companyname` AS companyname, 
															`order_orders_shipments`.`firstname` AS firstname, 
															`order_orders_shipments`.`lastname` AS lastname, 
															`order_orders_shipments`.`street` AS street, 
															`order_orders_shipments`.`streetno` AS streetno, 
															`order_orders_shipments`.`zipcode` AS zipcode, 
															`order_orders_shipments`.`city` AS city, 
															`order_orders_shipments`.`country` AS country, 
															`order_orders_shipments`.`weight` AS weight, 
															`order_orders_shipments`.`length` AS length, 
															`order_orders_shipments`.`width` AS width, 
															`order_orders_shipments`.`height` AS height, 
															`order_orders_shipments`.`time` AS time 
												FROM 		`order_orders_shipments` `order_orders_shipments` 
												WHERE 		`order_orders_shipments`.`order_id`='" . $row_order['id'] . "' 
												AND 		`order_orders_shipments`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
												ORDER BY 	CAST(`order_orders_shipments`.`time` AS UNSIGNED) DESC");

	while($row = $result_shipments->fetch_array(MYSQLI_ASSOC)){

		$list_shipments .= 	"<div class=\"card card-maximize\">\n" . 
							"	<div class=\"card-header\">\n" . 
							"		<div class=\"row\">\n" . 
							"			<div class=\"col-12 col-md-6\">\n" . 
							"				[" . $row['id'] . "] <a href=\"#shipments_" . $row['id'] . "\" class=\"alert-link collapsed\" data-toggle=\"collapse\" role=\"link\" aria-expanded=\"true\" aria-controls=\"collapseExample\"><small>Mehr zeigen</small></a>\n" . 
							"			</div>\n" . 
							"			<div class=\"col-12 col-md-6 text-right\">\n" . 
							"				<small class=\"text-muted\">" . date("d.m.Y (H:i)", $row['time']) . "</small>\n" . 
							"			</div>\n" . 
							"		</div>\n" . 
							"	</div>\n" . 
							"	<div id=\"shipments_" . $row['id'] . "\" class=\"card-body collapse show active\">\n" . 
							"		<div class=\"row\">\n" . 
							"			<label class=\"col-3\">Durchgeführt von</label>\n" . 
							"			<div class=\"col-9\">\n" . 
							"				<span>" . $row['admin_name'] . "</span>\n" . 
							"			</div>\n" . 
							"		</div>\n" . 
							"		<div class=\"row\">\n" . 
							"			<label class=\"col-3\">Label URL</label>\n" . 
							"			<div class=\"col-9\">\n" . 
							"				<a href=\"" . $row['label_url'] . "\" target=\"_blank\">öffnen</a>\n" . 
							"			</div>\n" . 
							"		</div>\n" . 
							"		<div class=\"row\">\n" . 
							"			<label class=\"col-3\">Tracking Nummer</label>\n" . 
							"			<div class=\"col-9\">\n" . 
							"				" . $row['carrier_tracking_no'] . "\n" . 
							"			</div>\n" . 
							"		</div>\n" . 
							"		<div class=\"row\">\n" . 
							"			<label class=\"col-3\">Tracking URL</label>\n" . 
							"			<div class=\"col-9\">\n" . 
							"				<a href=\"https://www.ups.com/WebTracking/processInputRequest?tracknum=" . $row['carrier_tracking_no'] . "&loc=de_DE\" target=\"_blank\">öffnen</a>\n" . 
							"			</div>\n" . 
							"		</div>\n" . 
							"		<div class=\"row\">\n" . 
							"			<label class=\"col-3\">Print Label</label>\n" . 
							"			<div class=\"col-9\">\n" . 
							"				<a href=\"/sendung/label/" . $company_id . "/" . $row['carrier_tracking_no'] . "\" target=\"_blank\">öffnen</a>\n" . 
							"			</div>\n" . 
							"		</div>\n" . 
							"		<div class=\"row\">\n" . 
							"			<label class=\"col-3\">Preis</label>\n" . 
							"			<div class=\"col-9\">\n" . 
							"				<span>" . number_format($row['price'], 2, ',', '') . " &euro;</span>\n" . 
							"			</div>\n" . 
							"		</div>\n" . 
							"		<div class=\"row\">\n" . 
							"			<label class=\"col-3\">Versandkosten</label>\n" . 
							"			<div class=\"col-9\">\n" . 
							"				<span>" . number_format($row['total_charges_with_taxes'], 2, ',', '') . " &euro;</span>\n" . 
							"			</div>\n" . 
							"		</div>\n" . 
							"		<div class=\"row\">\n" . 
							"			<label class=\"col-3\">Referenznummer</label>\n" . 
							"			<div class=\"col-9\">\n" . 
							"				<span>" . $row['reference_number'] . "</span>\n" . 
							"			</div>\n" . 
							"		</div>\n" . 
							"		<div class=\"row\">\n" . 
							"			<label class=\"col-3\">Versanddienstleister</label>\n" . 
							"			<div class=\"col-9\">\n" . 
							"				<span>UPS</span>\n" . 
							"			</div>\n" . 
							"		</div>\n" . 
							"		<div class=\"row\">\n" . 
							"			<label class=\"col-3\">Service</label>\n" . 
							"			<div class=\"col-9\">\n" . 
							"				<span>" . $carriers_services[$row['service']] . "</span>\n" . 
							"			</div>\n" . 
							"		</div>\n" . 
							"		<div class=\"row\">\n" . 
							"			<label class=\"col-3\">Benachrichtigung</label>\n" . 
							"			<div class=\"col-9\">\n" . 
							"				<a href=\"mailto: " . $row['notification_email'] . "\">" . $row['notification_email'] . "</a>\n" . 
							"			</div>\n" . 
							"		</div>\n" . 
							"		<div class=\"row\">\n" . 
							"			<label class=\"col-3\">Auftraggeber</label>\n" . 
							"			<div class=\"col-9\">\n" . 
							"				<span>" . ($maindata['company'] != "" ? $maindata['company'] . ", " : "") . $maindata['firstname'] . " " . $maindata['lastname'] . "</span>\n" . 
							"			</div>\n" . 
							"		</div>\n" . 
							"		<div class=\"row\">\n" . 
							"			<label class=\"col-3\">Paket</label>\n" . 
							"			<div class=\"col-9\">\n" . 
							"				<span>Gewicht: " . number_format($row['weight'], 1, ',', '') . " KG, Länge: " . $row['length'] . " cm, Breite: " . $row['width'] . " cm, Höhe: " . $row['height'] . " cm</span>\n" . 
							"			</div>\n" . 
							"		</div>\n" . 
							"	</div>\n" . 
							"</div>\n" . 
							"<br />\n";

	}

	$list_shipments = $list_shipments != "" ? "<h4><u>Sendungen</u>:</h4><br />\n" . $list_shipments : "";

	$list_status_history = 	"				<br />\n" . 
							"				<p><strong>Aktueller Status</strong>: " . $row_order['status_name'] . "</p>\n" . 
							"				<div class=\"table-responsive overflow-auto border\" style=\"height: 750px\">\n" . 
							"					<table class=\"table table-" . $row_admin["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
							"						<thead><tr class=\"bg-" . $row_admin["bgcolor_table_head"] . " text-" . $row_admin["color_table_head"] . "\">\n" . 
							"							<th><strong>Datum</strong></th>\n" . 
							"							<th><strong>Status</strong></th>\n" . 
							"							<th><strong>Mitarbeiter</strong></th>\n" . 
							"							<th><strong>Email-Vorlage</strong></th>\n" . 
							"							<th><strong>Nachricht</strong></th>\n" . 
							"							<th><strong>&nbsp;</strong></th>\n" . 
							"						</tr></thead>\n";

	$result_statuses = mysqli_query($conn, "	SELECT 		`order_orders_statuses`.`id` AS id, 
															`order_orders_statuses`.`status_number` AS status_number, 
															`order_orders_statuses`.`time` AS time, 
															(
																SELECT 	name
																FROM 	`admin` `admin`
																WHERE 	`admin`.`id`=`order_orders_statuses`.`admin_id` 
																AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
															) AS admin_name, 
															`order_orders_statuses`.`template` AS template, 
															`order_orders_statuses`.`subject` AS subject, 
															`order_orders_statuses`.`body` AS body, 
															`statuses`.`name` AS status_name, 
															`statuses`.`color` AS status_color 
												FROM 		`order_orders_statuses` `order_orders_statuses`
												LEFT JOIN 	`statuses` `statuses` 
												ON 			`statuses`.`id`=`order_orders_statuses`.`status_id`
												WHERE 		`order_orders_statuses`.`order_id`='" . $row_order['id'] . "' 
												AND 		`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
												AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
												ORDER BY 	CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC");

	while($row_order_status = $result_statuses->fetch_array(MYSQLI_ASSOC)){

		$list_shipments_status = "";

		$result_shipments = mysqli_query($conn, "	SELECT 		`order_orders_shipments`.`id` AS id, 
																(
																	SELECT 	name 
																	FROM 	`admin` `admin` 
																	WHERE 	`admin`.`id`=`order_orders_shipments`.`admin_id` 
																	AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
																) AS admin_name, 
																`order_orders_shipments`.`shipments_id` AS shipments_id, 
																`order_orders_shipments`.`carrier_tracking_no` AS carrier_tracking_no, 
																`order_orders_shipments`.`label_url` AS label_url, 
																`order_orders_shipments`.`graphic_image_jpeg` AS graphic_image_jpeg, 
																`order_orders_shipments`.`graphic_image_gif` AS graphic_image_gif, 
																`order_orders_shipments`.`price` AS price, 
																`order_orders_shipments`.`total_charges_with_taxes` AS total_charges_with_taxes, 
																`order_orders_shipments`.`carrier` AS carrier, 
																`order_orders_shipments`.`service` AS service, 
																`order_orders_shipments`.`reference_number` AS reference_number, 
																`order_orders_shipments`.`notification_email` AS notification_email, 
																`order_orders_shipments`.`component` AS component, 
																`order_orders_shipments`.`companyname` AS companyname, 
																`order_orders_shipments`.`firstname` AS firstname, 
																`order_orders_shipments`.`lastname` AS lastname, 
																`order_orders_shipments`.`street` AS street, 
																`order_orders_shipments`.`streetno` AS streetno, 
																`order_orders_shipments`.`zipcode` AS zipcode, 
																`order_orders_shipments`.`city` AS city, 
																`order_orders_shipments`.`country` AS country, 
																`order_orders_shipments`.`weight` AS weight, 
																`order_orders_shipments`.`length` AS length, 
																`order_orders_shipments`.`width` AS width, 
																`order_orders_shipments`.`height` AS height, 
																`order_orders_shipments`.`time` AS time 
													FROM 		`order_orders_shipments` `order_orders_shipments` 
													WHERE 		`order_orders_shipments`.`order_id`='" . $row_order['id'] . "' 
													AND 		`order_orders_shipments`.`status_id`='" . $row_order_status['id'] . "' 
													AND 		`order_orders_shipments`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
													ORDER BY 	CAST(`order_orders_shipments`.`time` AS UNSIGNED) DESC");

		while($row = $result_shipments->fetch_array(MYSQLI_ASSOC)){

			$list_shipments_status .= 	"<div class=\"card card-maximize\">\n" . 
										"	<div class=\"card-header\">\n" . 
										"		<div class=\"row\">\n" . 
										"			<div class=\"col-12 col-md-6\">\n" . 
										"				[" . $row['id'] . "] <a href=\"#shipments_" . $row['id'] . "\" class=\"alert-link collapsed\" data-toggle=\"collapse\" role=\"link\" aria-expanded=\"true\" aria-controls=\"collapseExample\"><small>Mehr zeigen</small></a>\n" . 
										"			</div>\n" . 
										"			<div class=\"col-12 col-md-6 text-right\">\n" . 
										"				<small class=\"text-muted\">" . date("d.m.Y (H:i)", $row['time']) . "</small>\n" . 
										"			</div>\n" . 
										"		</div>\n" . 
										"	</div>\n" . 
										"	<div id=\"shipments_" . $row['id'] . "\" class=\"card-body collapse show active\">\n" . 
										"		<div class=\"row\">\n" . 
										"			<label class=\"col-3\">Durchgeführt von</label>\n" . 
										"			<div class=\"col-9\">\n" . 
										"				<span>" . $row['admin_name'] . "</span>\n" . 
										"			</div>\n" . 
										"		</div>\n" . 
										"		<div class=\"row\">\n" . 
										"			<label class=\"col-3\">Label URL</label>\n" . 
										"			<div class=\"col-9\">\n" . 
										"				<a href=\"" . $row['label_url'] . "\" target=\"_blank\">öffnen</a>\n" . 
										"			</div>\n" . 
										"		</div>\n" . 
										"		<div class=\"row\">\n" . 
										"			<label class=\"col-3\">Tracking Nummer</label>\n" . 
										"			<div class=\"col-9\">\n" . 
										"				" . $row['carrier_tracking_no'] . "\n" . 
										"			</div>\n" . 
										"		</div>\n" . 
										"		<div class=\"row\">\n" . 
										"			<label class=\"col-3\">Tracking URL</label>\n" . 
										"			<div class=\"col-9\">\n" . 
										"				<a href=\"https://www.ups.com/WebTracking/processInputRequest?tracknum=" . $row['carrier_tracking_no'] . "&loc=de_DE\" target=\"_blank\">öffnen</a>\n" . 
										"			</div>\n" . 
										"		</div>\n" . 
										"		<div class=\"row\">\n" . 
										"			<label class=\"col-3\">Print Label</label>\n" . 
										"			<div class=\"col-9\">\n" . 
										"				<a href=\"/sendung/label/" . $company_id . "/" . $row['carrier_tracking_no'] . "\" target=\"_blank\">öffnen</a>\n" . 
										"			</div>\n" . 
										"		</div>\n" . 
										"		<div class=\"row\">\n" . 
										"			<label class=\"col-3\">Preis</label>\n" . 
										"			<div class=\"col-9\">\n" . 
										"				<span>" . number_format($row['price'], 2, ',', '') . " &euro;</span>\n" . 
										"			</div>\n" . 
										"		</div>\n" . 
										"		<div class=\"row\">\n" . 
										"			<label class=\"col-3\">Versandkosten</label>\n" . 
										"			<div class=\"col-9\">\n" . 
										"				<span>" . number_format($row['total_charges_with_taxes'], 2, ',', '') . " &euro;</span>\n" . 
										"			</div>\n" . 
										"		</div>\n" . 
										"		<div class=\"row\">\n" . 
										"			<label class=\"col-3\">Referenznummer</label>\n" . 
										"			<div class=\"col-9\">\n" . 
										"				<span>" . $row['reference_number'] . "</span>\n" . 
										"			</div>\n" . 
										"		</div>\n" . 
										"		<div class=\"row\">\n" . 
										"			<label class=\"col-3\">Versanddienstleister</label>\n" . 
										"			<div class=\"col-9\">\n" . 
										"				<span>UPS</span>\n" . 
										"			</div>\n" . 
										"		</div>\n" . 
										"		<div class=\"row\">\n" . 
										"			<label class=\"col-3\">Service</label>\n" . 
										"			<div class=\"col-9\">\n" . 
										"				<span>" . $carriers_services[$row['service']] . "</span>\n" . 
										"			</div>\n" . 
										"		</div>\n" . 
										"		<div class=\"row\">\n" . 
										"			<label class=\"col-3\">Benachrichtigung</label>\n" . 
										"			<div class=\"col-9\">\n" . 
										"				<a href=\"mailto: " . $row['notification_email'] . "\">" . $row['notification_email'] . "</a>\n" . 
										"			</div>\n" . 
										"		</div>\n" . 
										"		<div class=\"row\">\n" . 
										"			<label class=\"col-3\">Auftraggeber</label>\n" . 
										"			<div class=\"col-9\">\n" . 
										"				<span>" . ($maindata['company'] != "" ? $maindata['company'] . ", " : "") . $maindata['firstname'] . " " . $maindata['lastname'] . "</span>\n" . 
										"			</div>\n" . 
										"		</div>\n" . 
										"		<div class=\"row\">\n" . 
										"			<label class=\"col-3\">Paket</label>\n" . 
										"			<div class=\"col-9\">\n" . 
										"				<span>Gewicht: " . number_format($row['weight'], 1, ',', '') . " KG, Länge: " . $row['length'] . " cm, Breite: " . $row['width'] . " cm, Höhe: " . $row['height'] . " cm</span>\n" . 
										"			</div>\n" . 
										"		</div>\n" . 
										"	</div>\n" . 
										"</div>\n" . 
										"<br />\n";

		}

		$list_shipments_status = $list_shipments_status != "" ? "<h4><u>Sendungen</u>:</h4><br />\n" . $list_shipments_status : "";

		$list_status_history .= 	"<tr>\n" . 
									"	<td width=\"140\">" . date("d.m.Y (H:i)", $row_order_status['time']) . "</td>\n" . 
									"	<td align=\"center\"><span class=\"badge badge-pill\" style=\"background-color: " . $row_order_status['status_color'] . "\">" . $row_order_status['status_name'] . "</span></td>\n" . 
									"	<td>" . $row_order_status['admin_name'] . "</td>\n" . 
									"	<td>" . $row_order_status['template'] . "</td>\n" . 
									"	<td>" . $row_order_status['subject'] . "</td>\n" . 
									"	<td width=\"50\" align=\"center\"><button type=\"button\" name=\"show_details\" value=\"DETAILS\" class=\"btn btn-success btn-sm\" onclick=\"showStatussesDialog('" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($row_order_status['subject'], ENT_QUOTES))))) . "<hr><br><br>', '" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($row_order_status['body'], ENT_QUOTES))))) . "<hr><br><br>', '" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($list_shipments_status, ENT_QUOTES))))) . "')\"><i class=\"fa fa-search-plus\" aria-hidden=\"true\"></i></button></td>\n" . 
									"</tr>\n";

	}

	$list_customer_history = 	"				<hr />\n" . 
								"				<div class=\"table-responsive overflow-auto border\" style=\"height: 750px\">\n" . 
								"					<table class=\"table table-" . $row_admin["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
								"						<thead><tr class=\"bg-" . $row_admin["bgcolor_table_head"] . " text-" . $row_admin["color_table_head"] . "\">\n" . 
								"							<th width=\"140\"><strong>Datum</strong></th>\n" . 
								"							<th width=\"180\"><strong>Mitarbeiter</strong></th>\n" . 
								"							<th><strong>Nachricht</strong></th>\n" . 
								"							<th width=\"80\" class=\"text-center\"><strong>Aktion</strong></th>\n" . 
								"						</tr></thead>\n";

	$result = mysqli_query($conn, "	SELECT 		`order_orders_customer_messages`.`id` AS id, 
												(
													SELECT 	name 
													FROM 	`admin` `admin` 
													WHERE 	`admin`.`id`=`order_orders_customer_messages`.`admin_id` 
													AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
												) AS admin_name, 
												`order_orders_customer_messages`.`message` AS message, 
												`order_orders_customer_messages`.`time` AS time 
									FROM 		`order_orders_customer_messages` `order_orders_customer_messages` 
									WHERE 		`order_orders_customer_messages`.`order_id`='" . $row_order['id'] . "' 
									AND 		`order_orders_customer_messages`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
									ORDER BY 	CAST(`order_orders_customer_messages`.`time` AS UNSIGNED) DESC");

	while($row_customer_history = $result->fetch_array(MYSQLI_ASSOC)){

		$list_customer_history .= 	"<tr>\n" . 
									"	<td>" . date("d.m.Y (H:i)", $row_customer_history['time']) . "</td>\n" . 
									"	<td>" . $row_customer_history['admin_name'] . "</td>\n" . 
									"	<td>" . str_replace("\r\n", " - ", $row_customer_history['message']) . "</td>\n" . 
									"	<td align=\"center\">\n" . 
									"		<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
									"			<div class=\"btn-group\">\n" . 
									"				" . ($_SESSION["admin"]["roles"]["customer_message_delete"] == 1 ? "<button type=\"submit\" name=\"customer_history_delete\" value=\"X\" class=\"btn btn-sm btn-danger\" onclick=\"return confirm('Sind Sie sicher, das Sie die Nachricht entfernen wollen?')\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></button>\n" : "\n") . 
									"				<button type=\"button\" name=\"show_details\" value=\"DETAILS\" class=\"btn btn-success btn-sm\" onclick=\"showStatussesDialog('" . str_replace("\"", "\\'", str_replace("\n", "", str_replace("\r\n", "<br />", $row_customer_history['message']))) . "', '', '')\"><i class=\"fa fa-search-plus\" aria-hidden=\"true\"></i></button>\n" . 
									"			</div>\n" . 
									"			<input type=\"hidden\" name=\"id\" value=\"" . $row_order['id'] . "\" />\n" . 
									"			<input type=\"hidden\" name=\"customer_history_id\" value=\"" . $row_customer_history['id'] . "\" />\n" . 
									"		</form>\n" . 
									"	</td>\n" . 
									"</tr>\n";

	}

	$list_userdata = "";

	$arr_files = explode("\r\n", $row_order['userdata']);

	for($i = 0;$i < count($arr_files);$i++){
		if($arr_files[$i] != ""){

			$preview_image = "";

			$ext = pathinfo($arr_files[$i], PATHINFO_EXTENSION);

			if(in_array($ext, array('jpg', 'jpeg', 'gif', 'png', 'tiff'))){
				$preview_image = "		<a href=\"/uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/userdata/" . $arr_files[$i] . "\" target=\"_blank\"><img src=\"/uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/userdata/" . $arr_files[$i] . "\" width=\"64\" class=\"border border-primary\" border=\"0\" /></a>\n";
			}

			$list_userdata .= 	"<div class=\"row mb-4\">\n" . 
								"	<div class=\"col-sm-9\">\n" . 
								"		" . ($i + 1) . ") <a href=\"/uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/userdata/" . $arr_files[$i] . "\" target=\"_blank\">" . $arr_files[$i] . "</a>\n" . 
								"	</div>\n" . 
								"	<div class=\"col-sm-2\">\n" . 
								$preview_image . 
								"	</div>\n" . 
								"	<div class=\"col-sm-1\">\n" . 
								"		<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
								"			<input type=\"hidden\" name=\"id\" value=\"" . $row_order['id'] . "\" />\n" . 
								"			<input type=\"hidden\" name=\"item\" value=\"" . $i . "\" />\n" . 
								"			<button type=\"submit\" name=\"userdata_delete\" value=\"X\" class=\"btn btn-sm btn-danger\" onclick=\"return confirm('Sind Sie sicher, das Sie die Datei entfernen wollen?')\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></button>\n" . 
								"		</form>\n" . 
								"	</div>\n" . 
								"</div>\n";
		}
	}

	$list_history = "				<hr />\n" . 
					"				<div class=\"table-responsive overflow-auto border\" style=\"height: 750px\">\n" . 
					"					<table class=\"table table-" . $row_admin["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
					"						<thead><tr class=\"bg-" . $row_admin["bgcolor_table_head"] . " text-" . $row_admin["color_table_head"] . "\">\n" . 
					"							<th width=\"140\"><strong>Datum</strong></th>\n" . 
					"							<th width=\"180\"><strong>Mitarbeiter</strong></th>\n" . 
					"							<th><strong>Nachricht</strong></th>\n" . 
					"							<th width=\"210\" class=\"text-center\"><strong>Aktion</strong></th>\n" . 
					"						</tr></thead>\n";

	$result = mysqli_query($conn, "	SELECT 		`order_orders_history`.`id` AS id, 
												(
													SELECT 	name 
													FROM 	`admin` `admin` 
													WHERE 	`admin`.`id`=`order_orders_history`.`admin_id` 
													AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
												) AS admin_name, 
												`order_orders_history`.`message` AS message, 
												`order_orders_history`.`status` AS status, 
												`order_orders_history`.`time` AS time 
									FROM 		`order_orders_history` `order_orders_history` 
									WHERE 		`order_orders_history`.`order_id`='" . $row_order['id'] . "' 
									AND 		`order_orders_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
									ORDER BY 	CAST(`order_orders_history`.`time` AS UNSIGNED) DESC");

	while($row_history = $result->fetch_array(MYSQLI_ASSOC)){

		$list_history .= 	"<tr" . ($row_history['status'] == 1 ? " class=\"bg-danger text-white\"" : ($row_history['status'] == 2 ? " class=\"bg-success text-white\"" : ($row_history['status'] == 3 ? " class=\"bg-warning text-white\"" : ""))) . ">\n" . 
							"	<td>" . date("d.m.Y (H:i)", $row_history['time']) . "</td>\n" . 
							"	<td>" . $row_history['admin_name'] . "</td>\n" . 
							"	<td>" . str_replace("\r\n", " - ", $row_history['message']) . "</td>\n" . 
							"	<td width=\"160\" align=\"center\">\n" . 
							"		<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
							"			<div class=\"btn-group\">\n" . 
							"				<select name=\"status\" class=\"custom-select custom-select-sm\" style=\"width: 100px;border-radius: .25rem 0 0 .25rem\">\n" . 
							"					<option value=\"0\"" . ($row_history['status'] == 0 ? " selected=\"selected\"" : "") . ">Neutral</option>\n" . 
							"					<option value=\"1\"" . ($row_history['status'] == 1 ? " selected=\"selected\"" : "") . " class=\"bg-danger text-white\">Anweisung</option>\n" . 
							"					<option value=\"2\"" . ($row_history['status'] == 2 ? " selected=\"selected\"" : "") . " class=\"bg-success text-white\">Erledigt</option>\n" . 
							"					<option value=\"3\"" . ($row_history['status'] == 3 ? " selected=\"selected\"" : "") . " class=\"bg-warning text-white\">Extern</option>\n" . 
							"				</select>\n" . 
							"				<input type=\"hidden\" name=\"id\" value=\"" . $row_order['id'] . "\" />\n" . 
							"				<input type=\"hidden\" name=\"history_id\" value=\"" . $row_history['id'] . "\" />\n" . 
							"				<button type=\"submit\" name=\"history_status\" value=\"speichern\" class=\"btn btn-sm btn-primary\"><i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
							"				" . ($_SESSION["admin"]["roles"]["history_message_delete"] == 1 ? "<button type=\"submit\" name=\"history_delete\" value=\"X\" class=\"btn btn-sm btn-danger\" onclick=\"return confirm('Sind Sie sicher, das Sie die Nachricht entfernen wollen?')\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></button>\n" : "\n") . 
							"				<button type=\"button\" name=\"show_details\" value=\"DETAILS\" class=\"btn btn-success btn-sm\" onclick=\"showStatussesDialog('" . str_replace("\"", "\\'", str_replace("\n", "", str_replace("\r\n", "<br />", $row_history['message']))) . "', '', '')\"><i class=\"fa fa-search-plus\" aria-hidden=\"true\"></i></button>\n" . 
							"			</div>\n" . 
							"		</form>\n" . 
							"	</td>\n" . 
							"</tr>\n";

	}

	$tab_events = "events_all";

	$events_all = "";
	$events_insert = "";
	$events_update = "";
	$events_delete = "";

	$result = mysqli_query($conn, "	SELECT 		`order_orders_events`.`id` AS id, 
												(
													SELECT 	name 
													FROM 	`admin` `admin` 
													WHERE 	`admin`.`id`=`order_orders_events`.`admin_id` 
													AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
												) AS admin_name, 
												`order_orders_events`.`type` AS type, 
												`order_orders_events`.`message` AS message, 
												`order_orders_events`.`subject` AS subject, 
												`order_orders_events`.`body` AS body, 
												`order_orders_events`.`time` AS time 
									FROM 		`order_orders_events` `order_orders_events` 
									WHERE 		`order_orders_events`.`order_id`='" . $row_order['id'] . "' 
									AND 		`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
									ORDER BY 	CAST(`order_orders_events`.`time` AS UNSIGNED) DESC");

	while($row_events = $result->fetch_array(MYSQLI_ASSOC)){

		$events_all .= "											<tr><td width=\"140\">" . date("d.m.Y (H:i)", intval($row_events['time'])) . "</td><td>" . $row_events['admin_name'] . ", " . str_replace("\r\n", "", $row_events['message']) . "</td><td width=\"50\" align=\"center\"><button type=\"button\" name=\"show_details\" value=\"DETAILS\" class=\"btn btn-success btn-sm\" onclick=\"showStatussesDialog('" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($row_events['message'], ENT_QUOTES))))) . "<hr><br><br>', '" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($row_events['subject'], ENT_QUOTES))))) . "<hr><br><br>', '" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($row_events['body'], ENT_QUOTES))))) . "')\"><i class=\"fa fa-search-plus\" aria-hidden=\"true\"></i></button></td></tr>\n";

		if($row_events['type'] == 0){
			$events_insert .= "											<tr><td width=\"140\">" . date("d.m.Y (H:i)", intval($row_events['time'])) . "</td><td>" . $row_events['admin_name'] . ", " . str_replace("\r\n", "", $row_events['message']) . "</td><td width=\"50\" align=\"center\"><button type=\"button\" name=\"show_details\" value=\"DETAILS\" class=\"btn btn-success btn-sm\" onclick=\"showStatussesDialog('" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($row_events['message'], ENT_QUOTES))))) . "<hr><br><br>', '" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($row_events['subject'], ENT_QUOTES))))) . "<hr><br><br>', '" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($row_events['body'], ENT_QUOTES))))) . "')\"><i class=\"fa fa-search-plus\" aria-hidden=\"true\"></i></button></td></tr>\n";
		}

		if($row_events['type'] == 1){
			$events_update .= "											<tr><td width=\"140\">" . date("d.m.Y (H:i)", intval($row_events['time'])) . "</td><td>" . $row_events['admin_name'] . ", " . str_replace("\r\n", "", $row_events['message']) . "</td><td width=\"50\" align=\"center\"><button type=\"button\" name=\"show_details\" value=\"DETAILS\" class=\"btn btn-success btn-sm\" onclick=\"showStatussesDialog('" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($row_events['message'], ENT_QUOTES))))) . "<hr><br><br>', '" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($row_events['subject'], ENT_QUOTES))))) . "<hr><br><br>', '" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($row_events['body'], ENT_QUOTES))))) . "')\"><i class=\"fa fa-search-plus\" aria-hidden=\"true\"></i></button></td></tr>\n";
		}

		if($row_events['type'] == 2){
			$events_delete .= "											<tr><td width=\"140\">" . date("d.m.Y (H:i)", intval($row_events['time'])) . "</td><td>" . $row_events['admin_name'] . ", " . str_replace("\r\n", "", $row_events['message']) . "</td><td width=\"50\" align=\"center\"><button type=\"button\" name=\"show_details\" value=\"DETAILS\" class=\"btn btn-success btn-sm\" onclick=\"showStatussesDialog('" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($row_events['message'], ENT_QUOTES))))) . "<hr><br><br>', '" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($row_events['subject'], ENT_QUOTES))))) . "<hr><br><br>', '" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($row_events['body'], ENT_QUOTES))))) . "')\"><i class=\"fa fa-search-plus\" aria-hidden=\"true\"></i></button></td></tr>\n";
		}

	}

	$options_admin_id = "";

	$admin_name = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`admin` 
									WHERE 		`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
									ORDER BY 	CAST(`admin`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$options_admin_id .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? (intval($_POST['admin_id']) == $row['id'] ? " selected=\"selected\"" : "") : (intval($row_order["admin_id"]) == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";
		if(intval($row_order["admin_id"]) == $row['id']){
			$admin_name = $row['name'];
		}
	}

	$options_component = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`reasons` 
									WHERE 		`reasons`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
									ORDER BY 	CAST(`reasons`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$options_component .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? (intval($_POST['component']) == $row['id'] ? " selected=\"selected\"" : "") : (intval($row_order["component"]) == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";
	}

	$options_countries = "";
	$options_differing_countries = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`countries` 
									WHERE 		`countries`.`frontend`='1' 
									ORDER BY 	`countries`.`name` ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$options_countries .= "								<option value=\"" . $row['id'] . "\" data-code=\"" . $row['code'] . "\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? (intval($_POST['country']) == $row['id'] ? " selected=\"selected\"" : "") : (intval($row_order["country"]) == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";
		$options_differing_countries .= "								<option value=\"" . $row['id'] . "\" data-code=\"" . $row['code'] . "\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? (intval($_POST['differing_country']) == $row['id'] ? " selected=\"selected\"" : "") : (intval($row_order["differing_country"]) == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";
	}

	$result_templates = mysqli_query($conn, "	SELECT 		* 
												FROM 		`templates` 
												WHERE 		`templates`.`type`=1 
												AND 		`templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
												AND 		`templates`.`id`!=(SELECT email_template FROM `statuses` WHERE id=" . $maindata['order_status_intern'] . ") 
												AND 		`templates`.`id`!=(SELECT email_template FROM `statuses` WHERE id=" . $maindata['order_status'] . ") 
												AND 		`templates`.`id`!=(SELECT email_template FROM `statuses` WHERE id=" . $maindata['shipping_status'] . ") 
												AND 		`templates`.`id`!=(SELECT email_template FROM `statuses` WHERE id=" . $maindata['shipping_cancel_status'] . ") 
												AND 		`templates`.`id`!=(SELECT email_template FROM `statuses` WHERE id=" . $maindata['interested_to_order_status'] . ") 
												AND 		`templates`.`id`!=(SELECT email_template FROM `statuses` WHERE id=" . $maindata['order_to_archive_status'] . ") 
												AND 		`templates`.`id`!=(SELECT email_template FROM `statuses` WHERE id=" . $maindata['archive_to_order_status'] . ") 
												ORDER BY 	CAST(`templates`.`id` AS UNSIGNED) ASC");

	$new_email_options = "";

	while($row = $result_templates->fetch_array(MYSQLI_ASSOC)){

		$new_email_options .= "				<option value=\"" . $row["id"] . "\"" . (isset($_SESSION["email_template"]["id"]) && $row["id"] == $_SESSION["email_template"]["id"] ? " selected=\"selected\"" : "") . ">" . substr($row['name'], 0, 80) . "</option>\n";

	}

	$result_statuses = mysqli_query($conn, "	SELECT 		* 
												FROM 		`statuses` 
												WHERE 		`statuses`.`type`=1 
												AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
												AND 		`statuses`.`id`!=" . $maindata['order_status_intern'] . " 
												AND 		`statuses`.`id`!=" . $maindata['order_status'] . " 
												AND 		`statuses`.`id`!=" . $maindata['shipping_status'] . " 
												AND 		`statuses`.`id`!=" . $maindata['shipping_cancel_status'] . " 
												AND 		`statuses`.`id`!=" . $maindata['email_status'] . " 
												AND 		`statuses`.`id`!=" . $maindata['interested_to_order_status'] . " 
												AND 		`statuses`.`id`!=" . $maindata['order_to_archive_status'] . " 
												AND 		`statuses`.`id`!=" . $maindata['archive_to_order_status'] . " 
												ORDER BY 	CAST(`statuses`.`id` AS UNSIGNED) ASC");

	$new_status_options = "";

	while($row = $result_statuses->fetch_array(MYSQLI_ASSOC)){
		$new_status_options .= "				<option value=\"" . $row["id"] . "\"" . (isset($_POST["status_id"]) && $row["id"] == $_POST["status_id"] ? " selected=\"selected\"" : "") . ">" . substr($row['name'], 0, 80) . "</option>\n";
	}

	$apiPrefix = $maindata['vindecoder_url'];
	$apikey = $maindata['vindecoder_api_key'];
	$secretkey = $maindata['vindecoder_secret'];
	$id = "decode";
	$vin = strtoupper($row_order['carid']);

	$controlsum = substr(sha1("{$vin}|{$id}|{$apikey}|{$secretkey}"), 0, 10);

	$data = file_get_contents("{$apiPrefix}/{$apikey}/{$controlsum}/decode/{$vin}.json", false);
	$result = json_decode($data);

	$list_vindecoder = "";

	if(isset($result->decode) && count($result->decode) > 0){
		for($i = 0;$i < count($result->decode);$i++){
			$list_vindecoder .= "<div class=\"row\">\n" . 
								"	<label class=\"col-sm-6\">" . $result->decode[$i]->label . "</label>\n" . 
								"	<div class=\"col-sm-6\">" . (is_array($result->decode[$i]->value) ? $result->decode[$i]->value[0] : $result->decode[$i]->value) . "</div>\n" . 
								"</div>\n";
		}
	}

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card bg-" . $row_admin["bgcolor_card"] . " text-" . $row_admin["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<ul class=\"nav nav-tabs card-header-tabs\" id=\"myTab\" role=\"tablist\">\n" . 
				"					<li class=\"nav-item\">\n" . 
				"						<a class=\"nav-link text-primary" . ($tab == "edit" ? " active" : "") . "\" id=\"edit-tab\" data-toggle=\"tab\" href=\"#edit\" role=\"tab\" aria-controls=\"edit\" aria-selected=\"" . ($tab == "edit" ? "true" : "false") . "\">Kundendaten</a>\n" . 
				"					</li>\n" . 
				"					<li class=\"nav-item\">\n" . 
				"						<a class=\"nav-link text-primary" . ($tab == "order_data" ? " active" : "") . "\" id=\"order-data-tab\" data-toggle=\"tab\" href=\"#order_data\" role=\"tab\" aria-controls=\"order_data\" aria-selected=\"" . ($tab == "order_data" ? "true" : "false") . "\">Auftragsdaten</a>\n" . 
				"					</li>\n" . 
				"					<li class=\"nav-item\">\n" . 
				"						<a class=\"nav-link text-primary" . ($tab == "files" ? " active" : "") . "\" id=\"files-tab\" data-toggle=\"tab\" href=\"#files\" role=\"tab\" aria-controls=\"files\" aria-selected=\"" . ($tab == "files" ? "true" : "false") . "\">Dateien</a>\n" . 
				"					</li>\n" . 
				"					<li class=\"nav-item\">\n" . 
				"						<a class=\"nav-link text-primary" . ($tab == "new_status" ? " active" : "") . "\" id=\"new-status-tab\" data-toggle=\"tab\" href=\"#new_status\" role=\"tab\" aria-controls=\"new_status\" aria-selected=\"" . ($tab == "new_status" ? "true" : "false") . "\">Status &amp; E-Mail</a>\n" . 
				"					</li>\n" . 
				"					<li class=\"nav-item dropdown\">\n" . 
				"						<a href=\"#\" class=\"nav-link dropdown-toggle text-primary" . ($tab == "new_shipping_tab" || $tab == "tracking_tab" ? " active" : "") . "\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"" . ($tab == "new_shipping_tab" || $tab == "tracking_tab" ? "true" : "false") . "\">Versand</a>\n" . 
				"						<div class=\"dropdown-menu\">\n" . 
				"							<a class=\"dropdown-item" . ($tab == "tracking_tab" ? " active" : "") . "\" id=\"tracking-tab\" data-toggle=\"tab\" href=\"#tracking_tab\" role=\"tab\" aria-controls=\"tracking_controls\" aria-selected=\"" . ($tab == "tracking_tab" ? "true" : "false") . "\">Statusverlauf</a>\n" . 
				"						</div>\n" . 
				"					</li>\n" . 
				"					<li class=\"nav-item\">\n" . 
				"						<a class=\"nav-link text-primary" . ($tab == "customer_message" ? " active" : "") . "\" id=\"customer-message-tab\" data-toggle=\"tab\" href=\"#customer_message\" role=\"tab\" aria-controls=\"customer_message\" aria-selected=\"" . ($tab == "customer_message" ? "true" : "false") . "\">Kundenhistorie</a>\n" . 
				"					</li>\n" . 
				"					<li class=\"nav-item\">\n" . 
				"						<a class=\"nav-link text-primary" . ($tab == "history" ? " active" : "") . "\" id=\"history-tab\" data-toggle=\"tab\" href=\"#history\" role=\"tab\" aria-controls=\"history\" aria-selected=\"" . ($tab == "history" ? "true" : "false") . "\">Auftragshistorie</a>\n" . 
				"					</li>\n" . 
				"					<li class=\"nav-item\">\n" . 
				"						<a class=\"nav-link text-primary" . ($tab == "events" ? " active" : "") . "\" id=\"events-tab\" data-toggle=\"tab\" href=\"#events\" role=\"tab\" aria-controls=\"events\" aria-selected=\"" . ($tab == "events" ? "true" : "false") . "\">Ereignisse</a>\n" . 
				"					</li>\n" . 
				"				</ul>\n" . 
				"			</div>\n" . 
				"			<div class=\"tab-content\" id=\"myTabContent\">\n" . 
				// TAB Bearbeiten
				"			<div class=\"card-body tab-pane fade px-3 pt-3 pb-0" . ($tab == "edit" ? " show active" : "") . "\" id=\"edit\" role=\"tabpanel\" aria-labelledby=\"profile-tab\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "\" method=\"post\" enctype=\"multipart/form-data\">\n" . 

				"					<div class=\"row\">\n" . 
				"						<div class=\"col-6 border-right\">\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-12\">\n" . 
				"									<strong>Rechnungsanschrift</strong>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-12\">\n" . 
				"									<input type=\"text\" id=\"companyname\" name=\"companyname\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $companyname : $row_order["companyname"]) . "\" class=\"form-control" . $inp_companyname . "\" placeholder=\"Firma\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-4 mt-2\">\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"gender_0\" name=\"gender\" value=\"0\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $_POST['gender'] : $row_order["gender"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"gender_0\">\n" . 
				"											Herr\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"gender_1\" name=\"gender\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $_POST['gender'] : $row_order["gender"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"gender_1\">\n" . 
				"											Frau\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<input type=\"text\" id=\"firstname\" name=\"firstname\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $firstname : $row_order["firstname"]) . "\" class=\"form-control" . $inp_firstname . "\" placeholder=\"Vorname\" />\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<input type=\"text\" id=\"lastname\" name=\"lastname\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $lastname : $row_order["lastname"]) . "\" class=\"form-control" . $inp_lastname . "\" placeholder=\"Nachname\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-9\">\n" . 
				"									<input type=\"text\" id=\"street\" name=\"street\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $street : $row_order["street"]) . "\" class=\"form-control" . $inp_street . "\" placeholder=\"Straße\" />\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-3\">\n" . 
				"									<input type=\"text\" id=\"streetno\" name=\"streetno\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $streetno : $row_order["streetno"]) . "\" class=\"form-control" . $inp_streetno . "\" placeholder=\"Nr\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<input type=\"text\" id=\"zipcode\" name=\"zipcode\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $zipcode : $row_order["zipcode"]) . "\" class=\"form-control" . $inp_zipcode . "\" placeholder=\"Postleitzahl\" />\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<input type=\"text\" id=\"city\" name=\"city\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $city : $row_order["city"]) . "\" class=\"form-control" . $inp_city . "\" placeholder=\"Ort\" />\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<select id=\"country\" name=\"country\" class=\"custom-select" . $inp_country . "\">\n" . 

				$options_countries . 

				"									</select>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<input type=\"text\" id=\"email\" name=\"email\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $email : $row_order["email"]) . "\" class=\"form-control" . $inp_email . "\" placeholder=\"Email\" />\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<input type=\"text\" id=\"mobilnumber\" name=\"mobilnumber\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $mobilnumber : $row_order["mobilnumber"]) . "\" class=\"form-control" . $inp_mobilnumber . "\" placeholder=\"Mobil\" />\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<input type=\"text\" id=\"phonenumber\" name=\"phonenumber\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $phonenumber : $row_order["phonenumber"]) . "\" class=\"form-control" . $inp_phonenumber . "\" placeholder=\"Festnetz\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-5 col-form-label\">Andere Lieferadresse</label>\n" . 
				"								<div class=\"col-sm-7\">\n" . 
				"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"										<input type=\"checkbox\" id=\"differing_shipping_address\" name=\"differing_shipping_address\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $differing_shipping_address : $row_order["differing_shipping_address"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" onclick=\"\$('#differing_shipping_address_hide').toggleClass('d-none').toggleClass('d-block');\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"differing_shipping_address\">\n" . 
				"											Ja\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div id=\"differing_shipping_address_hide\" class=\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $differing_shipping_address : $row_order["differing_shipping_address"]) == 1 ? "d-block" : "d-none") . "\">\n" . 

				"								<div class=\"form-group row\">\n" . 
				"									<div class=\"col-sm-12\">\n" . 
				"										<input type=\"text\" id=\"differing_companyname\" name=\"differing_companyname\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $differing_companyname : $row_order["differing_companyname"]) . "\" class=\"form-control" . $inp_differing_companyname . "\" placeholder=\"Firma\" />\n" . 
				"									</div>\n" . 
				"								</div>\n" . 

				"								<div class=\"form-group row\">\n" . 
				"									<div class=\"col-sm-4 mt-2\">\n" . 
				"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"											<input type=\"radio\" id=\"differing_gender_0\" name=\"differing_gender\" value=\"0\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $_POST['differing_gender'] : $row_order["differing_gender"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"											<label class=\"custom-control-label\" for=\"differing_gender_0\">\n" . 
				"												Herr\n" . 
				"											</label>\n" . 
				"										</div>\n" . 
				"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"											<input type=\"radio\" id=\"differing_gender_1\" name=\"differing_gender\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $_POST['differing_gender'] : $row_order["differing_gender"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"											<label class=\"custom-control-label\" for=\"differing_gender_1\">\n" . 
				"												Frau\n" . 
				"											</label>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"col-sm-4\">\n" . 
				"										<input type=\"text\" id=\"differing_firstname\" name=\"differing_firstname\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $differing_firstname : $row_order["differing_firstname"]) . "\" class=\"form-control" . $inp_differing_firstname . "\" placeholder=\"Vorname\" />\n" . 
				"									</div>\n" . 
				"									<div class=\"col-sm-4\">\n" . 
				"										<input type=\"text\" id=\"differing_lastname\" name=\"differing_lastname\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $differing_lastname : $row_order["differing_lastname"]) . "\" class=\"form-control" . $inp_differing_lastname . "\" placeholder=\"Nachname\" />\n" . 
				"									</div>\n" . 
				"								</div>\n" . 

				"								<div class=\"form-group row\">\n" . 
				"									<div class=\"col-sm-9\">\n" . 
				"										<input type=\"text\" id=\"differing_street\" name=\"differing_street\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $differing_street : $row_order["differing_street"]) . "\" class=\"form-control" . $inp_differing_street . "\" placeholder=\"Straße\" />\n" . 
				"									</div>\n" . 
				"									<div class=\"col-sm-3\">\n" . 
				"										<input type=\"text\" id=\"differing_streetno\" name=\"differing_streetno\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $differing_streetno : $row_order["differing_streetno"]) . "\" class=\"form-control" . $inp_differing_streetno . "\" placeholder=\"Nr\" />\n" . 
				"									</div>\n" . 
				"								</div>\n" . 

				"								<div class=\"form-group row\">\n" . 
				"									<div class=\"col-sm-4\">\n" . 
				"										<input type=\"text\" id=\"differing_zipcode\" name=\"differing_zipcode\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $differing_zipcode : $row_order["differing_zipcode"]) . "\" class=\"form-control" . $inp_differing_zipcode . "\" placeholder=\"Postleitzahl\" />\n" . 
				"									</div>\n" . 
				"									<div class=\"col-sm-4\">\n" . 
				"										<input type=\"text\" id=\"differing_city\" name=\"differing_city\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $differing_city : $row_order["differing_city"]) . "\" class=\"form-control" . $inp_differing_city . "\" placeholder=\"Ort\" />\n" . 
				"									</div>\n" . 
				"									<div class=\"col-sm-4\">\n" . 
				"										<select id=\"differing_country\" name=\"differing_country\" class=\"custom-select" . $inp_differing_country . "\">\n" . 

				$options_differing_countries . 

				"										</select>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 

				"							</div>\n" . 

				"						</div>\n" . 
				"						<div class=\"col-6\">\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-12\">\n" . 
				"									<strong>Weitere Optionen</strong>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"ref_number\" class=\"col-sm-4 col-form-label\">Referenznummer</label>\n" . 
				"								<div class=\"col-sm-5\">\n" . 
				"									<input type=\"text\" id=\"ref_number\" name=\"ref_number1\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $ref_number : $row_order["ref_number"]) . "\" disabled=\"disabled\" class=\"form-control" . $inp_ref_number . "\" />\n" . 
				"									<input type=\"hidden\" id=\"ref_number1\" name=\"ref_number\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $ref_number : $row_order["ref_number"]) . "\" class=\"form-control" . $inp_ref_number . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"ref_number\" class=\"col-sm-4 col-form-label\">Datum</label>\n" . 
				"								<div class=\"col-sm-5\">\n" . 
				"									<input type=\"text\" id=\"date\" name=\"date\" value=\"" . date("d.m.Y", $row_order["reg_date"]) . "\" disabled=\"disabled\" class=\"form-control\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"admin_id\" class=\"col-sm-4 col-form-label\">Lead</label>\n" . 
				"								<div class=\"col-sm-5\">\n" . 
				"									<select id=\"admin_id_1\" name=\"admin_id\" class=\"custom-select d-none\">\n" . 

				$options_admin_id . 

				"									</select>\n" . 
				"									<input type=\"text\" id=\"admin_id\" name=\"admin_id_1\" value=\"" . $admin_name . "\" disabled=\"disabled\" class=\"form-control\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"call_date\" class=\"col-sm-4 col-form-label\">Termin</label>\n" . 
				"								<div class=\"col-sm-5\">\n" . 
				"									<div class=\"input-group date\">\n" . 
				"										<input type=\"text\" id=\"datepicker\" name=\"call_date\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? date("d.m.Y", intval($call_date)) : date("d.m.Y", intval($row_order["call_date"]))) . "\" placeholder=\"00.00.0000\" class=\"form-control" . $inp_call_date . "\" />\n" . 
				"									    <div class=\"input-group-append\">\n" . 
				"											<span class=\"input-group-text\">Datum</span>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"pricemwst\" class=\"col-sm-4 col-form-label\">Reparaturfreigabe bis</label>\n" . 
				"								<div class=\"col-sm-5\">\n" . 
				"									<div class=\"input-group\">\n" . 
				"										<input type=\"hidden\" id=\"pricemwst_1\" name=\"pricemwst\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? number_format($pricemwst, 2, ',', '') : number_format($row_order["pricemwst"], 2, ',', '')) . "\" />\n" . 
				"										<input type=\"text\" id=\"pricemwst\" name=\"pricemwst_1\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? number_format($pricemwst, 2, ',', '') : number_format($row_order["pricemwst"], 2, ',', '')) . "\" class=\"form-control" . $inp_pricemwst . "\" disabled=\"disabled\" />\n" . 
				"										<div class=\"input-group-append\">\n" . 
				"											<span class=\"input-group-text\">&euro;</span>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\">Versand</label>\n" . 
				"								<div class=\"col-sm-8 mt-2\">\n" . 

				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"radio_shipping_standart\" name=\"radio_shipping\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_shipping : $row_order["radio_shipping"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"radio_shipping_standart\">\n" . 
				"											Standard\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"radio_shipping_express\" name=\"radio_shipping\" value=\"0\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_shipping : intval($row_order["radio_shipping"])) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"radio_shipping_express\">\n" . 
				"											Express\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"radio_shipping_international\" name=\"radio_shipping\" value=\"2\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_shipping : $row_order["radio_shipping"]) == 2 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"radio_shipping_international\">\n" . 
				"											International\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline\">\n" . 
				"										<input type=\"radio\" id=\"radio_shipping_self\" name=\"radio_shipping\" value=\"3\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_shipping : $row_order["radio_shipping"]) == 3 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"radio_shipping_self\">\n" . 
				"											Abholung\n" . 
				"										</label>\n" . 
				"									</div>\n" . 

				"								</div>\n" . 
				"							</div>\n" . 
				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\">Zahlart</label>\n" . 
				"								<div class=\"col-sm-8 mt-2\">\n" . 

				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"radio_payment_nachnahme\" name=\"radio_payment\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_payment : $row_order["radio_payment"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"radio_payment_nachnahme\">\n" . 
				"											Nachnahme\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"radio_payment_ueberweisung\" name=\"radio_payment\" value=\"0\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_payment : $row_order["radio_payment"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"radio_payment_ueberweisung\">\n" . 
				"											Überweisung\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline\">\n" . 
				"										<input type=\"radio\" id=\"radio_payment_bar\" name=\"radio_payment\" value=\"2\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_payment : $row_order["radio_payment"]) == 2 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"radio_payment_bar\">\n" . 
				"											Bar\n" . 
				"										</label>\n" . 
				"									</div>\n" . 

				"								</div>\n" . 
				"							</div>\n" . 

				"						</div>\n" . 
				"					</div>\n" . 
// ...
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-3\" align=\"right\">\n" . 
				"							&nbsp;\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"				</form>\n" . 
				"			</div>\n" . 
				// TAB Bearbeiten Ende

				// TAB Auftragsdaten
				"			<div class=\"card-body tab-pane fade px-3 pt-3 pb-0" . ($tab == "order_data" ? " show active" : "") . "\" id=\"order_data\" role=\"tabpanel\" aria-labelledby=\"order-data-tab\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "\" method=\"post\" enctype=\"multipart/form-data\">\n" . 

				"					<div class=\"row\">\n" . 
				"						<div class=\"col-6 border-right\">\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-12\">\n" . 
				"									<strong>Fahrzeugdaten</strong>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"machine\" class=\"col-sm-6 col-form-label\">Automarke</label>\n" . 
				"								<div class=\"col-sm-6\">\n" . 
				"									<input type=\"text\" id=\"machine\" name=\"machine\" value=\"" . (isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? $machine : $row_order["machine"]) . "\" class=\"form-control" . $inp_machine . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 
				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"model\" class=\"col-sm-6 col-form-label\">Automodell</label>\n" . 
				"								<div class=\"col-sm-6\">\n" . 
				"									<input type=\"text\" id=\"model\" name=\"model\" value=\"" . (isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? $model : $row_order["model"]) . "\" class=\"form-control" . $inp_model . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 
				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"constructionyear\" class=\"col-sm-6 col-form-label\">Baujahr</label>\n" . 
				"								<div class=\"col-sm-6\">\n" . 
				"									<input type=\"text\" id=\"constructionyear\" name=\"constructionyear\" value=\"" . (isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? $constructionyear : $row_order["constructionyear"]) . "\" class=\"form-control" . $inp_constructionyear . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 
				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"carid\" class=\"col-sm-6 col-form-label\">FIN / VIN</label>\n" . 
				"								<div class=\"col-sm-6\">\n" . 
				"									<input type=\"text\" id=\"carid\" name=\"carid\" value=\"" . (isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? strtoupper($carid) : strtoupper($row_order["carid"])) . "\" class=\"form-control" . $inp_carid . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 
				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"kw\" class=\"col-sm-6 col-form-label\">Fahrleistung (PS)</label>\n" . 
				"								<div class=\"col-sm-6\">\n" . 
				"									<input type=\"text\" id=\"kw\" name=\"kw\" value=\"" . (isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? $kw : $row_order["kw"]) . "\" class=\"form-control" . $inp_kw . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 
				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"mileage\" class=\"col-sm-6 col-form-label\">Kilometerstand</label>\n" . 
				"								<div class=\"col-sm-6\">\n" . 
				"									<div class=\"input-group date\">\n" . 
				"										<input type=\"text\" id=\"mileage\" name=\"mileage\" value=\"" . (isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? number_format($mileage, 0, '', '.') : number_format(intval($row_order["mileage"]), 0, '', '.')) . "\" class=\"form-control" . $inp_mileage . "\" />\n" . 
				"									    <span class=\"input-group-append\">\n" . 
				"											<span class=\"input-group-text\">KM</span>\n" . 
				"										</span>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 
				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-6 col-form-label\">Getriebe</label>\n" . 
				"								<div class=\"col-sm-6 mt-2\">\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"mechanism_0\" name=\"mechanism\" value=\"0\"" . ((isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? $mechanism : $row_order["mechanism"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"mechanism_0\">\n" . 
				"											Schaltung\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"mechanism_1\" name=\"mechanism\" value=\"1\"" . ((isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? $mechanism : $row_order["mechanism"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"mechanism_1\">\n" . 
				"											Automatik\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 
				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-6 col-form-label\">Kraftstoffart</label>\n" . 
				"								<div class=\"col-sm-6 mt-2\">\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"fuel_0\" name=\"fuel\" value=\"0\"" . ((isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? $fuel : $row_order["fuel"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"fuel_0\">\n" . 
				"											Benzin\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"fuel_1\" name=\"fuel\" value=\"1\"" . ((isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? $fuel : $row_order["fuel"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"fuel_1\">\n" . 
				"											Diesel\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"						</div>\n" . 
				"						<div class=\"col-6\">\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-12\">\n" . 
				"									<strong>Gerätedaten</strong>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"component\" class=\"col-sm-6 col-form-label\">Defektes Bauteil</label>\n" . 
				"								<div class=\"col-sm-6\">\n" . 
				"									<select id=\"component\" name=\"component\" class=\"custom-select" . $inp_component . "\">\n" . 
				"										<option value=\"0\">Bitte auswählen</option>\n" . 

				$options_component . 

				"									</select>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 
				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"manufacturer\" class=\"col-sm-6 col-form-label\">Hersteller</label>\n" . 
				"								<div class=\"col-sm-6\">\n" . 
				"									<input type=\"text\" id=\"manufacturer\" name=\"manufacturer\" value=\"" . (isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? $manufacturer : strtoupper($row_order["manufacturer"])) . "\" class=\"form-control" . $inp_manufacturer . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 
				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"serial\" class=\"col-sm-6 col-form-label\">Teile.-/Herstellernummer</label>\n" . 
				"								<div class=\"col-sm-6\">\n" . 
				"									<input type=\"text\" id=\"serial\" name=\"serial\" value=\"" . (isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? $serial : $row_order["serial"]) . "\" class=\"form-control" . $inp_serial . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 
				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-6 col-form-label\">Stammt das Gerät aus dem angegebenen Fahrzeug</label>\n" . 
				"								<div class=\"col-sm-6 mt-2\">\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"fromthiscar_yes\" name=\"fromthiscar\" value=\"1\"" . ((isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? $fromthiscar : $row_order["fromthiscar"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"fromthiscar_yes\">\n" . 
				"											Ja\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline\">\n" . 
				"										<input type=\"radio\" id=\"fromthiscar_no\" name=\"fromthiscar\" value=\"0\"" . ((isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? $fromthiscar : $row_order["fromthiscar"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"fromthiscar_no\">\n" . 
				"											Nein\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"						</div>\n" . 
				"					</div>\n" . 

				"					<br />\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<div class=\"col-sm-12\">\n" . 
				"							<strong>Fehlerbeschreibung</strong>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"reason\" class=\"col-sm-3 col-form-label\">Fehlerursache</label>\n" . 
				"						<div class=\"col-sm-9 text-right\">\n" . 
				"							<textarea id=\"reason\" name=\"reason\" style=\"height: 160px\" class=\"form-control" . $inp_reason . "\" onkeyup=\"if(this.value.length >= 700){this.value = this.value.substr(0, 700);alert('Die maximale Anzahl an erlaubten Zeichen wurde erreicht!');}$('#reason_length').html(this.value.length);\">" . (isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? $reason : $row_order["reason"]) . "</textarea>\n" . 
				"							<small>(<span id=\"reason_length\">" . strlen(isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? $reason : $row_order["reason"]) . "</span> von 700 Zeichen)</small>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"description\" class=\"col-sm-3 col-form-label\">Fehlerspeicher</label>\n" . 
				"						<div class=\"col-sm-9 text-right\">\n" . 
				"							<textarea id=\"description\" name=\"description\" style=\"height: 160px\" class=\"form-control" . $inp_description . "\" onkeyup=\"if(this.value.length >= 700){this.value = this.value.substr(0, 700);alert('Die maximale Anzahl an erlaubten Zeichen wurde erreicht!');}$('#description_length').html(this.value.length);\">" . (isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? $description : $row_order["description"]) . "</textarea>\n" . 
				"							<small>(<span id=\"description_length\">" . strlen(isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? $description : $row_order["description"]) . "</span> von 700 Zeichen)</small>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-3\" align=\"right\">\n" . 
				"							&nbsp;\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-9 text-right\">\n" . 
				"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
				/*"							<button type=\"submit\" name=\"order_data\" value=\"speichern\" class=\"btn btn-primary\" />speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
				"							<button type=\"submit\" name=\"delete\" value=\"entfernen\" onclick=\"return confirm('Wollen Sie den Eintrag wircklich entfernen?')\" class=\"btn btn-danger\">entfernen</button>\n" . */
				"						</div>\n" . 
				"					</div>\n" . 

				"				</form>\n" . 
				"			</div>\n" . 
				// TAB Auftragsdaten Ende

				// TAB Vorgänge Verlauf
				"			<div class=\"card-body tab-pane fade p-3" . ($tab == "new_status" ? " show active" : "") . "\" id=\"new_status\" role=\"tabpanel\" aria-labelledby=\"profile-tab\">\n" . 

				"				<div class=\"row\">\n" . 
				"					<div class=\"col-sm-6 border-right\">\n" . 

				$html_new_status . 

				"					</div>\n" . 
				"					<div class=\"col-sm-6\">\n" . 

				"						<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"email_template\" class=\"col-sm-3 col-form-label\">Email-Vorlage</label>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<select id=\"email_template\" name=\"email_template\" class=\"custom-select\">\n" . 

				$new_email_options . 

				"									</select>\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-5\">\n" . 
				"									<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
				"									<button type=\"submit\" name=\"new_email\" value=\"öffnen\" class=\"btn btn-success\">bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n" . 
				"									<button type=\"submit\" name=\"new_email\" value=\"sofort senden\" class=\"btn btn-primary\">senden <i class=\"fa fa-envelope-o\" aria-hidden=\"true\"></i></button>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 
				"						</form>\n" . 

				$html_new_email . 

				"					</div>\n" . 
				"				</div>\n" . 

				$list_status_history . 

				"					</table>\n" . 
				"				</div>\n" . 

				"			</div>\n" . 
				// TAB Vorgänge Verlauf Ende

				// TAB Kundenhistorie
				"			<div class=\"card-body tab-pane fade p-3" . ($tab == "customer_message" ? " show active" : "") . "\" id=\"customer_message\" role=\"tabpanel\" aria-labelledby=\"profile-tab\">\n" . 

				"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"status_id\" class=\"col-sm-3 col-form-label\">Nachricht</label>\n" . 
				"						<div class=\"col-sm-5\">\n" . 
				"							<textarea id=\"message\" name=\"message\" class=\"form-control\">" . $message . "</textarea>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-4\">\n" . 
				"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
				"							<button type=\"submit\" name=\"customer_message\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 

				$list_customer_history . 

				"					</table>\n" . 
				"				</div>\n" . 

				"			</div>\n" . 
				// TAB Kundenhistorie Ende

				// TAB Dateien
				"			<div class=\"card-body tab-pane fade p-3" . ($tab == "files" ? " show active" : "") . "\" id=\"files\" role=\"tabpanel\" aria-labelledby=\"profile-tab\">\n" . 

				($emsg_files != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg_files . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<div class=\"row\">\n" . 
				"					<div class=\"col-sm-6 border-right\">\n" . 

				"						<form action=\"" . $page['url'] . "\" method=\"post\" enctype=\"multipart/form-data\" onsubmit=\"var sumsize=0;for(var i=0;i<document.getElementById('file_document').files.length;i++){sumsize+=document.getElementById('file_document').files[i].size;}if(sumsize>(" . (int)ini_get("upload_max_filesize") . "*1024*1024)){alert('Die upload Datengröße ist zu hoch. Es sind nur " . (int)ini_get("upload_max_filesize") . "MB insgesammt erlaubt!');return false;}else{return true;}\">\n" . 
				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"file_document\" class=\"col-sm-12 col-form-label\">Dateien hinzufügen</label>\n" . 
				"								<div class=\"col-sm-12 px-3 pt-0 pb-3\">\n" . 
				"									<input type=\"file\" id=\"file_document\" name=\"file[]\" multiple=\"multiple\" accept=\"" . str_replace(", ", ",", $maindata['input_file_accept']) . "\" class=\"form-control\" onchange=\"var sumsize=0;for(var i=0;i<this.files.length;i++){sumsize+=this.files[i].size;}if(sumsize>(" . (int)ini_get("upload_max_filesize") . "*1024*1024)){alert('Die upload Datengröße ist zu hoch. Es sind nur " . (int)ini_get("upload_max_filesize") . "MB insgesammt erlaubt!');}\" />\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-12\">\n" . 
				"									<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
				"									<button type=\"submit\" name=\"upload\" value=\"hochladen\" class=\"btn btn-primary\">hochladen <i class=\"fa fa-sign-in\"></i></button>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 
				"						</form>\n" . 

				"					</div>\n" . 
				"					<div class=\"col-sm-6\">\n" . 

				$list_userdata . 
				
				"					</div>\n" . 
				"				</div>\n" . 
				"			</div>\n" . 
				// TAB Dateien Ende

				// TAB Auftragshistorie
				"			<div class=\"card-body tab-pane fade p-3" . ($tab == "history" ? " show active" : "") . "\" id=\"history\" role=\"tabpanel\" aria-labelledby=\"profile-tab\">\n" . 

				"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"message\" class=\"col-sm-3 col-form-label\">Nachricht</label>\n" . 
				"						<div class=\"col-sm-5\">\n" . 
				"							<textarea id=\"message\" name=\"message\" class=\"form-control\">" . $message . "</textarea>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-4\">\n" . 
				"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
				"							<button type=\"submit\" name=\"history\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 

				$list_history . 

				"					</table>\n" . 
				"				</div>\n" . 

				"			</div>\n" . 
				// TAB Auftragshistorie Ende

				// TAB Ereignisse
				"			<div class=\"card-body tab-pane fade p-3" . ($tab == "events" ? " show active" : "") . "\" id=\"events\" role=\"tabpanel\" aria-labelledby=\"events-tab\">\n" . 

				"				<div class=\"row\">\n" . 
				"					<div class=\"col\">\n" . 
				"						<div class=\"card card-maximize bg-" . $row_admin["bgcolor_card"] . " text-" . $row_admin["color_card"] . "\">\n" . 
				"							<div class=\"card-header\">\n" . 
				"								<div class=\"row\">\n" . 
				"									<div class=\"col-sm-8\">\n" . 
				"										<p class=\"text-primary\">Ereignishistorie</p>\n" . 
				"										<ul class=\"nav nav-tabs card-header-tabs\" id=\"eventsTab\" role=\"tablist\" style=\"float: left\">\n" . 
				"											<li class=\"nav-item\">\n" . 
				"												<a class=\"nav-link text-primary" . ($tab_events == "events_all" ? " active" : "") . "\" id=\"events_all-tab\" data-toggle=\"tab\" href=\"#events_all\" role=\"tab\" aria-controls=\"events_all\" aria-selected=\"" . ($tab_events == "events_all" ? "true" : "false") . "\">Alle</a>\n" . 
				"											</li>\n" . 
				"											<li class=\"nav-item\">\n" . 
				"												<a class=\"nav-link text-primary" . ($tab_events == "events_insert" ? " active" : "") . "\" id=\"events_insert-tab\" data-toggle=\"tab\" href=\"#events_insert\" role=\"tab\" aria-controls=\"events_insert\" aria-selected=\"" . ($tab_events == "events_insert" ? "true" : "false") . "\">Insert</a>\n" . 
				"											</li>\n" . 
				"											<li class=\"nav-item\">\n" . 
				"												<a class=\"nav-link text-primary" . ($tab_events == "events_update" ? " active" : "") . "\" id=\"events_update-tab\" data-toggle=\"tab\" href=\"#events_update\" role=\"tab\" aria-controls=\"events_update\" aria-selected=\"" . ($tab_events == "events_update" ? "true" : "false") . "\">Update</a>\n" . 
				"											</li>\n" . 
				"											<li class=\"nav-item\">\n" . 
				"												<a class=\"nav-link text-primary" . ($tab_events == "events_delete" ? " active" : "") . "\" id=\"events_delete-tab\" data-toggle=\"tab\" href=\"#events_delete\" role=\"tab\" aria-controls=\"events_delete\" aria-selected=\"" . ($tab_events == "events_delete" ? "true" : "false") . "\">Delete</a>\n" . 
				"											</li>\n" . 
				"										</ul>\n" . 
				"									</div>\n" . 
				"									<div class=\"col-sm-4 align-self-center\">\n" . 
				"										<form action=\"" . $page['url'] . "\" method=\"post\" enctype=\"multipart/form-data\" style=\"float: right\" class=\"\">\n" . 
				"											<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
				"											<button type=\"submit\" name=\"delete\" value=\"Auftrag unwiederuflich löschen\" onclick=\"return confirm('Wollen Sie den Eintrag wircklich entfernen?')\" class=\"btn btn-danger\">Auftrag unwiederuflich löschen</button>\n" . 
				"										</form>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 
				"							<div class=\"tab-content\" id=\"eventsTabContent\">\n" . 

				// TAB Ereignisse - Alle
				"								<div class=\"card-body tab-pane fade" . ($tab_events == "events_all" ? " show active" : "") . " p-2\" id=\"events_all\" role=\"tabpanel\" aria-labelledby=\"events_all-tab\">\n" . 
				"									<div class=\"table-responsive overflow-auto border\" style=\"height: 750px\">\n" . 
				"										<table class=\"table table-" . $row_admin["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
				"											<thead>\n" . 
				"												<tr class=\"bg-" . $row_admin["bgcolor_table_head"] . " text-" . $row_admin["color_table_head"] . "\">\n" . 
				"													<th><strong>Datum</strong></th>\n" . 
				"													<th><strong>Information</strong></th>\n" . 
				"													<th><strong>&nbsp;</strong></th>\n" . 
				"												</tr>\n" . 
				"											</thead>\n" . 

				$events_all . 

				"										</table>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				// TAB Ereignisse - Alle Ende

				// TAB Ereignisse - Insert's
				"								<div class=\"card-body tab-pane fade" . ($tab_events == "events_insert" ? " show active" : "") . " p-2\" id=\"events_insert\" role=\"tabpanel\" aria-labelledby=\"events_insert-tab\">\n" . 
				"									<div class=\"table-responsive overflow-auto border\" style=\"height: 750px\">\n" . 
				"										<table class=\"table table-" . $row_admin["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
				"											<thead>\n" . 
				"												<tr class=\"bg-" . $row_admin["bgcolor_table_head"] . " text-" . $row_admin["color_table_head"] . "\">\n" . 
				"													<th><strong>Datum</strong></th>\n" . 
				"													<th><strong>Information</strong></th>\n" . 
				"													<th><strong>&nbsp;</strong></th>\n" . 
				"												</tr>\n" . 
				"											</thead>\n" . 

				$events_insert . 

				"										</table>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				// TAB Ereignisse - Insert's Ende

				// TAB Ereignisse - Update's
				"								<div class=\"card-body tab-pane fade" . ($tab_events == "events_update" ? " show active" : "") . " p-2\" id=\"events_update\" role=\"tabpanel\" aria-labelledby=\"events_update-tab\">\n" . 
				"									<div class=\"table-responsive overflow-auto border\" style=\"height: 750px\">\n" . 
				"										<table class=\"table table-" . $row_admin["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
				"											<thead>\n" . 
				"												<tr class=\"bg-" . $row_admin["bgcolor_table_head"] . " text-" . $row_admin["color_table_head"] . "\">\n" . 
				"													<th><strong>Datum</strong></th>\n" . 
				"													<th><strong>Information</strong></th>\n" . 
				"													<th><strong>&nbsp;</strong></th>\n" . 
				"												</tr>\n" . 
				"											</thead>\n" . 

				$events_update . 

				"										</table>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				// TAB Ereignisse - Update's Ende

				// TAB Ereignisse - Delete's
				"								<div class=\"card-body tab-pane fade" . ($tab_events == "events_delete" ? " show active" : "") . " p-2\" id=\"events_delete\" role=\"tabpanel\" aria-labelledby=\"events_delete-tab\">\n" . 
				"									<div class=\"table-responsive overflow-auto border\" style=\"height: 750px\">\n" . 
				"										<table class=\"table table-" . $row_admin["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
				"											<thead>\n" . 
				"												<tr class=\"bg-" . $row_admin["bgcolor_table_head"] . " text-" . $row_admin["color_table_head"] . "\">\n" . 
				"													<th><strong>Datum</strong></th>\n" . 
				"													<th><strong>Information</strong></th>\n" . 
				"													<th><strong>&nbsp;</strong></th>\n" . 
				"												</tr>\n" . 
				"											</thead>\n" . 

				$events_delete . 

				"										</table>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				// TAB Ereignisse - Delete's Ende

				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</div>\n" . 
				
				"			</div>\n" . 
				// TAB Ereignisse Ende

				// TAB Status
				"			<div class=\"card-body tab-pane fade p-3" . ($tab == "tracking_tab" ? " show active" : "") . "\" id=\"tracking_tab\" role=\"tabpanel\" aria-labelledby=\"profile-tab\">\n" . 

				$list_shipments . 
				
				"			</div>\n" . 
				// TAB Status Ende

				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br />\n" . 
				"<br />\n" . 
				"<br />\n";

}

?>