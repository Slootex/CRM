<?php 

	require_once('includes/class_dbbmailer.php');

	use setasign\Fpdi\Fpdi;

	require_once('includes/fpdf/fpdf.php');
	require_once('includes/fpdi/code39.php');
	require_once('includes/fpdi/autoload.php');

	$time = time();

	$data = array();

	$data_string = json_encode($data, JSON_UNESCAPED_UNICODE);

	$ch = curl_init($maindata['ups_url'] . '/ship/v1/shipments/cancel/' . strip_tags($_POST['shipments_id']));
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'AccessLicenseNumber: ' . $maindata['ups_access_license_number'],
			'Password: ' . $maindata['ups_password'],
			'Content-Type: application/json',
			'Username: ' . $maindata['ups_username'],
			'Accept: application/json',
			'Content-Length: ' . strlen($data_string)
		)
	);

	$result = curl_exec($ch);

	$response = json_decode($result);

	if(isset($response->VoidShipmentResponse->Response->ResponseStatus->Code) && $response->VoidShipmentResponse->Response->ResponseStatus->Code == "1"){

		$row_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "'"), MYSQLI_ASSOC);
		$row_shipment = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders_shipments` WHERE `order_orders_shipments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_shipments`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['shipping_id'])) . "'"), MYSQLI_ASSOC);
		$row_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . mysqli_real_escape_string($conn, intval($row_shipment['country'])) . "'"), MYSQLI_ASSOC);
		$row_reason = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `reasons` WHERE `reasons`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `reasons`.`id`='" . mysqli_real_escape_string($conn, intval($row_order['component'])) . "'"), MYSQLI_ASSOC);
		$row_status = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`='" . mysqli_real_escape_string($conn, intval($maindata[$parameter['shipping_cancel_status']])) . "'"), MYSQLI_ASSOC);
		$row_template = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `templates` WHERE `templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `templates`.`id`='" . mysqli_real_escape_string($conn, intval($row_status['email_template'])) . "'"), MYSQLI_ASSOC);

		$row_template['body'] .= $row_admin['email_signature'];

		$questions = array();

		$result_qa = mysqli_query($conn, "	SELECT 		* 
											FROM 		`order_orders_questions` 
											WHERE 		`order_orders_questions`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
											AND 		`order_orders_questions`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
											ORDER BY 	CAST(`order_orders_questions`.`id` AS UNSIGNED) ASC");

		while($row_qa = $result_qa->fetch_array(MYSQLI_ASSOC)){
			$questions['question_' . $row_qa['question_id']] = $row_qa['answer_id'];
		}

		$result_pq_1 = mysqli_query($conn, "	SELECT 		`questions`.`id` AS id, 
															`questions`.`name` AS name, 
															`questions`.`title` AS title, 
															`questions`.`imagepath` AS imagepath, 
															`questions`.`hash` AS hash, 
															`questions`.`pos` AS pos 
												FROM 		`questions` 
												WHERE 		`questions`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
												AND 		`questions`.`parent_id`='0' 
												AND 		`questions`.`category_id`='1' 
												AND 		`questions`.`enable`='1' 
												ORDER BY 	CAST(`questions`.`pos` AS UNSIGNED) ASC");

		$question_str = "<table cellspacing=\"1\" cellpadding=\"1\">\n";

		while($row_pq_1 = $result_pq_1->fetch_array(MYSQLI_ASSOC)){

			$question_str .= 	"	<tr>\n" . 
								"		<td>" . $row_pq_1['title'] . "</td>\n" . 
								"		<td>\n";

			$result_sq_1 = mysqli_query($conn, "	SELECT 		`questions`.`id` AS id, 
																`questions`.`name` AS name, 
																`questions`.`title` AS title, 
																`questions`.`imagepath` AS imagepath, 
																`questions`.`hash` AS hash, 
																`questions`.`pos` AS pos 
													FROM 		`questions` 
													WHERE 		`questions`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
													AND 		`questions`.`parent_id`='" .mysqli_real_escape_string($conn,  intval($row_pq_1['id'])) . "' 
													AND 		`questions`.`category_id`='1' 
													AND 		`questions`.`enable`='1' 
													ORDER BY 	CAST(`questions`.`pos` AS UNSIGNED) ASC");

			while($row_sq_1 = $result_sq_1->fetch_array(MYSQLI_ASSOC)){
				$question_str .= 	"			<input type=\"radio\" name=\"answer_" . $row_sq_1['id'] . "\"" . (isset($questions['question_' . $row_pq_1['id']]) && intval($questions['question_' . $row_pq_1['id']]) == $row_sq_1['id'] ? " checked=\"checked\"" : "") . " value=\"1\" /><strong>" . $row_sq_1['title'] . "</strong><br />\n";
			}

			$question_str .= 	"		</td>\n" . 
								"	</tr>\n";

		}

		$question_str .= 	"</table>\n";

		$status_number = intval($_SESSION["admin"]["id"]) . "A" . date("dmYHis", time());

		$domain = isset($_SERVER['HTTPS']) ? "https://" . $_SERVER['HTTP_HOST'] : "http://" . $_SERVER['HTTP_HOST'];

		$fields = array('subject', 'body', 'admin_mail_subject');

		for($j = 0;$j < count($fields);$j++){

			$row_template[$fields[$j]] = str_replace("[status_id]", $status_number, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[status]", $row_status["name"], $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[label_url]", "<a href=\"" . strip_tags($row_shipment['label_url']) . "\" target=\"_blank\">öffnen</a>", $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[shipments_id]", strip_tags($row_shipment['shipments_id']), $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[tracking_url]", "<a href=\"https://www.ups.com/WebTracking/processInputRequest?tracknum=" . strip_tags($row_shipment['carrier_tracking_no']) . "&loc=de_DE\" target=\"_blank\">öffnen</a>", $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[print_label]", "<a href=\"" . $domain . "/versendung/label/" . intval($_SESSION["admin"]["company_id"]) . "/" . strip_tags($row_shipment['shipments_id']) . "\" target=\"_blank\">öffnen</a>", $row_template[$fields[$j]]);


			$row_template[$fields[$j]] = str_replace("[id]", $row_order['order_number'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[date]", date("d.m.Y (H:i)", $time), $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[gender]", ($row_order['gender'] == 1 ? "Sehr geehrte Frau" : "Sehr geehrter Herr"), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[sexual]", ($row_order['gender'] == 1 ? "Frau" : "Herr"), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[companyname]", $row_shipment['companyname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[firstname]", $row_shipment['firstname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[lastname]", $row_shipment['lastname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[street]", $row_shipment['street'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[streetno]", $row_shipment['streetno'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[zipcode]", $row_shipment['zipcode'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[city]", $row_shipment['city'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[country]", $row_country['name'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[phonenumber]", $row_order['phonenumber'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[mobilnumber]", $row_order['mobilnumber'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[email]", "<a href=\"mailto: " . $row_order['email'] . "\">" . $row_order['email'] . "</a>\n", $row_template[$fields[$j]]);

			$question_str = "<table cellspacing=\"1\" cellpadding=\"1\">\n" . 
							"	<tr>\n" . 
							"		<td width=\"200\" valign=\"top\"><u>Fragen</u></td>\n" . 
							"		<td>\n" . 

							$question_str . 

							"		</td>\n" . 
							"	</tr>\n" . 
							"</table>\n";
			$row_template[$fields[$j]] = str_replace("[question]", $question_str, $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[machine]", strip_tags($row_order['machine']), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[model]", strip_tags($row_order['model']), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[constructionyear]", strip_tags($row_order['constructionyear']), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[carid]", strtoupper(strip_tags($row_order['carid'])), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[vin_html]", htmlentities($row_order['vin_html']), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[kw]", strip_tags($row_order['kw']), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[mileage]", number_format(intval($row_order['mileage']), 0, '', '.') . " km", $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[mechanism]", ($row_order['mechanism'] == 0 ? "Schaltung" : "Automatik"), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[fuel]", ($row_order['fuel'] == 0 ? "Benzin" : "Diesel"), $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[reason]", $row_order['reason'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[description]", $row_order['description'], $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[files]", $links, $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[pricemwst]", number_format($row_order['pricemwst'], 2, ',', '') . " €", $row_template[$fields[$j]]);
			$radio_radio_shipping = array(	"65" => "UPS Saver", 
											"11" => "UPS Standard");
			$row_template[$fields[$j]] = str_replace("[radio_shipping]", $radio_radio_shipping[$row_order['radio_shipping']], $row_template[$fields[$j]]);
			$radio_radio_payment = array(	0 => "Überweisung (Sie überweisen den Rechnungsbetrag per Überweisung)", 
											1 => "Nachnahme", 
											2 => "Bar");
			$row_template[$fields[$j]] = str_replace("[radio_payment]", $radio_radio_payment[$row_order['radio_payment']], $row_template[$fields[$j]]);
			if($radio_payment == 1){
				$row_template[$fields[$j]] = str_replace("[amount]", "<strong><u>Kosten</u></strong> <br>Betrag: " . number_format($row_shipment['price'], 2, ',', '') . " &euro;<br>Versand: " . number_format($response->ShipmentResponse->ShipmentResults->NegotiatedRateCharges->TotalChargesWithTaxes->MonetaryValue, 2, ',', '') . " &euro;<br>Gesammt: <u>" . number_format(($response->ShipmentResponse->ShipmentResults->NegotiatedRateCharges->TotalChargesWithTaxes->MonetaryValue + $amount), 2, ',', '') . "</u> &euro;<br>", $row_template[$fields[$j]]);
			}else{
				$row_template[$fields[$j]] = str_replace("[shipping_costs]", "<strong><u>Kosten</u></strong> <br>Versand: " . number_format($row_shipment['total_charges_with_taxes'], 2, ',', '') . " &euro;<br>Gesammt: <u>" . number_format(($response->ShipmentResponse->ShipmentResults->NegotiatedRateCharges->TotalChargesWithTaxes->MonetaryValue), 2, ',', '') . "</u> &euro;<br>", $row_template[$fields[$j]]);
			}
		}

		mysqli_query($conn, "	UPDATE	`order_orders` 
								SET 	`order_orders`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
								WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
								AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		mysqli_query($conn, "	INSERT 	`" . $order_table . "_statuses` 
								SET 	`" . $order_table . "_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`" . $order_table . "_statuses`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`" . $order_table . "_statuses`.`status_number`='" . mysqli_real_escape_string($conn, $status_number) . "', 
										`" . $order_table . "_statuses`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`" . $order_table . "_statuses`.`status_id`='" . mysqli_real_escape_string($conn, intval($row_status['id'])) . "', 
										`" . $order_table . "_statuses`.`template`='" . mysqli_real_escape_string($conn, $row_template['name']) . "', 
										`" . $order_table . "_statuses`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
										`" . $order_table . "_statuses`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
										`" . $order_table . "_statuses`.`public`='1', 
										`" . $order_table . "_statuses`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$_SESSION["status"]["id"] = $conn->insert_id;

		mysqli_query($conn, "	UPDATE 	`order_orders_shipments` 
								SET 	`order_orders_shipments`.`status`='1' 
								WHERE 	`order_orders_shipments`.`id`='" . intval($_POST['shipping_id']) . "' 
								AND 	`order_orders_shipments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		mysqli_query($conn, "	INSERT 	`" . $order_table . "_events` 
								SET 	`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`" . $order_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`" . $order_table . "_events`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`" . $order_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
										`" . $order_table . "_events`.`message`='" . mysqli_real_escape_string($conn, $order_name . ", Versendung storniert, ID [#" . intval($_POST["shipping_id"]) . "]") . "', 
										`" . $order_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, $order_name . ", Versendung storniert, ID [#" . intval($_POST["shipping_id"]) . "]") . "', 
										`" . $order_table . "_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
										`" . $order_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$tracking_image = "<img src=\"" . $domain . "/email-logo/" . $_SESSION["admin"]["company_id"] . "/" . $row_order['order_number'] . "/" . $status_number . "\" width=\"0\" height=\"0\" border=\"0\" />\n";

		if(isset($_POST['shippinng_storno_mail_with_pdf']) && intval($_POST['shippinng_storno_mail_with_pdf']) == 1){

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

				$mail->body = str_replace("[track]", $tracking_image, $row_template['body']);

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

				$mail->body = str_replace("[track]", $tracking_image, $row_template['body']);

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

		$emsg_shipping_cancel = 	"				<hr />\n" . 
									"				<div class=\"alert alert-success text-white alert-dismissible fade show\" role=\"alert\"><p>Die Sendung wurde erfolgreich storniert.</p></div>\n";
		
	}else{

		$emsg_shipping_cancel = 	"				<hr />\n" . 
									"				<div class=\"alert alert-danger text-white alert-dismissible fade show\" role=\"alert\"><p>" . $response->response->errors[0]->message . "</p></div>\n";
	}

	$_POST['edit'] = "bearbeiten";

?>