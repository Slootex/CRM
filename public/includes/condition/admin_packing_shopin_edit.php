<?php 

	require_once('includes/class_dbbmailer.php');

	use setasign\Fpdi\Fpdi;

	require_once('includes/fpdf/fpdf.php');
	require_once('includes/fpdi/code39.php');
	require_once('includes/fpdi/autoload.php');

	$row_shopin = mysqli_fetch_array(mysqli_query($conn, "	SELECT		* 
															FROM		`shopin_shopins` 
															WHERE		`shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
															AND 		`shopin_shopins`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	if(isset($_POST['shopin_order']) && $_POST['shopin_order'] == "zuweisen"){

		$time = time();

		$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['order_id'])) . "'"), MYSQLI_ASSOC);

		if(intval($row_order['transfer_date']) == 0){

			mysqli_query($conn, "	UPDATE 	`order_orders` 
									SET 	`order_orders`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`order_orders`.`mode`='0', 
											`order_orders`.`transfer_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
											`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
									WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['order_id'])) . "' 
									AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		}else{

			mysqli_query($conn, "	UPDATE 	`order_orders` 
									SET 	`order_orders`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`order_orders`.`mode`='0', 
											`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
									WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['order_id'])) . "' 
									AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		}

		$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND  `order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['order_id'])) . "'"), MYSQLI_ASSOC);

		if(isset($row_order['id']) && $row_order['mode'] < 2){

			$order_name = "Auftrag";

			$order_table = "order_orders";

			$order_id_field = "order_id";

			$status_field = "order_new_device_status";

		}else{

			$order_name = "Interessent";

			$order_table = "interested_interesteds";

			$order_id_field = "interested_id";

			$status_field = "interested_new_device_status";

		}

		if($row_shopin['device_id'] == 0){

			$device_number = $row_order['order_number'];

			for($i = 11;$i < 100;$i++){

				$number = $device_number . "-" . $i;

				$result = mysqli_query($conn, "SELECT * FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`device_number`='" . $number . "'");

				if($result->num_rows == 0){
					$device_number = $number;
					break;
				}

			}

			$row_devices_count = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS c FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "'"), MYSQLI_ASSOC);

			$row_storage_place = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_shopin['storage_space_id'])) . "'"), MYSQLI_ASSOC);

			mysqli_query($conn, "	INSERT 	`order_orders_devices` 
									SET 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
											`order_orders_devices`.`creator_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "', 
											`order_orders_devices`.`device_number`='" . mysqli_real_escape_string($conn, strip_tags($device_number)) . "', 
											`order_orders_devices`.`storage_space`='" . mysqli_real_escape_string($conn, strip_tags(isset($row_storage_place['name']) ? $row_storage_place['name'] : "")) . "', 
											`order_orders_devices`.`storage_space_id`='" . mysqli_real_escape_string($conn, intval($row_shopin['storage_space_id'])) . "', 
											`order_orders_devices`.`storage_space_owner`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`order_orders_devices`.`storage_space_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
											`order_orders_devices`.`open_by_user`='" . mysqli_real_escape_string($conn, intval($row_shopin['open_by_user'])) . "', 
											`order_orders_devices`.`other_components`='" . mysqli_real_escape_string($conn, intval($row_shopin['other_components'])) . "', 
											`order_orders_devices`.`star`='" . mysqli_real_escape_string($conn, intval($row_devices_count['c'] == 0 ? 1 : 0)) . "', 
											`order_orders_devices`.`reg_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
											`order_orders_devices`.`is_labeling`='1', 
											`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

			$_POST["device_id"] = $conn->insert_id;

			if(file_exists("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/" . $row_shopin['help_device_number'] . ".pdf")){

				$random = rand(1, 100000);

				copy("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/" . $row_shopin['help_device_number'] . ".pdf", "uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/document/" . $random . '_' . $row_order['order_number'] . ".pdf");

				//@unlink("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/" . $row_shopin['help_device_number'] . ".pdf");

				mysqli_query($conn, "	INSERT 	`order_orders_files` 
										SET 	`order_orders_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
												`order_orders_files`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
												`order_orders_files`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "', 
												`order_orders_files`.`device_id`='" . mysqli_real_escape_string($conn, intval($_POST["device_id"])) . "', 
												`order_orders_files`.`type`='5', 
												`order_orders_files`.`file`='" . mysqli_real_escape_string($conn, $random . '_' . $row_order['order_number'] . ".pdf") . "', 
												`order_orders_files`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

			}

			$files = scandir("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/");

			foreach($files as $k => $filename){

				if($filename != "." && $filename != ".." && $filename != ".htaccess" && $filename != "@eaDir"){

					$order_number = explode("_", $filename);

					if($row_shopin['help_device_number'] == $order_number[0]){

						$random = rand(1, 100000);

						copy("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/" . $filename, "uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/document/" . $random . '_' . $filename);

						//@unlink("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/" . $filename);

						mysqli_query($conn, "	INSERT 	`order_orders_files` 
												SET 	`order_orders_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
														`order_orders_files`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
														`order_orders_files`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "', 
														`order_orders_files`.`device_id`='" . mysqli_real_escape_string($conn, intval($_POST["device_id"])) . "', 
														`order_orders_files`.`type`='6', 
														`order_orders_files`.`file`='" . mysqli_real_escape_string($conn, $random . '_' . $filename) . "', 
														`order_orders_files`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

					}

				}

			}

			mysqli_query($conn, "	INSERT 	`order_orders_devices_events` 
									SET 	`order_orders_devices_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
											`order_orders_devices_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
											`order_orders_devices_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['order_id'])) . "', 
											`order_orders_devices_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
											`order_orders_devices_events`.`message`='" . mysqli_real_escape_string($conn, "<span class=\"badge badge-success\">Gerät " . strip_tags($device_number) . ", erstellt, ID [#" . intval($_POST["device_id"]) . "]</span>") . "', 
											`order_orders_devices_events`.`subject`='', 
											`order_orders_devices_events`.`body`='', 
											`order_orders_devices_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

			mysqli_query($conn, "	UPDATE 	`shopin_shopins` 
									SET 	`shopin_shopins`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`shopin_shopins`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['order_id'])) . "', 
											`shopin_shopins`.`order_number`='" . mysqli_real_escape_string($conn, intval($row_order['order_number'])) . "', 
											`shopin_shopins`.`device_id`='" . mysqli_real_escape_string($conn, intval($_POST['device_id'])) . "', 
											`shopin_shopins`.`storage_space_id`='0', 
											`shopin_shopins`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
									WHERE 	`shopin_shopins`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
									AND 	`shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

			$row_status = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`='" . mysqli_real_escape_string($conn, intval($maindata[$status_field])) . "'"), MYSQLI_ASSOC);

			$row_template = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `templates` WHERE `templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `templates`.`id`='" . mysqli_real_escape_string($conn, intval($row_status['email_template'])) . "'"), MYSQLI_ASSOC);

			$row_template['body'] .= $row_admin['email_signature'];

			$status_number = intval($_SESSION["admin"]["id"]) . "A" . date("dmYHis", time());

			$fields = array('subject', 'body', 'admin_mail_subject');

			for($j = 0;$j < count($fields);$j++){

				$row_template[$fields[$j]] = str_replace("[status_id]", $status_number, $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[status]", $row_status["name"], $row_template[$fields[$j]]);

				$row_template[$fields[$j]] = str_replace("[id]", $device_number, $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[order_id]", $row_order['order_number'], $row_template[$fields[$j]]);
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

	//				$row_template[$fields[$j]] = str_replace("[files]", $links, $row_template[$fields[$j]]);

				}

			}

			mysqli_query($conn, "	INSERT 	`" . $order_table . "_statuses` 
									SET 	`" . $order_table . "_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
											`" . $order_table . "_statuses`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "', 
											`" . $order_table . "_statuses`.`status_number`='" . mysqli_real_escape_string($conn, $status_number) . "', 
											`" . $order_table . "_statuses`.`admin_id`='" . mysqli_real_escape_string($conn, $_SESSION["admin"]["id"]) . "', 
											`" . $order_table . "_statuses`.`status_id`='" . mysqli_real_escape_string($conn, $row_status['id']) . "', 
											`" . $order_table . "_statuses`.`template`='" . mysqli_real_escape_string($conn, $row_template['name']) . "', 
											`" . $order_table . "_statuses`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
											`" . $order_table . "_statuses`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
											`" . $order_table . "_statuses`.`public`='1', 
											`" . $order_table . "_statuses`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

			$_SESSION["status"]["id"] = $conn->insert_id;

			mysqli_query($conn, "	INSERT 	`" . $order_table . "_events` 
									SET 	`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
											`" . $order_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`" . $order_table . "_events`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "', 
											`" . $order_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
											`" . $order_table . "_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag gefunden - Gerät, erstellt, ID [#" . $_SESSION["status"]["id"] . "]") . "', 
											`" . $order_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
											`" . $order_table . "_events`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
											`" . $order_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

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

		}else{

			mysqli_query($conn, "	UPDATE 	`shopin_shopins` 
									SET 	`shopin_shopins`.`type`='0', 
											`shopin_shopins`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`shopin_shopins`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['order_id'])) . "', 
											`shopin_shopins`.`order_number`='" . mysqli_real_escape_string($conn, intval($row_order['order_number'])) . "', 
											`shopin_shopins`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
									WHERE 	`shopin_shopins`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
									AND 	`shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

			mysqli_query($conn, "	UPDATE 	`order_orders_devices` 
									SET 	`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['order_id'])) . "', 
											`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
									WHERE 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($row_shopin['device_id'])) . "' 
									AND 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		}

		$row_shopin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `shopin_shopins` WHERE `shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND  `shopin_shopins`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	}

	$row_device = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($row_shopin['device_id'])) . "'"), MYSQLI_ASSOC);

	$row_storage_places = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_shopin['order_id'] == 0 ? $row_shopin['storage_space_id'] : $row_device['storage_space_id'])) . "'"), MYSQLI_ASSOC);

	$list_uploads = "";

	$docs_count = 0;

	$cards_count = 0;

	$files = scandir("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/");

	foreach($files as $k => $filename){

		if($filename != "." && $filename != ".." && $filename != ".htaccess" && $filename != "@eaDir"){

			$order_number = explode("_", $filename);

			if($row_shopin['help_device_number'] == $order_number[0]){

				$file_date = date("d.m.Y", filemtime("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/" . $filename));

				$file_time = date("H:i", filemtime("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/" . $filename));

				$file_size = intval(filesize("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/" . $filename) / 1024);

				if($cards_count == 0){
					$list_uploads .= "<div class=\"card-deck mb-3\">";
				}

				$list_uploads .=	"	<div class=\"card\">\n" . 
									"		<div class=\"card-body\">\n" . 
									"			<div class=\"row\">\n" . 
									"				<div class=\"col-sm-9\">\n" . 
									"					<h4 class=\"card-title mb-0\"><b>" . substr($filename, strpos($filename, "_") + 1) . "</b><br />Ansehen?</h4>\n" . 
									"				</div>\n" . 
									"				<div class=\"col-sm-3 text-right\">\n" . 
									"					<button type=\"button\" name=\"shopin_add\" value=\"voransicht\" class=\"btn btn-success btn-lg mt-1\" onclick=\"document.getElementById('preview').src='/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/" . $filename . "'\">\n" . 
									"						<i class=\"fa fa-search-plus\" aria-hidden=\"true\"></i>\n" . 
									"					</button>\n" . 
									"				</div>\n" . 
									"			</div>\n" . 
									"		</div>\n" . 
									"	</div>\n";

				if($cards_count == 1){
					$list_uploads .= "</div>";
				}

				$cards_count = $cards_count == 1 ? 0 : $cards_count + 1;

				$docs_count++;


			}

		}

	}

	if($cards_count == 1){
		$list_uploads .= "<div class=\"card bg-light\"></div></div>\n";
	}

	$maindoc = file_exists("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/" . $row_shopin['help_device_number'] . ".pdf") ? "true" : "false";

	$list = "";

	$searchword = strip_tags(isset($_POST['search_order']) && $_POST['search_order'] != "" ? $_POST['search_order'] : "");

	$where = 	isset($_POST['search_order']) && $_POST['search_order'] != "" ? 
				"WHERE 	(`order_orders`.`id` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
				OR		`order_orders`.`order_number` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
				OR		`order_orders`.`ref_number` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
				OR		`order_orders`.`customer_number` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
				OR		`order_orders`.`call_date` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
				OR		`order_orders`.`machine` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
				OR		`order_orders`.`model` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
				OR		`order_orders`.`constructionyear` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
				OR		`order_orders`.`carid` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
				OR		`order_orders`.`mileage` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
				OR		`order_orders`.`reason` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
				OR		`order_orders`.`description` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
				OR		`order_orders`.`files` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
				OR		`order_orders`.`companyname` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
				OR		`order_orders`.`firstname` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
				OR		`order_orders`.`lastname` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
				OR		`order_orders`.`street` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
				OR		`order_orders`.`streetno` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
				OR		`order_orders`.`zipcode` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
				OR		`order_orders`.`city` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
				OR		`order_orders`.`country` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
				OR		`order_orders`.`phonenumber` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
				OR		`order_orders`.`mobilnumber` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
				OR		`order_orders`.`email` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
				OR		`order_orders`.`differing_shipping_address` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
				OR		`order_orders`.`differing_companyname` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
				OR		`order_orders`.`differing_firstname` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
				OR		`order_orders`.`differing_lastname` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
				OR		`order_orders`.`differing_street` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
				OR		`order_orders`.`differing_streetno` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
				OR		`order_orders`.`differing_zipcode` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
				OR		`order_orders`.`differing_city` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%' 
				OR		`order_orders`.`differing_country` LIKE '%" . mysqli_real_escape_string($conn, $searchword) . "%') " : 
				"";
	
	$and = $where == "" ? "WHERE `order_orders`.`mode`" . (isset($_POST['search_mode']) && $_POST['search_mode'] == 10000 ? ">=0" : "=" . intval($_POST['search_mode'])) . " " : " AND `order_orders`.`mode`" . (isset($_POST['search_mode']) && $_POST['search_mode'] == 10000 ? ">=0" : "=" . intval($_POST['search_mode'])) . " ";

	$query = 	"	SELECT 		`order_orders`.`id` AS id, 
								`order_orders`.`creator_id` AS creator_id, 
								`order_orders`.`order_number` AS order_number, 
								`order_orders`.`status_counter` AS status_counter, 
								`order_orders`.`companyname` AS companyname, 
								`order_orders`.`firstname` AS firstname, 
								`order_orders`.`lastname` AS lastname, 
								`order_orders`.`phonenumber` AS phonenumber, 
								`order_orders`.`mobilnumber` AS mobilnumber, 
								`order_orders`.`audio` AS audio, 
								`order_orders`.`call_date` AS call_date, 
								`order_orders`.`intern_time` AS intern_time, 
								`order_orders`.`run_date` AS run_date, 
								`order_orders`.`reg_date` AS reg_date, 
								`order_orders`.`cpy_date` AS cpy_date, 
								`order_orders`.`upd_date` AS time, 

								(SELECT `address_addresses`.`shortcut` AS shortcut FROM `address_addresses` WHERE `address_addresses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `address_addresses`.`id`=`order_orders`.`intern_allocation`) AS address_shortcut, 

								(SELECT `admin`.`name` AS name FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`=`order_orders`.`admin_id`) AS admin_name, 

								(SELECT 		`order_orders_payings`.`payed` AS p_payed 
									FROM		`order_orders_payings` 
									WHERE		`order_orders_payings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									AND 		`order_orders_payings`.`order_id`=`order_orders`.`id` 
									ORDER BY	CAST(`order_orders_payings`.`time` AS UNSIGNED) DESC limit 0, 1) AS payed, 

								(SELECT 		`order_orders_payings`.`shipping` AS p_shipping 
									FROM		`order_orders_payings` 
									WHERE		`order_orders_payings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									AND 		`order_orders_payings`.`order_id`=`order_orders`.`id` 
									ORDER BY	CAST(`order_orders_payings`.`time` AS UNSIGNED) DESC limit 0, 1) AS shipping, 

								`order_orders`.`admin_id` AS admin_id 

					FROM 		`order_orders` 
					" . $where . $and . " 
					AND 		`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
					ORDER BY 	CAST(`order_orders`.`upd_date` AS UNSIGNED) ASC";

	$result = mysqli_query($conn, $query);

	while($row_orders = $result->fetch_array(MYSQLI_ASSOC)){

		$list .= 	"<form action=\"" . $order_action . "\" method=\"post\">\n" . 
					"	<tr>\n" . 
					"		<td class=\"text-nowrap\">\n" . 
					"			<small>" . date("d.m.Y", $row_orders['reg_date']) . "</small> <small class=\"text-muted\">" . date("(H:i)", $row_orders['reg_date']) . "</small>\n" . 
					"		</td>\n" . 
					"		<td scope=\"row\" align=\"center\">\n" . 
					"			<small>" . $row_orders['order_number'] . "</small>\n" . 
					"		</td>\n" . 
					"		<td>\n" . 
					"			<div style=\"width: 160px;white-space: nowrap;overflow-x: hidden\"><small>" . ($row_orders['companyname'] != "" ? $row_orders['companyname'] . ", " : "") . $row_orders['firstname'] . " " . $row_orders['lastname'] . "</small></div>\n" . 
					"		</td>\n" . 
					"		<td class=\"text-nowrap\">\n" . 
					"			<small>" . date("d.m.Y", $row_orders['time']) . "</small> <small class=\"text-muted\">" . date("(H:i)", $row_orders['time']) . "</small>\n" . 
					"		</td>\n" . 
					"		<td align=\"center\">\n" . 
					"			<div style=\"white-space: nowrap\">\n" . 
					"				<input type=\"hidden\" name=\"id\" value=\"" . $row_shopin['id'] . "\" />\n" . 
					"				<input type=\"hidden\" name=\"order_id\" value=\"" . $row_orders['id'] . "\" />\n" . 
					"				<input type=\"hidden\" name=\"shopin_edit\" value=\"bearbeiten\" />\n" . 
					"				<button type=\"submit\" name=\"shopin_order\" value=\"zuweisen\" class=\"btn btn-sm btn-success\">zuweisen <i class=\"fa fa-arrows-h\" aria-hidden=\"true\"></i></button>\n" . 
					"			</div>\n" . 
					"		</td>\n" . 
					"	</tr>\n" . 
					"</form>\n";

	}

	$options_countries = "";
	$options_differing_countries = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`countries` 
									WHERE 		`countries`.`frontend`='1' 
									ORDER BY 	`countries`.`name` ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$countryToId .= $countryToId != "" ? ", '" . $row['name'] . "': " . $row['id'] : "'" . $row['name'] . "': " . $row['id'];
		$options_countries .= "								<option value=\"" . $row['id'] . "\" data-code=\"" . $row['code'] . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['country']) && $_POST['country'] == $row['id'] ? " selected=\"selected\"" : "") : ($row['id'] == 1 ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";
		$options_differing_countries .= "								<option value=\"" . $row['id'] . "\" data-code=\"" . $row['code'] . "\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? (isset($_POST['differing_country']) && $_POST['differing_country'] == $row['id'] ? " selected=\"selected\"" : "") : ($row['id'] == 1 ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";
	}

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<div class=\"row\">\n" . 
				"					<div class=\"col-sm-6\">\n" . 
				"						<h3 class=\"mt-1 mb-0\">Wareneingang bearbeiten " . $row_shopin['shopin_number'] . "</h3>\n" . 
				"					</div>\n" . 
				"					<div class=\"col-sm-6 text-right\">\n" . 
				"						<form action=\"" . $packing_action . "\" method=\"post\">\n" . 
				"							<input type=\"hidden\" name=\"id\" value=\"" . intval($row_shopin['id']) . "\" />\n" . 
				"							<div class=\"btn-group\">\n" . 
				"								<button type=\"submit\" name=\"shopin_delete\" value=\"entfernen\" class=\"btn btn-danger\" onclick=\"return confirm('Wollen Sie dieses Gerät wirklich entfernen?')\">entfernen <i class=\"fa fa-ban\" aria-hidden=\"true\"></i></button>&nbsp;\n" . 
				"								<button type=\"submit\" name=\"packing_close\" value=\"schliessen\" class=\"btn btn-secondary\">schliessen <i class=\"fa fa-times\" aria-hidden=\"true\"></i></button>\n" . 
				"							</div>\n" . 
				"						</form>\n" . 
				"					</div>\n" . 
				"				</div>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

//				"				<form action=\"" . $packing_action . "\" method=\"post\">\n" . 

				"					<div class=\"row\">\n" . 
				"						<div class=\"col-6 border-right\">\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\">Aktuelle Gerätenummer</label>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<input type=\"text\" name=\"he_de_nu\" value=\"" . $row_shopin['help_device_number'] . "\" class=\"form-control\" aria-label=\"\" aria-describedby=\"inputGroup-device-number\" disabled=\"disabled\" />\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\">Aktueller Lagerplatz</label>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<input type=\"text\" name=\"st_sp\" value=\"" . $row_storage_places['name'] . "\" class=\"form-control\" aria-label=\"\" aria-describedby=\"inputGroup-device-number\" disabled=\"disabled\" />\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<hr />\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\">Bauteilspezifikation" . ($row_shopin['order_id'] == 0 ? "<br /><small class=\"text-warning\">(Nur möglich wenn ein Auftrag zugewiesen wurde!)</small>" : "") . "</label>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<form action=\"" . $packing_action . "\" method=\"post\">\n" . 
				"										<input type=\"hidden\" name=\"id\" value=\"" . intval($row_shopin['id']) . "\" />\n" . 
				"										<div class=\"btn-group\">\n" . 
				"											<button type=\"submit\" name=\"shopin_at\" value=\"speichern\" class=\"btn btn-light\"" . ($row_shopin['order_id'] > 0 ? "" : " disabled=\"disabled\"") . ">Austauschteil <i class=\"fa fa-tachometer\" aria-hidden=\"true\"></i></button>\n" . 
				"											<button type=\"submit\" name=\"shopin_org\" value=\"speichern\" class=\"btn btn-warning\"" . ($row_shopin['order_id'] > 0 ? "" : " disabled=\"disabled\"") . ">Originalteil <i class=\"fa fa-certificate\" aria-hidden=\"true\"></i></button>\n" . 
				"										</div>\n" . 
				"									</form>\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				($row_shopin['order_id'] == 0 ? 
					"							<div class=\"form-group row\">\n" . 
					"								<label class=\"col-sm-4 col-form-label\">Auftrag zuweisen</label>\n" . 
					"								<div class=\"col-sm-8\">\n" . 
					"									<div class=\"form-group row\">\n" . 
					"										<div class=\"col-sm-8\">\n" . 
					"											<form action=\"" . $packing_action . "\" method=\"post\">\n" . 
					"												<div class=\"btn-group\">\n" . 
					"													<input type=\"text\" name=\"search_order\" value=\"" . strip_tags(isset($_POST['search_order']) ? $_POST['search_order'] : "") . "\" placeholder=\"|||||| Suchbegriff\" aria-label=\"Suchbegriff / Barcode\" class=\"form-control bg-white text-primary border border-primary\" style=\"border-radius: .25rem 0 0 .25rem\" />\n" . 
					"													<select name=\"search_mode\" class=\"custom-select bg-light text-primary border border-primary\" style=\"border-radius: 0\">\n" . 
					"														<option value=\"10000\"" . (isset($_POST['search_mode']) && $_POST['search_mode'] == 10000 ? " selected=\"selected\"" : "")  . ">Alle</option>\n" . 
					"														<option value=\"0\"" . (isset($_POST['search_mode']) && $_POST['search_mode'] == 0 ? " selected=\"selected\"" : "")  . ">Auftrag-Aktiv</option>\n" . 
					"														<option value=\"1\"" . (isset($_POST['search_mode']) && $_POST['search_mode'] == 1 ? " selected=\"selected\"" : "")  . ">Auftrag-Archiv</option>\n" . 
					"														<option value=\"2\"" . (isset($_POST['search_mode']) && $_POST['search_mode'] == 2 ? " selected=\"selected\"" : "")  . ">Interessent-Aktiv</option>\n" . 
					"														<option value=\"3\"" . (isset($_POST['search_mode']) && $_POST['search_mode'] == 3 ? " selected=\"selected\"" : "")  . ">Interessent-Archiv</option>\n" . 
					"													</select>\n" . 
					"													<button type=\"submit\" name=\"shopin_edit\" value=\"bearbeiten\" class=\"btn btn-primary\"><i class=\"fa fa-search\" aria-hidden=\"true\"></i></button>\n" . 
					"												</div>\n" . 
					"												<input type=\"hidden\" name=\"id\" value=\"" . intval($row_shopin['id']) . "\" />\n" . 
					"											</form>\n" . 
					"										</div>\n" . 
					"										<div class=\"col-sm-4 text-right\">\n" . 
					"											<form action=\"" . $packing_action . "\" method=\"post\">\n" . 
					"												<div class=\"btn-group\">\n" . 
					"													<select id=\"mode\" name=\"mode\" class=\"custom-select bg-light text-primary border border-primary\" style=\"border-radius: .25rem 0 0 .25rem\" onchange=\"document.getElementById('order_mode').value=this.value\">\n" . 
					"														<option value=\"0\">Auftrag-Aktiv</option>\n" . 
					"														<option value=\"1\">Auftrag-Archiv</option>\n" . 
					"														<option value=\"2\">Interessent-Aktiv</option>\n" . 
					"														<option value=\"3\">Interessent-Archiv</option>\n" . 
					"													</select>\n" . 
					"													<button type=\"button\" name=\"order_add\" value=\"hinzufuegen\" class=\"btn btn-primary\" onclick=\"\$('#new_order').slideToggle(400)\"><i class=\"fa fa-plus\" aria-hidden=\"true\"></i></button>\n" . 
					"												</div>\n" . 
					"												<input type=\"hidden\" name=\"id\" value=\"" . intval($row_shopin['id']) . "\" />\n" . 
					"											</form>\n" . 
					"										</div>\n" . 
					"									</div>\n" . 
					"									<div class=\"form-group row\">\n" . 
					"										<div class=\"col-sm-12\">\n" . 
					"<div class=\"table-responsive\" style=\"max-height: 400px\">\n" . 
					"	<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
					"		<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
					"			<th width=\"120\" scope=\"col\">\n" . 
					"				<strong>Erstellt</strong>\n" . 
					"			</th>\n" . 
					"			<th width=\"60\" scope=\"col\">\n" . 
					"				<strong>Auftrag</strong>\n" . 
					"			</th>\n" . 
					"			<th scope=\"col\">\n" . 
					"				<strong>Kunde</strong>\n" . 
					"			</th>\n" . 
					"			<th width=\"120\" scope=\"col\">\n" . 
					"				<strong>Geändert</strong>\n" . 
					"			</th>\n" . 
					"			<th width=\"110\" align=\"center\" scope=\"col\" class=\"text-center\">\n" . 
					"				<strong>Aktion</strong>\n" . 
					"			</th>\n" . 
					"		</tr></thead>\n" . 
	
					$list . 
	
					"	</table>\n" . 
					"</div>\n" . 
					"										</div>\n" . 
					"									</div>\n" . 
					"								</div>\n" . 
					"							</div>\n"
				:
					"							<div class=\"form-group row\">\n" . 
					"								<label class=\"col-sm-4 col-form-label\">Auftrag zugewiesen</label>\n" . 
					"								<div class=\"col-sm-8\">\n" . 
					"									Ja\n" . 
					"								</div>\n" . 
					"							</div>\n"
				) . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\">Neue Gerätenummer</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<span>" . (isset($row_device['device_number']) && intval($row_device['id']) > 0 ? $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) : "noch keine") . "</span>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<form action=\"" . $packing_action . "\" method=\"post\">\n" . 

				"								<div class=\"form-group row\">\n" . 
				"									<label for=\"description\" class=\"col-sm-4 col-form-label\">Wichtige Information<br />(an den Packtisch)</label>\n" . 
				"									<div class=\"col-sm-4\">\n" . 
				"										<textarea id=\"message\" name=\"message\" class=\"form-control\">" . $row_shopin['description'] . "</textarea>\n" . 
				"									</div>\n" . 
				"									<div class=\"col-sm-4\">\n" . 
				"									</div>\n" . 
				"								</div>\n" . 

				"								<div class=\"form-group row\">\n" . 
				"									<label class=\"col-sm-4 col-form-label\">&nbsp;</label>\n" . 
				"									<div class=\"col-sm-8\">\n" . 
				"										<input type=\"hidden\" name=\"id\" value=\"" . intval($row_shopin['id']) . "\" />\n" . 
				"										<button type=\"submit\" name=\"shopin_to_intern\" value=\"speichern\" class=\"btn btn-success\"" . ($row_shopin['order_id'] > 0 && isset($row_device['atot_mode']) && $row_device['atot_mode'] > 0 ? "" : " disabled=\"disabled\"") . ">An Intern senden <i class=\"fa fa-gift\" aria-hidden=\"true\"></i></button>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 

				"							</form>\n" . 

				"						</div>\n" . 
				"						<div class=\"col-6\">\n" . 

				"							<div class=\"row mb-3\">\n" . 
				"								<div class=\"col-sm-10\">\n" . 
				"									<h3 class=\"font-weight-bold mt-1\">" . (file_exists("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/" . $row_shopin['help_device_number'] . ".pdf") == true ? "Das Haupt- und " . $docs_count . " Dokumente wurden gefunden!" : $docs_count . " Dokumente wurden gefunden!") . "</h3>\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-2 text-right mb-1\">\n" . 
				"									<form action=\"" . $packing_action . "\" method=\"post\" enctype=\"multipart/form-data\">\n" . 
				"										<input type=\"hidden\" name=\"id\" value=\"" . intval($row_shopin['id']) . "\" />\n" . 
				"										<input type=\"hidden\" name=\"order_id\" value=\"" . intval($row_shopin['order_id']) . "\" />\n" . 
				"										<button type=\"submit\" name=\"shopin_edit\" value=\"bearbeiten\" class=\"btn btn-secondary btn-lg\"><i class=\"fa fa-refresh\"></i></button>\n" . 
				"									</form>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 
				(file_exists("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/" . $row_shopin['help_device_number'] . ".pdf") == true ? 
					"							<div class=\"row mb-3\">\n" . 
					"								<div class=\"col-sm-12\">\n" . 
	
					"									<div class=\"card\">\n" . 
					"										<div class=\"card-body\">\n" . 
					"											<div class=\"row\">\n" . 
					"												<div class=\"col-sm-9\">\n" . 
					"													<h4 class=\"card-title mb-0\"><b>Haupt Dokument</b><br />Ansehen?</h4>\n" . 
					"												</div>\n" . 
					"												<div class=\"col-sm-3 text-right\">\n" . 
					"													<button type=\"button\" name=\"shopin_add\" value=\"voransicht\" class=\"btn btn-success btn-lg mt-1\" onclick=\"document.getElementById('preview').src='/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/" . $row_shopin['help_device_number'] . ".pdf'\">\n" . 
					"														<i class=\"fa fa-search-plus\" aria-hidden=\"true\"></i>\n" . 
					"													</button>\n" . 
					"												</div>\n" . 
					"											</div>\n" . 
					"										</div>\n" . 
					"									</div>\n" . 
	
					"								</div>\n" . 
					"							</div>\n"
				: 
					""
				) . 

				($docs_count > 0 ? 
					"							<div class=\"row\">\n" . 
					"								<div class=\"col-sm-12\">\n" . 

					$list_uploads . 

					"								</div>\n" . 
					"							</div>\n"
				: 
					""
				) . 

				/*"							<div id=\"show_print_button\" class=\"row my-3" . ($docs_count == 0 && !file_exists("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/" . $row_shopin['help_device_number'] . ".pdf") ? " d-none" : "") . "\">\n" . 
				"								<div class=\"col-sm-6\">\n" . 
				"									<h3 class=\"mt-3\">Ohne Dokumente fortfahren</h3>\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-6\">\n" . 
				"									<div class=\"custom-control custom-checkbox mt-1\">\n" . 
				"										<input type=\"checkbox\" id=\"with_documents\" name=\"with_documents\" value=\"1\" class=\"custom-control-input bootstrap-switch-access-yes-no\" onchange=\"
				if(document.getElementById('with_documents').checked){
					$('#question_photo').addClass('d-none');
				}else{
					$('#question_photo').removeClass('d-none');
				}
				showStoreButton();
				\" />\n" . 
				"									<label class=\"custom-control-label\" for=\"prints_ready\" onclick=\"
				if(document.getElementById('with_documents').checked){
					$('#question_photo').addClass('d-none');
				}else{
					$('#question_photo').removeClass('d-none');
				}
				showStoreButton();
				\">\n" . 
				"											Ja\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . */

				"							<div class=\"row my-3\">\n" . 
				"								<div class=\"col-sm-12\">\n" . 
				"									<iframe id=\"preview\" src=\"" . (file_exists("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/" . $row_shopin['help_device_number'] . ".pdf") ? "/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/" . $row_shopin['help_device_number'] . ".pdf" : "/crm/blank") . "\" width=\"100%\" height=\"800\" class=\"border\"></iframe>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div id=\"new_order\" style=\"" . (isset($_POST["shopin_order_add"]) && $_POST["shopin_order_add"] == "hinzufuegen" ? "" : "display: none") . "\">\n" . 

				"								<form action=\"" . $packing_action . "\" method=\"post\" enctype=\"multipart/form-data\" onsubmit=\"var sumsize=0;for(var i=0;i<document.getElementById('file_document_add').files.length;i++){sumsize+=document.getElementById('file_document_add').files[i].size;}if(sumsize>(32*1024*1024)){alert('Die upload Datengröße ist zu hoch. Es sind nur 32MB insgesammt erlaubt!');return false;}else{return true;}\">\n" . 

				"									<div class=\"form-group row\">\n" . 
				"										<div class=\"col-sm-12\">\n" . 
				"											<h3>Neuer Auftrag</h3>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 

				"									<div class=\"form-group row\">\n" . 
				"										<div class=\"col-sm-12\">\n" . 
				"											<strong>Rechnungsanschrift</strong>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 

				"									<div class=\"form-group row\">\n" . 
				"										<div class=\"col-sm-12\">\n" . 
				"											<input type=\"text\" id=\"companyname\" name=\"companyname\" value=\"" . $companyname . "\" class=\"form-control" . $inp_companyname . "\" placeholder=\"Firma\" />\n" . 
				"										</div>\n" . 
				"									</div>\n" . 

				"									<div class=\"form-group row\">\n" . 
				"										<div class=\"col-sm-4 mt-2\">\n" . 
				"											<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"												<input type=\"radio\" id=\"gender_0\" name=\"gender\" value=\"0\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['gender']) : 0) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"												<label class=\"custom-control-label\" for=\"gender_0\">\n" . 
				"													Herr\n" . 
				"												</label>\n" . 
				"											</div>\n" . 
				"											<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"												<input type=\"radio\" id=\"gender_1\" name=\"gender\" value=\"1\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval($_POST['gender']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"												<label class=\"custom-control-label\" for=\"gender_1\">\n" . 
				"													Frau\n" . 
				"												</label>\n" . 
				"											</div>\n" . 
				"										</div>\n" . 
				"										<div class=\"col-sm-4\">\n" . 
				"											<input type=\"text\" id=\"firstname\" name=\"firstname\" value=\"" . $firstname . "\" class=\"form-control" . $inp_firstname . "\" placeholder=\"Vorname\" />\n" . 
				"										</div>\n" . 
				"										<div class=\"col-sm-4\">\n" . 
				"											<input type=\"text\" id=\"lastname\" name=\"lastname\" value=\"" . $lastname . "\" class=\"form-control" . $inp_lastname . "\" placeholder=\"Nachname\" />\n" . 
				"										</div>\n" . 
				"									</div>\n" . 

				"									<div class=\"form-group row\">\n" . 
				"										<div class=\"col-sm-9\">\n" . 
				"											<input type=\"text\" id=\"route\" name=\"street\" value=\"" . $street . "\" class=\"form-control" . $inp_street . "\" placeholder=\"Straße\" onFocus=\"geolocate('route')\" />\n" . 
				"										</div>\n" . 
				"										<div class=\"col-sm-3\">\n" . 
				"											<input type=\"text\" id=\"street_number\" name=\"streetno\" value=\"" . $streetno . "\" class=\"form-control" . $inp_streetno . "\" placeholder=\"Nr\" />\n" . 
				"										</div>\n" . 
				"									</div>\n" . 

				"									<div class=\"form-group row\">\n" . 
				"										<div class=\"col-sm-4\">\n" . 
				"											<input type=\"text\" id=\"postal_code\" name=\"zipcode\" value=\"" . $zipcode . "\" class=\"form-control" . $inp_zipcode . "\" placeholder=\"Postleitzahl\" onFocus=\"geolocate('postal_code')\" />\n" . 
				"										</div>\n" . 
				"										<div class=\"col-sm-4\">\n" . 
				"											<input type=\"text\" id=\"locality\" name=\"city\" value=\"" . $city . "\" class=\"form-control" . $inp_city . "\" placeholder=\"Ort\" onFocus=\"geolocate('locality')\" />\n" . 
				"										</div>\n" . 
				"										<div class=\"col-sm-4\">\n" . 
				"											<select id=\"country\" name=\"country\" class=\"custom-select" . $inp_country . "\">\n" . 

				$options_countries . 

				"											</select>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 

				"									<div class=\"form-group row\">\n" . 
				"										<div class=\"col-sm-4\">\n" . 
				"											<input type=\"email\" id=\"email\" name=\"email\" value=\"" . $email . "\" class=\"form-control" . $inp_email . "\" placeholder=\"Email\" />\n" . 
				"										</div>\n" . 
				"										<div class=\"col-sm-4\">\n" . 
				"											<input type=\"text\" id=\"mobilnumber\" name=\"mobilnumber\" value=\"" . $mobilnumber . "\" class=\"form-control" . $inp_mobilnumber . "\" placeholder=\"Mobil\" />\n" . 
				"										</div>\n" . 
				"										<div class=\"col-sm-4\">\n" . 
				"											<input type=\"text\" id=\"phonenumber\" name=\"phonenumber\" value=\"" . $phonenumber . "\" class=\"form-control" . $inp_phonenumber . "\" placeholder=\"Festnetz\" />\n" . 
				"										</div>\n" . 
				"									</div>\n" . 

				"									<div class=\"form-group row\">\n" . 
				"										<label class=\"col-sm-4 col-form-label\">Andere Lieferadresse</label>\n" . 
				"										<div class=\"col-sm-8\">\n" . 
				"											<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"												<input type=\"checkbox\" id=\"differing_shipping_address\" name=\"differing_shipping_address\" value=\"1\"" . ($differing_shipping_address == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" onclick=\"\$('#differing_shipping_address_hide').toggleClass('d-none').toggleClass('d-block');\" />\n" . 
				"												<label class=\"custom-control-label\" for=\"differing_shipping_address\">\n" . 
				"													Ja\n" . 
				"												</label>\n" . 
				"											</div>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 

				"									<div id=\"differing_shipping_address_hide\" class=\"" . ($differing_shipping_address == 1 ? "d-block" : "d-none") . "\">\n" . 

				"										<div class=\"form-group row\">\n" . 
				"											<div class=\"col-sm-12\">\n" . 
				"												<input type=\"text\" id=\"differing_companyname\" name=\"differing_companyname\" value=\"" . $differing_companyname . "\" class=\"form-control" . $inp_differing_companyname . "\" placeholder=\"Firma\" />\n" . 
				"											</div>\n" . 
				"										</div>\n" . 

				"										<div class=\"form-group row\">\n" . 
				"											<div class=\"col-sm-4 mt-2\">\n" . 
				"												<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"													<input type=\"radio\" id=\"differing_gender_0\" name=\"differing_gender\" value=\"0\"" . ((isset($_POST['edit']) && $_POST['edit'] == "speichern" ? intval($_POST['differing_gender']) : 0) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"													<label class=\"custom-control-label\" for=\"differing_gender_0\">\n" . 
				"														Herr\n" . 
				"													</label>\n" . 
				"												</div>\n" . 
				"												<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"													<input type=\"radio\" id=\"differing_gender_1\" name=\"differing_gender\" value=\"1\"" . ((isset($_POST['edit']) && $_POST['edit'] == "speichern" ? intval($_POST['differing_gender']) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"													<label class=\"custom-control-label\" for=\"differing_gender_1\">\n" . 
				"														Frau\n" . 
				"													</label>\n" . 
				"												</div>\n" . 
				"											</div>\n" . 
				"											<div class=\"col-sm-4\">\n" . 
				"												<input type=\"text\" id=\"differing_firstname\" name=\"differing_firstname\" value=\"" . $differing_firstname . "\" class=\"form-control" . $inp_differing_firstname . "\" placeholder=\"Vorname\" />\n" . 
				"											</div>\n" . 
				"											<div class=\"col-sm-4\">\n" . 
				"												<input type=\"text\" id=\"differing_lastname\" name=\"differing_lastname\" value=\"" . $differing_lastname . "\" class=\"form-control" . $inp_differing_lastname . "\" placeholder=\"Nachname\" />\n" . 
				"											</div>\n" . 
				"										</div>\n" . 

				"										<div class=\"form-group row\">\n" . 
				"											<div class=\"col-sm-9\">\n" . 
				"												<input type=\"text\" id=\"differing_route\" name=\"differing_street\" value=\"" . $differing_street . "\" class=\"form-control" . $inp_differing_street . "\" placeholder=\"Straße\" onFocus=\"geolocate('differing_route')\" />\n" . 
				"											</div>\n" . 
				"											<div class=\"col-sm-3\">\n" . 
				"												<input type=\"text\" id=\"differing_street_number\" name=\"differing_streetno\" value=\"" . $differing_streetno . "\" class=\"form-control" . $inp_differing_streetno . "\" placeholder=\"Nr\" />\n" . 
				"											</div>\n" . 
				"										</div>\n" . 

				"										<div class=\"form-group row\">\n" . 
				"											<div class=\"col-sm-4\">\n" . 
				"												<input type=\"text\" id=\"differing_postal_code\" name=\"differing_zipcode\" value=\"" . $differing_zipcode . "\" class=\"form-control" . $inp_differing_zipcode . "\" placeholder=\"Postleitzahl\" onFocus=\"geolocate('differing_postal_code')\" />\n" . 
				"											</div>\n" . 
				"											<div class=\"col-sm-4\">\n" . 
				"												<input type=\"text\" id=\"differing_locality\" name=\"differing_city\" value=\"" . $differing_city . "\" class=\"form-control" . $inp_differing_city . "\" placeholder=\"Ort\" onFocus=\"geolocate('differing_locality')\" />\n" . 
				"											</div>\n" . 
				"											<div class=\"col-sm-4\">\n" . 
				"												<select id=\"differing_country\" name=\"differing_country\" class=\"custom-select" . $inp_differing_country . "\">\n" . 

				$options_differing_countries . 

				"												</select>\n" . 
				"											</div>\n" . 
				"										</div>\n" . 

				"									</div>\n" . 

				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"pricemwst\" class=\"col-sm-4 col-form-label\">Reparaturfreigabe bis</label>\n" . 
				"										<div class=\"col-sm-5\">\n" . 
				"											<div class=\"input-group\">\n" . 
				"												<input type=\"text\" id=\"pricemwst\" name=\"pricemwst\" value=\"" . number_format($pricemwst, 2, ',', '') . "\" class=\"form-control" . $inp_pricemwst . "\" />\n" . 
				"												<div class=\"input-group-append\">\n" . 
				"													<span class=\"input-group-text\">&euro;</span>\n" . 
				"												</div>\n" . 
				"											</div>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 

				"									<div class=\"form-group row\">\n" . 
				"										<label class=\"col-sm-4 col-form-label\">Versand</label>\n" . 
				"										<div class=\"col-sm-8 mt-2\">\n" . 

				(
					$_SESSION["admin"]["roles"]["shipping_edit"] == 1 ? 
					"											<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
					"												<input type=\"radio\" id=\"radio_shipping_standart\" name=\"radio_shipping\" value=\"1\"" . ($radio_shipping == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
					"												<label class=\"custom-control-label\" for=\"radio_shipping_standart\">\n" . 
					"													Standard\n" . 
					"												</label>\n" . 
					"											</div>\n" . 
					"											<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
					"												<input type=\"radio\" id=\"radio_shipping_express\" name=\"radio_shipping\" value=\"0\"" . ($radio_shipping == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
					"												<label class=\"custom-control-label\" for=\"radio_shipping_express\">\n" . 
					"													Express\n" . 
					"												</label>\n" . 
					"											</div>\n" . 
					"											<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
					"												<input type=\"radio\" id=\"radio_shipping_international\" name=\"radio_shipping\" value=\"2\"" . ($radio_shipping == 2 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
					"												<label class=\"custom-control-label\" for=\"radio_shipping_international\">\n" . 
					"													International\n" . 
					"												</label>\n" . 
					"											</div>\n" . 
					"											<div class=\"custom-control custom-radio d-inline\">\n" . 
					"												<input type=\"radio\" id=\"radio_shipping_self\" name=\"radio_shipping\" value=\"3\"" . ($radio_shipping == 3 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
					"												<label class=\"custom-control-label\" for=\"radio_shipping_self\">\n" . 
					"													Abholung\n" . 
					"												</label>\n" . 
					"											</div>\n" : 
					($radio_shipping == 0 ? "											Expressversand<input type=\"hidden\" name=\"radio_shipping\" value=\"0\" />\n" : "") . 
					($radio_shipping == 1 ? "											Standardversand<input type=\"hidden\" name=\"radio_shipping\" value=\"1\" />\n" : "") . 
					($radio_shipping == 2 ? "											International<input type=\"hidden\" name=\"radio_shipping\" value=\"2\" />\n" : "") . 
					($radio_shipping == 3 ? "											Abholung<input type=\"hidden\" name=\"radio_shipping\" value=\"3\" />\n" : "")
				) . 

				"										</div>\n" . 
				"									</div>\n" . 

				"									<div class=\"form-group row\">\n" . 
				"										<label class=\"col-sm-4 col-form-label\">Zahlart</label>\n" . 
				"										<div class=\"col-sm-8 mt-2\">\n" . 

				(
					$_SESSION["admin"]["roles"]["payment_edit"] == 1 ? 
					"											<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
					"												<input type=\"radio\" id=\"radio_payment_nachnahme\" name=\"radio_payment\" value=\"1\"" . ($radio_payment == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
					"												<label class=\"custom-control-label\" for=\"radio_payment_nachnahme\">\n" . 
					"													Nachnahme\n" . 
					"												</label>\n" . 
					"											</div>\n" . 
					"											<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
					"												<input type=\"radio\" id=\"radio_payment_ueberweisung\" name=\"radio_payment\" value=\"0\"" . ($radio_payment == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
					"												<label class=\"custom-control-label\" for=\"radio_payment_ueberweisung\">\n" . 
					"													Überweisung\n" . 
					"												</label>\n" . 
					"											</div>\n" . 
					"											<div class=\"custom-control custom-radio d-inline\">\n" . 
					"												<input type=\"radio\" id=\"radio_payment_bar\" name=\"radio_payment\" value=\"2\"" . ($radio_payment == 3 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
					"												<label class=\"custom-control-label\" for=\"radio_payment_bar\">\n" . 
					"													Bar\n" . 
					"												</label>\n" . 
					"											</div>\n" : 
					($radio_payment == 0 ? "											Überweisung (Sie überweisen den Rechnungsbetrag per Überweisung)<input type=\"hidden\" name=\"radio_payment\" value=\"0\" />\n" : "") . 
					($radio_payment == 1 ? "											Nachnahme<input type=\"hidden\" name=\"radio_payment\" value=\"1\" />\n" : "") . 
					($radio_payment == 2 ? "											Nachnahme<input type=\"hidden\" name=\"radio_payment\" value=\"2\" />\n" : "")
				) . 

				"										</div>\n" . 
				"									</div>\n" . 

				"									<div class=\"form-group row\">\n" . 
				"										<div class=\"col-sm-12\">\n" . 
				"											<strong>Fahrzeugdaten</strong>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 

				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"machine\" class=\"col-sm-4 col-form-label\">Automarke</label>\n" . 
				"										<div class=\"col-sm-5\">\n" . 
				"											<input type=\"text\" id=\"machine\" name=\"machine\" value=\"" . $machine . "\" class=\"form-control" . $inp_machine . "\" />\n" . 
				"										</div>\n" . 
				"									</div>\n" . 

				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"model\" class=\"col-sm-4 col-form-label\">Automodell</label>\n" . 
				"										<div class=\"col-sm-5\">\n" . 
				"											<input type=\"text\" id=\"model\" name=\"model\" value=\"" . $model . "\" class=\"form-control" . $inp_model . "\" />\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"constructionyear\" class=\"col-sm-4 col-form-label\">Baujahr</label>\n" . 
				"										<div class=\"col-sm-5\">\n" . 
				"											<input type=\"text\" id=\"constructionyear\" name=\"constructionyear\" value=\"" . $constructionyear . "\" class=\"form-control" . $inp_constructionyear . "\" />\n" . 
				"										</div>\n" . 
				"									</div>\n" . 

				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"carid\" class=\"col-sm-4 col-form-label\">FIN / VIN</label>\n" . 
				"										<div class=\"col-sm-5\">\n" . 
				"											<input type=\"text\" id=\"carid\" name=\"carid\" value=\"" . strtoupper($carid) . "\" class=\"form-control" . $inp_carid . "\" />\n" . 
				"										</div>\n" . 
				"									</div>\n" . 

				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"kw\" class=\"col-sm-4 col-form-label\">Fahrleistung (PS)</label>\n" . 
				"										<div class=\"col-sm-5\">\n" . 
				"											<input type=\"text\" id=\"kw\" name=\"kw\" value=\"" . $kw . "\" class=\"form-control" . $inp_kw . "\" />\n" . 
				"										</div>\n" . 
				"									</div>\n" . 

				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"mileage\" class=\"col-sm-4 col-form-label\">Kilometerstand</label>\n" . 
				"										<div class=\"col-sm-5\">\n" . 
				"											<div class=\"input-group date\">\n" . 
				"												<input type=\"text\" id=\"mileage\" name=\"mileage\" value=\"" . number_format(intval($mileage), 0, '', '.') . "\" class=\"form-control" . $inp_mileage . "\" />\n" . 
				"											    <span class=\"input-group-append\">\n" . 
				"													<span class=\"input-group-text\">KM</span>\n" . 
				"												</span>\n" . 
				"											</div>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 

				"									<div class=\"form-group row\">\n" . 
				"										<label class=\"col-sm-4 col-form-label\">Getriebe</label>\n" . 
				"										<div class=\"col-sm-5 mt-2\">\n" . 
				"											<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"												<input type=\"radio\" id=\"mechanism_0\" name=\"mechanism\" value=\"0\"" . ($mechanism == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"												<label class=\"custom-control-label\" for=\"mechanism_0\">\n" . 
				"													Schaltung\n" . 
				"												</label>\n" . 
				"											</div>\n" . 
				"											<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"												<input type=\"radio\" id=\"mechanism_1\" name=\"mechanism\" value=\"1\"" . ($mechanism == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"												<label class=\"custom-control-label\" for=\"mechanism_1\">\n" . 
				"													Automatik\n" . 
				"												</label>\n" . 
				"											</div>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 

				"									<div class=\"form-group row\">\n" . 
				"										<label class=\"col-sm-4 col-form-label\">Kraftstoffart</label>\n" . 
				"										<div class=\"col-sm-5 mt-2\">\n" . 
				"											<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"												<input type=\"radio\" id=\"fuel_0\" name=\"fuel\" value=\"0\"" . ($fuel == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"												<label class=\"custom-control-label\" for=\"fuel_0\">\n" . 
				"													Benzin\n" . 
				"												</label>\n" . 
				"											</div>\n" . 
				"											<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"												<input type=\"radio\" id=\"fuel_1\" name=\"fuel\" value=\"1\"" . ($fuel == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"												<label class=\"custom-control-label\" for=\"fuel_1\">\n" . 
				"													Diesel\n" . 
				"												</label>\n" . 
				"											</div>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 

				"									<div class=\"form-group row\">\n" . 
				"										<div class=\"col-sm-12\">\n" . 
				"											<strong>Fehlerbeschreibung</strong>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 

				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"reason\" class=\"col-sm-4 col-form-label\">Fehlerursache</label>\n" . 
				"										<div class=\"col-sm-8 text-right\">\n" . 
				"											<textarea id=\"reason\" name=\"reason\" style=\"height: 160px\" class=\"form-control" . $inp_reason . "\" onkeyup=\"if(this.value.length >= 700){this.value = this.value.substr(0, 700);alert('Die maximale Anzahl an erlaubten Zeichen wurde erreicht!');}$('#reason_length').html(this.value.length);\">" . $reason . "</textarea>\n" . 
				"											<small>(<span id=\"reason_length\">" . strlen($reason) . "</span> von 700 Zeichen)</small>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 
				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"description\" class=\"col-sm-4 col-form-label\">Fehlerspeicher</label>\n" . 
				"										<div class=\"col-sm-8 text-right\">\n" . 
				"											<textarea id=\"description\" name=\"description\" style=\"height: 160px\" class=\"form-control" . $inp_description . "\" onkeyup=\"if(this.value.length >= 700){this.value = this.value.substr(0, 700);alert('Die maximale Anzahl an erlaubten Zeichen wurde erreicht!');}$('#description_length').html(this.value.length);\">" . $description . "</textarea>\n" . 
				"											<small>(<span id=\"description_length\">" . strlen($description) . "</span> von 700 Zeichen)</small>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 

				"									<div class=\"form-group row\">\n" . 
				"										<label for=\"file_document_add\" class=\"col-sm-12 col-form-label\">Datenupload</label>\n" . 
				"										<div class=\"col-sm-12 px-3 pt-0 pb-3\">\n" . 
				"											<input type=\"file\" id=\"file_document_add\" name=\"file[]\" multiple=\"multiple\" accept=\"" . str_replace(", ", ",", $maindata['input_file_accept']) . "\" class=\"form-control\" onchange=\"var sumsize=0;for(var i=0;i<this.files.length;i++){sumsize+=this.files[i].size;}if(sumsize>(" . (int)ini_get("upload_max_filesize") . "*1024*1024)){alert('Die upload Datengröße ist zu hoch. Es sind nur " . (int)ini_get("upload_max_filesize") . "MB insgesammt erlaubt!');}\" />\n" . 
				"										</div>\n" . 
				"									</div>\n" . 

				"									<div class=\"form-group row\">\n" . 
				"										<div class=\"col-sm-12\">\n" . 
				"											<input type=\"hidden\" name=\"id\" value=\"" . intval($row_shopin['id']) . "\" />\n" . 
				"											<input type=\"hidden\" id=\"order_mode\" name=\"order_mode\" value=\"0\" />\n" . 
				"											<input type=\"hidden\" name=\"shopin_edit\" value=\"bearbeiten\" />\n" . 
				"											<button type=\"submit\" name=\"shopin_order_save\" value=\"speichern\" class=\"btn btn-success\">speichern <i class=\"fa fa-save\" aria-hidden=\"true\"></i></button>\n" . 
				"										</div>\n" . 
				"									</div>\n" . 

				"								</form>\n" . 

				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
	
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-12 text-right\">\n" . 
				"							&nbsp;\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
	
//				"				</form>\n" . 

				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br />\n" . 
				"<br />\n" . 
				"<br />\n";

?>