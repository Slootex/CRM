<?php 

	require_once('includes/class_dbbmailer.php');

	use setasign\Fpdi\Fpdi;

	require_once('includes/fpdf/fpdf.php');
	require_once('includes/fpdi/code39.php');
	require_once('includes/fpdi/autoload.php');

	$time = time();

	$row_intern = mysqli_fetch_array(mysqli_query($conn, "	SELECT 		`intern_interns`.`id` AS id, 
																		`intern_interns`.`intern_number` AS intern_number, 
																		`intern_interns`.`order_id` AS order_id, 
																		`intern_interns`.`device_id` AS device_id, 
																		`intern_interns`.`to_storage_space_id` AS to_storage_space_id, 
																		`order_orders_devices`.`storage_space_id` AS storage_space_id, 
																		`intern_interns`.`message` AS message, 
																		`order_orders_devices`.`device_number` AS device_number, 
																		(SELECT `storage_places`.`name` AS s_s_name FROM `storage_places` WHERE `storage_places`.`id`=`order_orders_devices`.`storage_space_id`) AS storage_space, 
																		(SELECT `storage_places`.`name` AS s_s_to_name FROM `storage_places` WHERE `storage_places`.`id`=`intern_interns`.`to_storage_space_id`) AS to_storage_space, 
																		(SELECT `storage_places`.`parts` AS s_s_to_parts FROM `storage_places` WHERE `storage_places`.`id`=`intern_interns`.`to_storage_space_id`) AS to_parts, 
																		(SELECT `storage_places`.`used` AS s_s_to_used FROM `storage_places` WHERE `storage_places`.`id`=`intern_interns`.`to_storage_space_id`) AS to_used 
															FROM 		`intern_interns` 
															LEFT JOIN	`order_orders_devices` 
															ON			`intern_interns`.`device_id`=`order_orders_devices`.`id` 
															WHERE		`intern_interns`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
															AND 		`intern_interns`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND  `order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($row_intern['order_id'])) . "'"), MYSQLI_ASSOC);

	if(isset($row_order['id']) && $row_order['id'] > 0){

		if(isset($row_order['id']) && $row_order['mode'] < 2){

			$order_name = "Auftrag";

			$order_table = "order_orders";

			$order_id_field = "order_id";

			$status_field = "order_relocate_status";

		}else{

			$order_name = "Interessent";

			$order_table = "interested_interesteds";

			$order_id_field = "interested_id";

			$status_field = "interested_relocate_status";

		}

	}else{

		$emsg = "<p>Der zugehörige Auftrag oder Interessent wurde nicht gefunden!</p>\n";

	}

	if($emsg == ""){

		$row_storage_place = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_intern['storage_space_id'])) . "'"), MYSQLI_ASSOC);

		if($row_storage_place['used'] < $row_storage_place['parts']){

			mysqli_query($conn, "UPDATE `storage_places` SET `storage_places`.`used`=`storage_places`.`used`-1 WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_intern['storage_space_id'])) . "'");

			mysqli_query($conn, "	INSERT 	`" . $order_table . "_events` 
									SET 	`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
											`" . $order_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`" . $order_table . "_events`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($row_intern['order_id'])) . "', 
											`" . $order_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
											`" . $order_table . "_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $row_intern['device_number'] . ", Daten geändert (Umlagern alter Lagerplatz " . $row_intern['storage_space'] . " entfernt), ID [#" . intval($row_intern['device_id']) . "]") . "', 
											`" . $order_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $row_intern['device_number'] . ", Daten geändert (Umlagern alter Lagerplatz " . $row_intern['storage_space'] . " entfernt), ID [#" . intval($row_intern['device_id']) . "]") . "', 
											`" . $order_table . "_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
											`" . $order_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

			mysqli_query($conn, "	INSERT 	`order_orders_devices_events` 
									SET 	`order_orders_devices_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
											`order_orders_devices_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`order_orders_devices_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_intern['order_id'])) . "', 
											`order_orders_devices_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
											`order_orders_devices_events`.`message`='" . mysqli_real_escape_string($conn, "<span class=\"badge badge-danger\">Gerät " . $row_intern['device_number'] . ", Lagerplatz " . $row_intern['storage_space'] . " entfernt, ID [#" . $row_intern['device_id'] . "]</span>") . "', 
											`order_orders_devices_events`.`subject`='', 
											`order_orders_devices_events`.`body`='', 
											`order_orders_devices_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

			mysqli_query($conn, "	UPDATE 	`order_orders_devices` 
									SET 	`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`order_orders_devices`.`storage_space`='" . mysqli_real_escape_string($conn, strip_tags(isset($row_storage_place['name']) ? $row_storage_place['name'] : "")) . "', 
											`order_orders_devices`.`storage_space_id`='" . mysqli_real_escape_string($conn, intval($row_intern['to_storage_space_id'])) . "', 
											`order_orders_devices`.`storage_space_owner`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`order_orders_devices`.`storage_space_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
											`order_orders_devices`.`is_relocate`='0', 
											`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
									WHERE 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($row_intern['device_id'])) . "' 
									AND 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

			mysqli_query($conn, "	INSERT 	`order_orders_devices_events` 
									SET 	`order_orders_devices_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
											`order_orders_devices_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`order_orders_devices_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_intern['order_id'])) . "', 
											`order_orders_devices_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
											`order_orders_devices_events`.`message`='" . mysqli_real_escape_string($conn, "<span class=\"badge badge-warning\">Gerät " . $row_intern['device_number'] . " umgelagert, ID [#" . $row_intern['device_id'] . "]</span>") . "', 
											`order_orders_devices_events`.`subject`='', 
											`order_orders_devices_events`.`body`='', 
											`order_orders_devices_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

			mysqli_query($conn, "	DELETE FROM	`intern_interns` 
									WHERE 		`intern_interns`.`id`='" . mysqli_real_escape_string($conn, intval($row_intern['id'])) . "' 
									AND 		`intern_interns`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

			$row_status = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`='" . mysqli_real_escape_string($conn, intval($maindata[$status_field])) . "'"), MYSQLI_ASSOC);

			$row_template = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `templates` WHERE `templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `templates`.`id`='" . mysqli_real_escape_string($conn, intval($row_status['email_template'])) . "'"), MYSQLI_ASSOC);

			$row_template['body'] .= $row_admin['email_signature'];

			$status_number = intval($_SESSION["admin"]["id"]) . "A" . date("dmYHis", time());

			$fields = array('subject', 'body', 'admin_mail_subject');

			for($j = 0;$j < count($fields);$j++){

				$row_template[$fields[$j]] = str_replace("[status_id]", $status_number, $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[status]", $row_status["name"], $row_template[$fields[$j]]);

				$row_template[$fields[$j]] = str_replace("[id]", $row_intern['device_number'], $row_template[$fields[$j]]);
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

//					$row_template[$fields[$j]] = str_replace("[files]", $links, $row_template[$fields[$j]]);

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

			$tracking_image = "<img src=\"" . $domain . "/email-logo/" . $_SESSION["admin"]["company_id"] . "/" . $row_order['order_number'] . "/" . $status_number . "\" width=\"0\" height=\"0\" border=\"0\" />\n";

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

			$emsg = "<p>Das Umlagern wurde erfolgreich durchgeführt!</p>\n";

		}else{
			
			$emsg = "<p>Das Umlagern ist fehlgeschlagen weil der angegebene Lagerplatz inzwischen belegt wurde!</p>\n";

		}

	}

	unset($_POST['id']);

?>