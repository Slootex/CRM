<?php 

	require_once('includes/class_dbbmailer.php');

	use setasign\Fpdi\Fpdi;

	require_once('includes/fpdf/fpdf.php');
	require_once('includes/fpdi/code39.php');
	require_once('includes/fpdi/autoload.php');

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

		$row_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`='" . intval($_SESSION["admin"]["id"]) . "'"), MYSQLI_ASSOC);
		$row_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . intval($row_user['country']) . "'"), MYSQLI_ASSOC);
		$row_differing_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . intval($row_user['differing_country']) . "'"), MYSQLI_ASSOC);
		$row_status = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`='" . $maindata[$parameter['email_status']] . "'"), MYSQLI_ASSOC);

		$time = time();

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
						move_uploaded_file($_FILES["file"]["tmp_name"][$key], $uploaddir . "company/" . intval($_SESSION["admin"]["company_id"]) . "/user/" . $row_user['user_number'] . "/document/" . basename($random . '_' . $_FILES["file"]["name"][$key]));
						$files .= $files == "" ? $random . '_' . $_FILES["file"]["name"][$key] : "\r\n" . $random . '_' . $_FILES["file"]["name"][$key];
						$links .= $links == "" ? "<a href=\"" . $domain . "/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/user/" . $row_user['user_number'] . "/document/" . $random . '_' . $_FILES["file"]["name"][$key] . "\">" . $random . '_' . $_FILES["file"]["name"][$key] . "</a>\n" : "<br /><a href=\"" . $domain . "/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/user/" . $row_user['user_number'] . "/document/" . $random . '_' . $_FILES["file"]["name"][$key] . "\">" . $random . '_' . $_FILES["file"]["name"][$key] . "</a>\n";
						$docs .= $docs == "" ? $random . '_' . $_FILES["file"]["name"][$key] : ", " . $random . '_' . $_FILES["file"]["name"][$key];
						mysqli_query($conn, "	INSERT 	`user_users_files` 
												SET 	`user_users_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
														`user_users_files`.`" . $users_id_field . "`='" . mysqli_real_escape_string($conn, intval($row_user['id'])) . "', 
														`user_users_files`.`file`='" . mysqli_real_escape_string($conn, $random . '_' . $_FILES["file"]["name"][$key]) . "'");
					}
				}
				$j++;
			}
		}
		$links = $links == "" ? "" : "	<table cellspacing=\"3\" cellpadding=\"3\" border=\"0\"><tr><td width=\"200\" valign=\"top\"><span>Dateien:</span></td><td>" . $links . "</td></tr></table><br />\n";

		$row_template = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `templates` WHERE `templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `templates`.`id`='" . intval($_POST['email_template']) . "'"), MYSQLI_ASSOC);

		if($_POST['new_email'] == "senden"){

			$row_template['subject'] = $new_email_subject;

			$row_template['body'] = $new_email_body;

		}

		$row_template['body'] .= $row_admin['email_signature'];

		$fields = array('subject', 'body', 'admin_mail_subject');

		for($j = 0;$j < count($fields);$j++){

			$row_template[$fields[$j]] = str_replace("[status_id]", $status_number, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[status]", $row_status["name"], $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[id]", $row_user['user_number'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[date]", date("d.m.Y (H:i)", $time), $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[call_id]", $row_user['call_id'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[orig_call_id]", $row_user['orig_call_id'], $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[companyname]", $row_user['companyname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[gender]", ($row_user['gender'] == 1 ? "Sehr geehrte Frau" : "Sehr geehrter Herr"), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[sexual]", ($row_user['gender'] == 1 ? "Frau" : "Herr"), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[firstname]", $row_user['firstname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[lastname]", $row_user['lastname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[street]", $row_user['street'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[streetno]", $row_user['streetno'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[zipcode]", $row_user['zipcode'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[city]", $row_user['city'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[country]", $row_country['name'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[phonenumber]", $row_user['phonenumber'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[mobilnumber]", $row_user['mobilnumber'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[email]", "<a href=\"mailto: " . $row_user['email'] . "\">" . $row_user['email'] . "</a>\n", $row_template[$fields[$j]]);

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
			$row_template[$fields[$j]] = str_replace("[differing_companyname]", $row_user['differing_companyname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_firstname]", $row_user['differing_firstname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_lastname]", $row_user['differing_lastname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_street]", $row_user['differing_street'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_streetno]", $row_user['differing_streetno'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_zipcode]", $row_user['differing_zipcode'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_city]", $row_user['differing_city'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_country]", $row_differing_country['name'], $row_template[$fields[$j]]);

		}

		mysqli_query($conn, "	INSERT 	`" . $users_table . "_statuses` 
								SET 	`" . $users_table . "_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`" . $users_table . "_statuses`.`" . $users_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
										`" . $users_table . "_statuses`.`status_number`='" . mysqli_real_escape_string($conn, $status_number) . "', 
										`" . $users_table . "_statuses`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`" . $users_table . "_statuses`.`status_id`='" . mysqli_real_escape_string($conn, $maindata['email_status']) . "', 
										`" . $users_table . "_statuses`.`template`='" . mysqli_real_escape_string($conn, $row_template['name']) . "', 
										`" . $users_table . "_statuses`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
										`" . $users_table . "_statuses`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
										`" . $users_table . "_statuses`.`time`='" . $time . "'");

		$_SESSION["status"]["id"] = $conn->insert_id;

		mysqli_query($conn, "	INSERT 	`" . $users_table . "_emails` 
								SET 	`" . $users_table . "_emails`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`" . $users_table . "_emails`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`" . $users_table . "_emails`.`" . $users_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
										`" . $users_table . "_emails`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
										`" . $users_table . "_emails`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
										`" . $users_table . "_emails`.`time`='" . $time . "'");

		$_SESSION["emails"]["id"] = $conn->insert_id;

		mysqli_query($conn, "	INSERT 	`user_users_events` 
								SET 	`user_users_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`user_users_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`user_users_events`.`" . $users_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`user_users_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
										`user_users_events`.`message`='" . mysqli_real_escape_string($conn, $users_name . ", E-Mail - " . $row_template['name'] . ", gesendet, ID [#" . $_SESSION["emails"]["id"] . "]") . "', 
										`user_users_events`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
										`user_users_events`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
										`user_users_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

		if(($_POST['new_email'] == "senden" && $row_template['mail_with_pdf'] == 1 && !isset($_POST['no_email'])) || ($_POST['new_email'] == "sofort senden" && $row_template['mail_with_pdf'] == 1 && !isset($_POST['no_email']))){

			$filename = "begleitschein.pdf";

			$pdf = new Fpdi();

			$pdf->AddPage();

			require('includes/email_template_pdf_code_' . $row_template['id'] . '.php');

			$pdfdoc = $pdf->Output("", "S");

			if(($_POST['new_email'] == "senden" && $row_status['usermail'] == 1 && $row_order['email'] != "" && !isset($_POST['no_email'])) || ($_POST['new_email'] == "sofort senden" && $row_status['usermail'] == 1 && $row_order['email'] != "" && !isset($_POST['no_email']))){

				$mail = new dbbMailer();

				$mail->host = $maindata['smtp_host'];
				$mail->username = $maindata['smtp_username'];
				$mail->password = $maindata['smtp_password'];
				$mail->secure = $maindata['smtp_secure'];
				$mail->port = intval($maindata['smtp_port']);
				$mail->charset = $maindata['smtp_charset'];
 
				$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
				$mail->addAddress($row_order['email'], $row_order['firstname'] . " " . $$row_order['lastname']);

				//$mail->addAttachment(dirname(__FILE__) . "/../../temp/condition.tar");

				$mail->addStringAttachment($pdfdoc, $filename, 'base64', 'application/pdf');

				$mail->subject = strip_tags($row_template['subject']);

				$mail->body = $row_template['body'];

				if(!$mail->send()){

				}

			}

			if(($_POST['new_email'] == "senden" && $row_status['adminmail'] == 1 && !isset($_POST['no_email'])) || ($_POST['new_email'] == "sofort senden" && $row_status['adminmail'] == 1 && !isset($_POST['no_email']))){

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

				$mail->body = $row_template['body'];

				if(!$mail->send()){

				}

			}

		}else{

			if(($_POST['new_email'] == "senden" && $row_status['usermail'] == 1 && $row_order['email'] != "" && !isset($_POST['no_email'])) || ($_POST['new_email'] == "sofort senden" && $row_status['usermail'] == 1 && $row_order['email'] != "" && !isset($_POST['no_email']))){

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

				$mail->body = $row_template['body'];

				if(!$mail->send()){

				}

			}

			if(($_POST['new_email'] == "senden" && $row_status['adminmail'] == 1 && !isset($_POST['no_email'])) || ($_POST['new_email'] == "sofort senden" && $row_status['adminmail'] == 1 && !isset($_POST['no_email']))){

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

				$mail->body = $row_template['body'];

				if(!$mail->send()){

				}

			}

		}

	}else{

		$_POST['new_email'] = "öffnen";

	}

	$_POST['edit'] = "bearbeiten";

?>