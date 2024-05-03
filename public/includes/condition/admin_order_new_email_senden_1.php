<?php 

	require_once('includes/class_dbbmailer.php');

	use setasign\Fpdi\Fpdi;

	require_once('includes/fpdf/fpdf.php');
	require_once('includes/fpdi/code39.php');
	require_once('includes/fpdi/autoload.php');

	if($_POST['new_email'] == "sofort senden"){

		if($emsg == ""){

			$firstname_lastname = explode(" ", $new_email_name);

			$row_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "'"), MYSQLI_ASSOC);
//			$row_reason = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `reasons` WHERE `reasons`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `reasons`.`id`='" . mysqli_real_escape_string($conn, intval($row_order['component'])) . "'"), MYSQLI_ASSOC);
			$row_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . mysqli_real_escape_string($conn, intval($row_order['country'])) . "'"), MYSQLI_ASSOC);
			$row_differing_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . mysqli_real_escape_string($conn, intval($row_order['differing_country'])) . "'"), MYSQLI_ASSOC);

			$row_status = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`='" . mysqli_real_escape_string($conn, intval($maindata[$parameter['email_status']])) . "'"), MYSQLI_ASSOC);

			$time = time();

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
														AND 		`questions`.`parent_id`='" . mysqli_real_escape_string($conn, intval($row_pq_1['id'])) . "' 
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

			$row_template = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `templates` WHERE `templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `templates`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['email_template'])) . "'"), MYSQLI_ASSOC);

			$row_template['body'] .= $row_admin['email_signature'];

			$recall_time = "";

			if(strlen($row_order['recall_time']) == 3){
				$recall_time = "0" . $row_order['recall_time'][0] . ":" . $row_order['recall_time'][1] . $row_order['recall_time'][2] . " Uhr";
			}

			if(strlen($row_order['recall_time']) == 4){
				$recall_time = $row_order['recall_time'][0] . $row_order['recall_time'][1] . ":" . $row_order['recall_time'][2] . $row_order['recall_time'][3] . " Uhr";
			}

			$arr_files = explode("\r\n", $row_order['files']);

			$found_file = "";

			for($f = 0;$f < count($arr_files);$f++){
				if($arr_files[$f] != "" && substr($arr_files[$f], strpos($arr_files[$f], "_") + 1) == "vergleich.pdf"){
					$found_file = $arr_files[$f];
				}
			}

			$fields = array('subject', 'body', 'admin_mail_subject');

			for($j = 0;$j < count($fields);$j++){

				$row_template[$fields[$j]] = str_replace("[status_id]", $status_number, $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[status]", $row_status["name"], $row_template[$fields[$j]]);

				$row_template[$fields[$j]] = str_replace("[id]", $row_order['order_number'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[date]", date("d.m.Y (H:i)", $time), $row_template[$fields[$j]]);

				$row_template[$fields[$j]] = str_replace("[hash]", $row_order['hash'], $row_template[$fields[$j]]);

				$row_template[$fields[$j]] = str_replace("[machine]", strip_tags($row_order['machine']), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[model]", strip_tags($row_order['model']), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[constructionyear]", strip_tags($row_order['constructionyear']), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[carid]", strtoupper(strip_tags($row_order['carid'])), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[vin_html]", htmlentities($row_order['vin_html']), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[kw]", strip_tags($row_order['kw']), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[mileage]", number_format(intval($row_order['mileage']), 0, '', '.') . " km", $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[mechanism]", ($row_order['mechanism'] == 0 ? "Schaltung" : "Automatik"), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[fuel]", ($row_order['fuel'] == 0 ? "Benzin" : "Diesel"), $row_template[$fields[$j]]);

				if($found_file != ""){
					$row_template[$fields[$j]] = str_replace("[compare-pdf]", "<a href=\"" . $domain . "/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/document/" . $found_file . "\">Vergleich</a>", $row_template[$fields[$j]]);
				}

				$row_template[$fields[$j]] = str_replace("[companyname]", $row_order['companyname'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[gender]", ($row_order['gender'] == 1 ? "Sehr geehrte Frau" : "Sehr geehrter Herr"), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[sexual]", ($row_order['gender'] == 1 ? "Frau" : "Herr"), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[firstname]", ($row_order['differing_shipping_address'] == 1 ? $row_order['firstname'] : $row_order['firstname']), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[lastname]", ($row_order['differing_shipping_address'] == 1 ? $row_order['lastname'] : $row_order['lastname']), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[street]", $row_order['street'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[streetno]", $row_order['streetno'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[zipcode]", $row_order['zipcode'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[city]", $row_order['city'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[country]", $row_country['name'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[phonenumber]", $row_order['phonenumber'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[mobilnumber]", $row_order['mobilnumber'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[email]", "<a href=\"mailto: " . $row_order['email'] . "\">" . $row_order['email'] . "</a>\n", $row_template[$fields[$j]]);

				$html_differing_shipping_address = 	$row_order['differing_shipping_address'] == 0 ? 
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
				$row_template[$fields[$j]] = str_replace("[differing_firstname]", $row_order['firstname'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_lastname]", $row_order['lastname'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_street]", $row_order['differing_street'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_streetno]", $row_order['differing_streetno'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_zipcode]", $row_order['differing_zipcode'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_city]", $row_order['differing_city'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_country]", $row_differing_country['name'], $row_template[$fields[$j]]);

				$question_str = "<table cellspacing=\"1\" cellpadding=\"1\">\n" . 
								"	<tr>\n" . 
								"		<td width=\"200\" valign=\"top\"><u>Fragen</u></td>\n" . 
								"		<td>\n" . 

								$question_str . 

								"		</td>\n" . 
								"	</tr>\n" . 
								"</table>\n";
				$row_template[$fields[$j]] = str_replace("[question]", $question_str, $row_template[$fields[$j]]);

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

				$row_template[$fields[$j]] = str_replace("[recall]", ($row_order['recall_date'] != "" ? date("d.m.Y", $row_order['recall_date']) . " - " . $recall_time : ""), $row_template[$fields[$j]]);

			}

			mysqli_query($conn, "	INSERT 	`" . $order_table . "_statuses` 
									SET 	`" . $order_table . "_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
											`" . $order_table . "_statuses`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
											`" . $order_table . "_statuses`.`status_number`='" . mysqli_real_escape_string($conn, $status_number) . "', 
											`" . $order_table . "_statuses`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`" . $order_table . "_statuses`.`status_id`='" . mysqli_real_escape_string($conn, $maindata['email_status']) . "', 
											`" . $order_table . "_statuses`.`template`='" . mysqli_real_escape_string($conn, $row_template['name']) . "', 
											`" . $order_table . "_statuses`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
											`" . $order_table . "_statuses`.`body`='" . mysqli_real_escape_string($conn, str_replace("[track]", "", $row_template['body'])) . "', 
											`" . $order_table . "_statuses`.`public`='1', 
											`" . $order_table . "_statuses`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

			$_SESSION["status"]["id"] = $conn->insert_id;

			mysqli_query($conn, "	INSERT 	`" . $order_table . "_emails` 
									SET 	`" . $order_table . "_emails`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
											`" . $order_table . "_emails`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`" . $order_table . "_emails`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
											`" . $order_table . "_emails`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
											`" . $order_table . "_emails`.`body`='" . mysqli_real_escape_string($conn, str_replace("[track]", "", $row_template['body'])) . "', 
											`" . $order_table . "_emails`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

			$_SESSION["emails"]["id"] = $conn->insert_id;

			mysqli_query($conn, "	INSERT 	`" . $order_table . "_events` 
									SET 	`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
											`" . $order_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`" . $order_table . "_events`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
											`" . $order_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
											`" . $order_table . "_events`.`message`='" . mysqli_real_escape_string($conn, "E-Mail - " . $row_template['name'] . ", gesendet, ID [#" . $_SESSION["emails"]["id"] . "]") . "', 
											`" . $order_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
											`" . $order_table . "_events`.`body`='" . mysqli_real_escape_string($conn, str_replace("[track]", "", $row_template['body'])) . "', 
											`" . $order_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

			$tracking_image = "<img src=\"" . $domain . "/email-logo/" . $_SESSION["admin"]["company_id"] . "/" . $row_order['order_number'] . "/" . $status_number . "\" width=\"0\" height=\"0\" border=\"0\" />\n";

			if($row_template['mail_with_pdf'] == 1){

				$filename = "begleitschein.pdf";

				$pdf = new Fpdi();

				$pdf->AddPage();

				require('includes/email_template_pdf_code_' . $row_template['id'] . '.php');

				$pdfdoc = $pdf->Output("", "S");

				if($row_status['usermail'] == 1){

					$mail = new dbbMailer();

					$mail->host = $maindata['smtp_host'];
					$mail->username = $maindata['smtp_username'];
					$mail->password = $maindata['smtp_password'];
					$mail->secure = $maindata['smtp_secure'];
					$mail->port = intval($maindata['smtp_port']);
					$mail->charset = $maindata['smtp_charset'];

					$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
					$mail->addAddress($row_order['email'], $row_order['firstname'] . " " . $row_order['lastname']);

					if($found_file != ""){
	//					$mail->addAttachment("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/document/" . $found_file);
					}

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

					if($found_file != ""){
	//					$mail->addAttachment("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/document/" . $found_file);
					}

					$mail->addStringAttachment($pdfdoc, $filename, 'base64', 'application/pdf');

					$mail->subject = strip_tags($row_template['admin_mail_subject']);

					$mail->body = str_replace("[track]", "", $row_template['body']);

					if(!$mail->send()){

					}

				}

			}else{

				if($row_status['usermail'] == 1){

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

		}else{

			$_POST['new_email'] = "öffnen";

		}

		$_POST['edit'] = "bearbeiten";

	}

	if($_POST['new_email'] == "senden"){

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

		if(strlen($_POST['new_email_name']) < 1 || strlen($_POST['new_email_name']) > 256){
			$emsg .= "<small class=\"error text-muted\">Bitte ein Vorname und Nachname eingeben. (max. 256 Zeichen)</small><br />\n";
			$inp_new_email_name = " is-invalid";
		} else {
			$new_email_name = strip_tags($_POST['new_email_name']);
		}

		if(strlen($_POST['new_email_email']) < 1 || strlen($_POST['new_email_email']) > 128){
			$emsg .= "<small class=\"error text-muted\">Bitte eine E-Mail eingeben. (max. 128 Zeichen)</small><br />\n";
			$inp_new_email_email = " is-invalid";
		} else {
			$new_email_email = strip_tags($_POST['new_email_email']);
		}

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

		if($emsg == ""){
	
			$firstname_lastname = explode(" ", $new_email_name);
	
			$row_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "'"), MYSQLI_ASSOC);
			$row_reason = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `reasons` WHERE `reasons`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `reasons`.`id`='" . mysqli_real_escape_string($conn, intval($row_order['component'])) . "'"), MYSQLI_ASSOC);
			$row_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . mysqli_real_escape_string($conn, intval($row_order['country'])) . "'"), MYSQLI_ASSOC);
			$row_differing_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . mysqli_real_escape_string($conn, intval($row_order['differing_country'])) . "'"), MYSQLI_ASSOC);
	
			$row_status = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`='" . mysqli_real_escape_string($conn, intval($maindata[$parameter['email_status']])) . "'"), MYSQLI_ASSOC);
	
			$time = time();
	
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
														AND 		`questions`.`parent_id`='" . mysqli_real_escape_string($conn, intval($row_pq_1['id'])) . "' 
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
							move_uploaded_file($_FILES["file"]["tmp_name"][$key], $uploaddir . "company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/document/" . basename($random . '_' . $_FILES["file"]["name"][$key]));
							$files .= $files == "" ? $random . '_' . $_FILES["file"]["name"][$key] : "\r\n" . $random . '_' . $_FILES["file"]["name"][$key];
							$links .= $links == "" ? "<a href=\"" . $domain . "/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/document/" . $random . '_' . $_FILES["file"]["name"][$key] . "\">" . $random . '_' . $_FILES["file"]["name"][$key] . "</a>\n" : "<br /><a href=\"" . $domain . "/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/document/" . $random . '_' . $_FILES["file"]["name"][$key] . "\">" . $random . '_' . $_FILES["file"]["name"][$key] . "</a>\n";
							$docs .= $docs == "" ? $random . '_' . $_FILES["file"]["name"][$key] : ", " . $random . '_' . $_FILES["file"]["name"][$key];
							mysqli_query($conn, "	INSERT 	`order_orders_files` 
													SET 	`order_orders_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
															`order_orders_files`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
															`order_orders_files`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "', 
															`order_orders_files`.`type`='0', 
															`order_orders_files`.`file`='" . mysqli_real_escape_string($conn, $random . '_' . $_FILES["file"]["name"][$key]) . "', 
															`order_orders_files`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
						}
					}
					$j++;
				}
			}
			$links = $links == "" ? "" : "	<table cellspacing=\"3\" cellpadding=\"3\" border=\"0\"><tr><td width=\"200\" valign=\"top\"><span>Dateien:</span></td><td>" . $links . "</td></tr></table><br />\n";
	
			$row_template = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `templates` WHERE `templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `templates`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['email_template'])) . "'"), MYSQLI_ASSOC);
	
			if($_POST['new_email'] == "senden"){
	
				$row_template['subject'] = $new_email_subject;
	
				$row_template['body'] = $new_email_body;
	
			}
	
			$row_template['body'] .= $row_admin['email_signature'];
	
			$recall_time = "";
	
			if(strlen($row_order['recall_time']) == 3){
				$recall_time = "0" . $row_order['recall_time'][0] . ":" . $row_order['recall_time'][1] . $row_order['recall_time'][2] . " Uhr";
			}
	
			if(strlen($row_order['recall_time']) == 4){
				$recall_time = $row_order['recall_time'][0] . $row_order['recall_time'][1] . ":" . $row_order['recall_time'][2] . $row_order['recall_time'][3] . " Uhr";
			}
	
			$arr_files = explode("\r\n", $row_order['files']);
	
			$found_file = "";
	
			for($f = 0;$f < count($arr_files);$f++){
				if($arr_files[$f] != "" && substr($arr_files[$f], strpos($arr_files[$f], "_") + 1) == "vergleich.pdf"){
					$found_file = $arr_files[$f];
				}
			}
	
			$fields = array('subject', 'body', 'admin_mail_subject');
	
			for($j = 0;$j < count($fields);$j++){
	
				$row_template[$fields[$j]] = str_replace("[status_id]", $status_number, $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[status]", $row_status["name"], $row_template[$fields[$j]]);
	
				$row_template[$fields[$j]] = str_replace("[id]", $row_order['order_number'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[date]", date("d.m.Y (H:i)", $time), $row_template[$fields[$j]]);
	
				$row_template[$fields[$j]] = str_replace("[hash]", $row_order['hash'], $row_template[$fields[$j]]);
	
				$row_template[$fields[$j]] = str_replace("[machine]", strip_tags($row_order['machine']), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[model]", strip_tags($row_order['model']), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[constructionyear]", strip_tags($row_order['constructionyear']), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[carid]", strtoupper(strip_tags($row_order['carid'])), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[vin_html]", htmlentities($row_order['vin_html']), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[kw]", strip_tags($row_order['kw']), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[mileage]", number_format(intval($row_order['mileage']), 0, '', '.') . " km", $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[mechanism]", ($row_order['mechanism'] == 0 ? "Schaltung" : "Automatik"), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[fuel]", ($row_order['fuel'] == 0 ? "Benzin" : "Diesel"), $row_template[$fields[$j]]);
	
				$row_template[$fields[$j]] = str_replace("[files]", $links, $row_template[$fields[$j]]);
	
				if($found_file != ""){
					$row_template[$fields[$j]] = str_replace("[compare-pdf]", "<a href=\"" . $domain . "/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/document/" . $found_file . "\">Vergleich</a>", $row_template[$fields[$j]]);
				}
	
				$row_template[$fields[$j]] = str_replace("[companyname]", $row_order['companyname'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[gender]", ($row_order['gender'] == 1 ? "Sehr geehrte Frau" : "Sehr geehrter Herr"), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[sexual]", ($row_order['gender'] == 1 ? "Frau" : "Herr"), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[firstname]", ($row_order['differing_shipping_address'] == 1 ? $row_order['firstname'] : $firstname_lastname[0]), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[lastname]", ($row_order['differing_shipping_address'] == 1 ? $row_order['lastname'] : $firstname_lastname[1]), $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[street]", $row_order['street'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[streetno]", $row_order['streetno'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[zipcode]", $row_order['zipcode'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[city]", $row_order['city'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[country]", $row_country['name'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[phonenumber]", $row_order['phonenumber'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[mobilnumber]", $row_order['mobilnumber'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[email]", "<a href=\"mailto: " . $new_email_email . "\">" . $new_email_email . "</a>\n", $row_template[$fields[$j]]);
	
				$html_differing_shipping_address = 	$row_order['differing_shipping_address'] == 0 ? 
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
				$row_template[$fields[$j]] = str_replace("[differing_firstname]", $firstname_lastname[0], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_lastname]", $firstname_lastname[1], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_street]", $row_order['differing_street'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_streetno]", $row_order['differing_streetno'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_zipcode]", $row_order['differing_zipcode'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_city]", $row_order['differing_city'], $row_template[$fields[$j]]);
				$row_template[$fields[$j]] = str_replace("[differing_country]", $row_differing_country['name'], $row_template[$fields[$j]]);
	
				$question_str = "<table cellspacing=\"1\" cellpadding=\"1\">\n" . 
								"	<tr>\n" . 
								"		<td width=\"200\" valign=\"top\"><u>Fragen</u></td>\n" . 
								"		<td>\n" . 
	
								$question_str . 
	
								"		</td>\n" . 
								"	</tr>\n" . 
								"</table>\n";
				$row_template[$fields[$j]] = str_replace("[question]", $question_str, $row_template[$fields[$j]]);
	
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
	
				$row_template[$fields[$j]] = str_replace("[recall]", ($row_order['recall_date'] != "" ? date("d.m.Y", $row_order['recall_date']) . " - " . $recall_time : ""), $row_template[$fields[$j]]);
	
			}
	
			mysqli_query($conn, "	UPDATE	`order_orders` 
									SET 	`order_orders`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`order_orders`.`" . ($row_order['differing_shipping_address'] == 1 ? "differing_firstname" : "firstname") . "`='" . mysqli_real_escape_string($conn, $firstname_lastname[0]) . "', 
											`order_orders`.`" . ($row_order['differing_shipping_address'] == 1 ? "differing_lastname" : "lastname") . "`='" . mysqli_real_escape_string($conn, $firstname_lastname[1]) . "', 
											`order_orders`.`email`='" . mysqli_real_escape_string($conn, $new_email_email) . "', 
											`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
									WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
									AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");
	
			mysqli_query($conn, "	INSERT 	`" . $order_table . "_statuses` 
									SET 	`" . $order_table . "_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
											`" . $order_table . "_statuses`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
											`" . $order_table . "_statuses`.`status_number`='" . mysqli_real_escape_string($conn, $status_number) . "', 
											`" . $order_table . "_statuses`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`" . $order_table . "_statuses`.`status_id`='" . mysqli_real_escape_string($conn, $maindata['email_status']) . "', 
											`" . $order_table . "_statuses`.`template`='" . mysqli_real_escape_string($conn, $row_template['name']) . "', 
											`" . $order_table . "_statuses`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
											`" . $order_table . "_statuses`.`body`='" . mysqli_real_escape_string($conn, str_replace("[track]", "", $row_template['body'])) . "', 
											`" . $order_table . "_statuses`.`public`='1', 
											`" . $order_table . "_statuses`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
	
			$_SESSION["status"]["id"] = $conn->insert_id;
	
			mysqli_query($conn, "	INSERT 	`" . $order_table . "_emails` 
									SET 	`" . $order_table . "_emails`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
											`" . $order_table . "_emails`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`" . $order_table . "_emails`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
											`" . $order_table . "_emails`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
											`" . $order_table . "_emails`.`body`='" . mysqli_real_escape_string($conn, str_replace("[track]", "", $row_template['body'])) . "', 
											`" . $order_table . "_emails`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
	
			$_SESSION["emails"]["id"] = $conn->insert_id;
	
			mysqli_query($conn, "	INSERT 	`" . $order_table . "_events` 
									SET 	`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
											`" . $order_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`" . $order_table . "_events`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
											`" . $order_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
											`" . $order_table . "_events`.`message`='" . mysqli_real_escape_string($conn, "E-Mail - " . $row_template['name'] . ", gesendet, ID [#" . $_SESSION["emails"]["id"] . "]") . "', 
											`" . $order_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
											`" . $order_table . "_events`.`body`='" . mysqli_real_escape_string($conn, str_replace("[track]", "", $row_template['body'])) . "', 
											`" . $order_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
	
			$tracking_image = "<img src=\"" . $domain . "/email-logo/" . $_SESSION["admin"]["company_id"] . "/" . $row_order['order_number'] . "/" . $status_number . "\" width=\"0\" height=\"0\" border=\"0\" />\n";
	
			if($row_template['mail_with_pdf'] == 1){
	
				$filename = "begleitschein.pdf";
	
				$pdf = new Fpdi();
	
				$pdf->AddPage();
	
				require('includes/email_template_pdf_code_' . $row_template['id'] . '.php');
	
				$pdfdoc = $pdf->Output("", "S");
	
				if($row_status['usermail'] == 1 && $new_email_email != ""){
	
					$mail = new dbbMailer();
	
					$mail->host = $maindata['smtp_host'];
					$mail->username = $maindata['smtp_username'];
					$mail->password = $maindata['smtp_password'];
					$mail->secure = $maindata['smtp_secure'];
					$mail->port = intval($maindata['smtp_port']);
					$mail->charset = $maindata['smtp_charset'];
	 
					$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
					$mail->addAddress($new_email_email, $new_email_name);
	
					if($found_file != ""){
	//					$mail->addAttachment("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/document/" . $found_file);
					}
	
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
	
					if($found_file != ""){
	//					$mail->addAttachment("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/document/" . $found_file);
					}
	
					$mail->addStringAttachment($pdfdoc, $filename, 'base64', 'application/pdf');
	
					$mail->subject = strip_tags($row_template['admin_mail_subject']);
	
					$mail->body = str_replace("[track]", "", $row_template['body']);
	
					if(!$mail->send()){
	
					}
	
				}
	
			}else{
	
				if($row_status['usermail'] == 1 && $new_email_email != ""){
	
					$mail = new dbbMailer();
	
					$mail->host = $maindata['smtp_host'];
					$mail->username = $maindata['smtp_username'];
					$mail->password = $maindata['smtp_password'];
					$mail->secure = $maindata['smtp_secure'];
					$mail->port = intval($maindata['smtp_port']);
					$mail->charset = $maindata['smtp_charset'];
	 
					$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
					$mail->addAddress($new_email_email, $new_email_name);
	
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
	
		}else{
	
			$_POST['new_email'] = "öffnen";
	
		}
	
		$_POST['edit'] = "bearbeiten";

	}

?>