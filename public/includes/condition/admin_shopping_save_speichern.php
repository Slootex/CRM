<?php 

	require_once('includes/class_dbbmailer.php');

	use setasign\Fpdi\Fpdi;

	require_once('includes/fpdf/fpdf.php');
	require_once('includes/fpdi/code39.php');
	require_once('includes/fpdi/autoload.php');

	if(strlen($_POST['order_number']) > 20){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Auftragsnummer ein. (max. 20 Zeichen)</small><br />\n";
		$inp_order_number = " is-invalid";
	} else {
		$order_number = strip_tags($_POST['order_number']);
		$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT `order_orders`.`id` AS id FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`order_number`='" . mysqli_real_escape_string($conn, $order_number) . "'"), MYSQLI_ASSOC);
		if(isset($row_order['id']) && $row_order['id'] > 0){
			$order_id = $row_order['id'];
		}
	}

	if(strlen($_POST['item_number']) > 20){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Artikelnummer ein. (max. 20 Zeichen)</small><br />\n";
		$inp_item_number = " is-invalid";
	} else {
		$item_number = strip_tags($_POST['item_number']);
	}

	if(strlen($_POST['suppliers']) < 1 || strlen($_POST['suppliers']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie ein Lieferant aus.</small><br />\n";
		$inp_suppliers = " is-invalid";
	} else {
		$suppliers = intval($_POST['suppliers']);
	}

	if(strlen($_POST['supplier']) > 20){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Lieferant an. (max. 20 Zeichen)</small><br />\n";
		$inp_supplier = " is-invalid";
	} else {
		$supplier = strip_tags($_POST['supplier']);
	}

	if(strlen($_POST['description']) > 1024){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Beschreibung ein. (max. 1024 Zeichen)</small><br />\n";
		$inp_description = " is-invalid";
	} else {
		$description = strip_tags($_POST['description']);
	}

	if(strlen($_POST['contact_emails']) < 1){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie an wie oft Angeschrieben wurde.</small><br />\n";
		$inp_contact_emails = " is-invalid";
	} else {
		$contact_emails = intval($_POST['contact_emails']);
	}

	if(strlen($_POST['info']) > 1024){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Info ein. (max. 1024 Zeichen)</small><br />\n";
		$inp_info = " is-invalid";
	} else {
		$info = strip_tags($_POST['info']);
	}

	if(strlen($_POST['price']) > 20){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Preis ein.</small><br />\n";
		$inp_price = " is-invalid";
	} else {
		$price = str_replace(",", ".", $_POST['price']);
	}

	if(strlen($_POST['radio_payment']) < 1 || strlen($_POST['radio_payment']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie eine Zahlart aus.</small><br />\n";
		$inp_radio_payment = " is-invalid";
	} else {
		$radio_payment = intval($_POST['radio_payment']);
	}

	if(strlen($_POST['url']) > 512){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Link ein. (max. 512 Zeichen)</small><br />\n";
		$inp_url = " is-invalid";
	} else {
		$url = strip_tags($_POST['url']);
	}

	if($_POST['email'] == "" || preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,26})$/", $_POST['email'])){
		$email = strip_tags($_POST['email']);
	} else {
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine E-Mail-Adresse ein.</small><br />\n";
		$inp_email = " is-invalid";
	}

	if(strlen($_POST['phonenumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Telefonnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_phonenumber = " is-invalid";
	} else {
		$phonenumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['phonenumber']));
	}

	if(strlen($_POST['faxlnumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Faxnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_faxnumber = " is-invalid";
	} else {
		$faxnumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['faxnumber']));
	}

	if(strlen($_POST['retoure_carrier']) < 1 || strlen($_POST['retoure_carrier']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie ein Retouredienst aus.</small><br />\n";
		$inp_retoure_carrier = " is-invalid";
	} else {
		$retoure_carrier = intval($_POST['retoure_carrier']);
	}

	if(strlen($_POST['shipping_id']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Link ein. (max. 256 Zeichen)</small><br />\n";
		$inp_shipping_id = " is-invalid";
	} else {
		$shipping_id = strip_tags($_POST['shipping_id']);
	}

	if($emsg == ""){

		$hash = $shopping_hash != "" ? bin2hex(random_bytes(32)) : "";

		$row_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "'"), MYSQLI_ASSOC);

		$time = time();

		$shopping_number = 0;

		while($shopping_number == 0){

			$random = rand(100001, 999999);

			$result = mysqli_query($conn, "SELECT * FROM `shopping_shoppings` WHERE `shopping_shoppings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `shopping_shoppings`.`shopping_number`='" . $random . "'");

			if($result->num_rows == 0){
				$shopping_number = $random;
			}

		}

		$domain = isset($_SERVER['HTTPS']) ? "https://" . $_SERVER['HTTP_HOST'] : "http://" . $_SERVER['HTTP_HOST'];

		mysqli_query($conn, "	INSERT 	`shopping_shoppings` 
								SET 	`shopping_shoppings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`shopping_shoppings`.`mode`='" . mysqli_real_escape_string($conn, $shopping_mode) . "', 
										`shopping_shoppings`.`creator_id`='" . mysqli_real_escape_string($conn, intval(isset($_POST['admin_id']) ? $_POST['admin_id'] : 0)) . "', 
										`shopping_shoppings`.`admin_id`='" . mysqli_real_escape_string($conn, intval(isset($_POST['admin_id']) ? $_POST['admin_id'] : 0)) . "', 
										`shopping_shoppings`.`shopping_number`='" . mysqli_real_escape_string($conn, $shopping_number) . "', 
										`shopping_shoppings`.`order_number`='" . mysqli_real_escape_string($conn, $order_number) . "', 
										`shopping_shoppings`.`order_id`='" . mysqli_real_escape_string($conn, $order_id) . "', 
										`shopping_shoppings`.`item_number`='" . mysqli_real_escape_string($conn, $item_number) . "', 
										`shopping_shoppings`.`suppliers`='" . mysqli_real_escape_string($conn, $suppliers) . "', 
										`shopping_shoppings`.`supplier`='" . mysqli_real_escape_string($conn, $supplier) . "', 
										`shopping_shoppings`.`description`='" . mysqli_real_escape_string($conn, $description) . "', 
										`shopping_shoppings`.`contact_emails`='" . mysqli_real_escape_string($conn, $contact_emails) . "', 
										`shopping_shoppings`.`info`='" . mysqli_real_escape_string($conn, $info) . "', 
										`shopping_shoppings`.`price`='" . mysqli_real_escape_string($conn, $price) . "', 
										`shopping_shoppings`.`radio_payment`='" . mysqli_real_escape_string($conn, $radio_payment) . "', 
										`shopping_shoppings`.`url`='" . mysqli_real_escape_string($conn, $url) . "', 
										`shopping_shoppings`.`email`='" . mysqli_real_escape_string($conn, $email) . "', 
										`shopping_shoppings`.`phonenumber`='" . mysqli_real_escape_string($conn, $phonenumber) . "', 
										`shopping_shoppings`.`faxnumber`='" . mysqli_real_escape_string($conn, $faxnumber) . "', 
										`shopping_shoppings`.`retoure_carrier`='" . mysqli_real_escape_string($conn, $retoure_carrier) . "', 
										`shopping_shoppings`.`shipping_id`='" . mysqli_real_escape_string($conn, $shipping_id) . "', 
										`shopping_shoppings`.`public`='1', 
										`shopping_shoppings`.`hash`='" . mysqli_real_escape_string($conn, strip_tags($hash)) . "', 
										`shopping_shoppings`.`run_date`='" . mysqli_real_escape_string($conn, intval($_POST['run_date'])) . "', 
										`shopping_shoppings`.`reg_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
										`shopping_shoppings`.`cpy_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
										`shopping_shoppings`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$_POST["id"] = $conn->insert_id;

		if(isset($_FILES['file_image']['name'])){
			move_uploaded_file($_FILES["file_image"]["tmp_name"], "uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/shopping/url_" . intval($_POST['id']) . ".pdf");
		}

		$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($order_id)) . "'"), MYSQLI_ASSOC);
		$row_reason = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `reasons` WHERE `reasons`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `reasons`.`id`='" . mysqli_real_escape_string($conn, intval($row_order['component'])) . "'"), MYSQLI_ASSOC);
		$row_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . mysqli_real_escape_string($conn, intval($row_order['country'])) . "'"), MYSQLI_ASSOC);
		$row_differing_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . mysqli_real_escape_string($conn, intval($row_order['differing_country'])) . "'"), MYSQLI_ASSOC);

		$row_status = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`='" . mysqli_real_escape_string($conn, intval($maindata[$parameter['shopping_status']])) . "'"), MYSQLI_ASSOC);

		$row_template = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `templates` WHERE `templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `templates`.`id`='" . mysqli_real_escape_string($conn, intval($row_status['email_template'])) . "'"), MYSQLI_ASSOC);

		$row_template['body'] .= $row_admin['email_signature'];

		$status_number = intval($_SESSION["admin"]["id"]) . "A" . date("dmYHis", time());

		$fields = array('subject', 'body', 'admin_mail_subject');

		for($j = 0;$j < count($fields);$j++){

			$row_template[$fields[$j]] = str_replace("[status_id]", $status_number, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[status]", $row_status["name"], $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[id]", $shopping_number, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[order_id]", $order_number, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[date]", date("d.m.Y (H:i)", $time), $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[hash]", $hash, $row_template[$fields[$j]]);

			if(isset($row_order['id']) && $row_order['id'] > 0){

				$row_template[$fields[$j]] = str_replace("[companyname]", $row_order['companyname'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[gender]", ($row_order['gender'] == 1 ? "Sehr geehrte Frau" : "Sehr geehrter Herr"), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[sexual]", ($row_order['gender'] == 1 ? "Frau" : "Herr"), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[firstname]", $row_order['firstname'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[lastname]", $row_order['lastname'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[street]", $row_order['street'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[streetno]", $row_order['streetno'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[zipcode]", $row_order['zipcode'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[city]", $row_order['city'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[country]", (isset($row_country['id']) ? $row_country['name'] : ""), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[phonenumber]", $row_order['phonenumber'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[mobilnumber]", $row_order['mobilnumber'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[email]", "<a href=\"mailto: " . $row_order['email'] . "\">" . $row_order['email'] . "</a>\n", $row_template[$fields[$j]]);
	
				$differing_shipping_address = 	$row_order['differing_shipping_address'] == 0 ? 
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
				$row_template[$fields[$j]] = str_replace("[differing_companyname]", $row_order['differing_companyname'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_firstname]", $row_order['differing_firstname'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_lastname]", $row_order['differing_lastname'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_street]", $row_order['differing_street'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_streetno]", $row_order['differing_streetno'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_zipcode]", $row_order['differing_zipcode'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_city]", $row_order['differing_city'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_country]", (isset($row_differing_country['id']) ? $row_differing_country['name'] : ""), $row_template[$fields[$j]]);
	
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
	
				$row_template[$fields[$j]] = str_replace("[machine]", strip_tags($row_order['machine']), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[model]", strip_tags($row_order['model']), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[constructionyear]", strip_tags($row_order['constructionyear']), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[carid]", strtoupper(strip_tags($row_order['carid'])), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[kw]", strip_tags($row_order['kw']), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[mileage]", number_format(intval($row_order['mileage']), 0, '', '.') . " km", $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[mechanism]", ($row_order['mechanism'] == 0 ? "Schaltung" : "Automatik"), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[fuel]", ($row_order['fue'] == 0 ? "Benzin" : "Diesel"), $row_template[$fields[$j]]);
	
				$row_template[$fields[$j]] = str_replace("[reason]", $row_order['reason'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[description]", $row_order['description'], $row_template[$fields[$j]]);

//				$row_template[$fields[$j]] = str_replace("[files]", $links, $row_template[$fields[$j]]);

			}

		}

		mysqli_query($conn, "	INSERT 	`" . $shopping_table . "_statuses` 
								SET 	`" . $shopping_table . "_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`" . $shopping_table . "_statuses`.`shopping_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`" . $shopping_table . "_statuses`.`status_number`='" . mysqli_real_escape_string($conn, $status_number) . "', 
										`" . $shopping_table . "_statuses`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`" . $shopping_table . "_statuses`.`status_id`='" . mysqli_real_escape_string($conn, intval($row_status['id'])) . "', 
										`" . $shopping_table . "_statuses`.`template`='" . mysqli_real_escape_string($conn, $row_template['name']) . "', 
										`" . $shopping_table . "_statuses`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
										`" . $shopping_table . "_statuses`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
										`" . $shopping_table . "_statuses`.`public`='1', 
										`" . $shopping_table . "_statuses`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$_SESSION["status"]["id"] = $conn->insert_id;

		mysqli_query($conn, "	INSERT 	`" . $shopping_table . "_events` 
								SET 	`" . $shopping_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`" . $shopping_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`" . $shopping_table . "_events`.`shopping_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`" . $shopping_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
										`" . $shopping_table . "_events`.`message`='" . mysqli_real_escape_string($conn, $shopping_name . ", erstellt, ID [#" . $_SESSION["status"]["id"] . "]") . "', 
										`" . $shopping_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
										`" . $shopping_table . "_events`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
										`" . $shopping_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$tracking_image = "<img src=\"" . $domain . "/email-logo/" . $_SESSION["admin"]["company_id"] . "/" . $order_number . "/" . $status_number . "\" width=\"0\" height=\"0\" border=\"0\" />\n";

		if($row_template['mail_with_pdf'] == 1){

			$filename = "begleitschein.pdf";

			$pdf = new Fpdi();

			$pdf->AddPage();

			require('includes/email_template_pdf_code_' . $row_template['id'] . '.php');

			$pdfdoc = $pdf->Output("", "S");

			if(isset($row_order['id']) && $row_status['usermail'] == 1 && $row_order['email'] != ""){

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

				$mail->body = str_replace("[track]", $tracking_image, $row_template['body']);

				if(!$mail->send()){
					$emsg .= "<small class=\"error text-muted\">Das versenden der E-Mail an den Kunden wurde abgebrochen!</small><br />\n";
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
					$emsg .= "<small class=\"error text-muted\">Das versenden der E-Mail an den Administrator wurde abgebrochen!</small><br />\n";
				}

			}

		}else{

			if(isset($row_order['id']) && $row_status['usermail'] == 1 && $row_order['email'] != ""){

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
					$emsg .= "<small class=\"error text-muted\">Das versenden der E-Mail an den Kunden wurde abgebrochen!</small><br />\n";
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
					$emsg .= "<small class=\"error text-muted\">Das versenden der E-Mail an den Administrator wurde abgebrochen!</small><br />\n";
				}

			}

		}

		$emsg = "<p>Der neue " . $shopping_name . " wurde erfolgreich hinzugefügt!</p>\n";

		$parameter['link'] = $parameter['link_edit'];

		$_POST["edit"] = "bearbeiten";

	}else{

		$_POST["add"] = "hinzufügen";

	}

?>