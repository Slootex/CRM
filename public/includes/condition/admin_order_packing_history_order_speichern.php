<?php 

	if(strlen($_POST['message']) < 1 || strlen($_POST['message']) > 65536){
		$emsg .= "<small class=\"error text-muted\">Bitte eine Nachricht eingeben. (max. 65536 Zeichen)</small><br />\n";
		$inp_message = " is-invalid";
	} else {
		$message = preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~", "<a href=\"\\0\" target=\"_blank\">Link öffnen</a>", $_POST['message']);
	}

	$sumsize = 0;

	$upload_max_filesize = (int)ini_get("upload_max_filesize");

	$j = 1;

	$allowed = explode(",", str_replace(".", "", str_replace(", ", ",", $maindata['input_file_accept'])));

	if(isset($_FILES["file"]["error"])){
		foreach($_FILES["file"]["error"] as $key => $error) {
			//if ($j <= 5 && $_FILES["file"]["name"][$key] != "") {
				$ext = pathinfo($_FILES["file"]["name"][$key], PATHINFO_EXTENSION);
				if(in_array($ext, $allowed)){
					$sumsize+=filesize($_FILES["file"]["tmp_name"][$key]);
				}
			//}
			$j++;
		}
		if($sumsize > $upload_max_filesize * 1024 * 1024){
			$emsg = "<p>Die upload Datengröße ist zu hoch. Es sind nur " . $upload_max_filesize . "MB insgesammt erlaubt!</p>";
		}
	}

	if($emsg == ""){

		$time = time();

		$packing_number = 0;

		while($packing_number == 0){

			$random = rand(100001, 999999);

			$result = mysqli_query($conn, "SELECT * FROM `packing_packings` WHERE `shopping_shoppings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `packing_packings`.`packing_number`='" . $random . "'");

			if($result->num_rows == 0){
				$packing_number = $random;
			}

		}

		mkdir("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/packing/" . $packing_number, 0777);
		mkdir("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/packing/" . $packing_number . "/document", 0777);
		copy("includes/.htaccess", "uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/packing/" . $packing_number . "/document/.htaccess");

		$domain = isset($_SERVER['HTTPS']) ? "https://" . $_SERVER['HTTP_HOST'] : "http://" . $_SERVER['HTTP_HOST'];

		$uploaddir = 'uploads/';
	
		$files = "";
	
		$j = 1;
	
		$allowed = explode(",", str_replace(".", "", str_replace(", ", ",", $maindata['input_file_accept'])));
	
		if(isset($_FILES["file"]["error"])){
			foreach($_FILES["file"]["error"] as $key => $error) {
				//if ($j <= 5 && $_FILES["file"]["name"][$key] != "") {
					$ext = pathinfo($_FILES["file"]["name"][$key], PATHINFO_EXTENSION);
					if(in_array($ext, $allowed)){
						$random = rand(1, 100000);
						$_FILES["file"]["name"][$key] = preg_replace("/[^a-z0-9\_\-\.]/i", '', strip_tags(basename($_FILES["file"]["name"][$key])));
						move_uploaded_file($_FILES["file"]["tmp_name"][$key], $uploaddir . "company/" . intval($_SESSION["admin"]["company_id"]) . "/packing/" . $packing_number . "/document/" . basename($random . '_' . $_FILES["file"]["name"][$key]));
						$files .= $files == "" ? $random . '_' . $_FILES["file"]["name"][$key] : "\r\n" . $random . '_' . $_FILES["file"]["name"][$key];
					}else{
						$emsg .= "<p>Der Dateityp " . $ext . " ist nicht erlaubt, " . $_FILES["file"]["name"][$key] . "</p>\n";
					}
				//}
				$j++;
			}
		}

		mysqli_query($conn, "	INSERT 	`packing_packings` 
								SET 	`packing_packings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`packing_packings`.`creator_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`packing_packings`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`packing_packings`.`agent_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`packing_packings`.`packing_number`='" . mysqli_real_escape_string($conn, $packing_number) . "', 
										`packing_packings`.`order_number`='" . mysqli_real_escape_string($conn, $row_order['order_number']) . "', 
										`packing_packings`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "', 
										`packing_packings`.`message`='" . mysqli_real_escape_string($conn, $message) . "', 
										`packing_packings`.`files`='" . mysqli_real_escape_string($conn, $files) . "', 
										`packing_packings`.`file1`='" . mysqli_real_escape_string($conn, intval(isset($_POST['file1']) ? $_POST['file1'] : 1)) . "', 
										`packing_packings`.`file2`='" . mysqli_real_escape_string($conn, intval(isset($_POST['file2']) ? $_POST['file2'] : 1)) . "', 
										`packing_packings`.`reg_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
										`packing_packings`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$_POST["packing_id"] = $conn->insert_id;

		$result = mysqli_query($conn, "	SELECT 		`order_orders_devices`.`id` AS id, 
													`order_orders_devices`.`device_number` AS device_number 
										FROM 		`order_orders_devices` `order_orders_devices` 
										WHERE 		`order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
										AND 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
										ORDER BY 	CAST(`order_orders_devices`.`reg_date` AS UNSIGNED) DESC");

		while($row_device = $result->fetch_array(MYSQLI_ASSOC)){
			if(isset($_POST['device_' . $row_device['id']]) && intval($_POST['device_' . $row_device['id']]) == 1){
				mysqli_query($conn, "	INSERT 	`packing_packings_devices` 
										SET 	`packing_packings_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
												`packing_packings_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "', 
												`packing_packings_devices`.`packing_id`='" . mysqli_real_escape_string($conn, intval($_POST["packing_id"])) . "', 
												`packing_packings_devices`.`device_id`='" . mysqli_real_escape_string($conn, intval($row_device['id'])) . "', 
												`packing_packings_devices`.`device_number`='" . mysqli_real_escape_string($conn, $row_device['device_number']) . "'");
			}
		}

		mysqli_query($conn, "	UPDATE	`order_orders` 
								SET 	`order_orders`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
								WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
								AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		mysqli_query($conn, "	INSERT 	`" . $order_table . "_packing_history` 
								SET 	`" . $order_table . "_packing_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`" . $order_table . "_packing_history`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`" . $order_table . "_packing_history`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
										`" . $order_table . "_packing_history`.`message`='" . mysqli_real_escape_string($conn, "Zu dem Auftrag " . $row_order['order_number'] . " wurde der Packtisch " . $packing_number . " erstellt.") . "', 
										`" . $order_table . "_packing_history`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$_SESSION["history"]["id"] = $conn->insert_id;

		$row_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . mysqli_real_escape_string($conn, intval($row_order['country'])) . "'"), MYSQLI_ASSOC);
		$row_differing_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . mysqli_real_escape_string($conn, intval($row_order['differing_country'])) . "'"), MYSQLI_ASSOC);

		$row_status = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`='" . mysqli_real_escape_string($conn, intval($maindata['packing_status'])) . "'"), MYSQLI_ASSOC);
		$row_template = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `templates` WHERE `templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `templates`.`id`='" . mysqli_real_escape_string($conn, intval($row_status['email_template'])) . "'"), MYSQLI_ASSOC);

		$row_template['body'] .= $row_admin['email_signature'];

		$status_number = intval($_SESSION["admin"]["id"]) . "A" . date("dmYHis", time());

		$fields = array('subject', 'body', 'admin_mail_subject');

		for($j = 0;$j < count($fields);$j++){

			$row_template[$fields[$j]] = str_replace("[status_id]", $status_number, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[status]", $row_status["name"], $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[packing_id]", $packing_number, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[id]", $row_order['order_number'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[date]", date("d.m.Y (H:i)", $time), $row_template[$fields[$j]]);

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
	
				$row_template[$fields[$j]] = str_replace("[description]", $row_order['description'], $row_template[$fields[$j]]);

//				$row_template[$fields[$j]] = str_replace("[files]", $links, $row_template[$fields[$j]]);

			}

		}


		mysqli_query($conn, "	INSERT 	`packing_packings_statuses` 
								SET 	`packing_packings_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`packing_packings_statuses`.`packing_id`='" . mysqli_real_escape_string($conn, intval($_POST["packing_id"])) . "', 
										`packing_packings_statuses`.`status_number`='" . mysqli_real_escape_string($conn, $status_number) . "', 
										`packing_packings_statuses`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`packing_packings_statuses`.`status_id`='" . mysqli_real_escape_string($conn, intval($row_status['id'])) . "', 
										`packing_packings_statuses`.`template`='" . mysqli_real_escape_string($conn, $row_template['name']) . "', 
										`packing_packings_statuses`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
										`packing_packings_statuses`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
										`packing_packings_statuses`.`public`='1', 
										`packing_packings_statuses`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$_SESSION["status"]["id"] = $conn->insert_id;

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

		$emsg = "<p>Der neue Packtisch wurde erfolgreich hinzugefügt!</p>\n";

	}

	$_POST['edit'] = "bearbeiten";

?>