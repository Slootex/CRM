<?php 

	require_once('includes/class_dbbmailer.php');

	use setasign\Fpdi\Fpdi;

	require_once('includes/fpdf/fpdf.php');
	require_once('includes/fpdi/code39.php');
	require_once('includes/fpdi/autoload.php');

	if(strlen($_POST['ref_number']) > 128){
		$emsg .= "<small class=\"error text-muted\">Bitte eine Referenznummer eingeben. (max. 128 Zeichen)</small><br />\n";
		$inp_ref_number = " is-invalid";
	} else {
		$ref_number = strip_tags($_POST['ref_number']);
	}

	if(strlen($_POST['companyname']) < 1 || strlen($_POST['companyname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Firmenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_companyname = " is-invalid";
	} else {
		$companyname = strip_tags($_POST['companyname']);
	}

	if(strlen($_POST['firstname']) < 1 || strlen($_POST['firstname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Vorname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_firstname = " is-invalid";
	} else {
		$firstname = strip_tags($_POST['firstname']);
	}

	if(strlen($_POST['lastname']) < 1 || strlen($_POST['lastname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Nachname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_lastname = " is-invalid";
	} else {
		$lastname = strip_tags($_POST['lastname']);
	}

	if(strlen($_POST['street']) < 1 || strlen($_POST['street']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Straßenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_street = " is-invalid";
	} else {
		$street = strip_tags($_POST['street']);
	}

	if(strlen($_POST['streetno']) < 1 || strlen($_POST['streetno']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Hausnummer ein. (max. 10 Zeichen)</small><br />\n";
		$inp_streetno = " is-invalid";
	} else {
		$streetno = strip_tags($_POST['streetno']);
	}

	if(strlen($_POST['zipcode']) < 1 || strlen($_POST['zipcode']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Postleitzahl ein. (max. 10 Zeichen)</small><br />\n";
		$inp_zipcode = " is-invalid";
	} else {
		$zipcode = strip_tags($_POST['zipcode']);
	}

	if(strlen($_POST['city']) < 1 || strlen($_POST['city']) > 128){
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

	if($emsg == ""){

		$row_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`='" . intval($_SESSION["admin"]["id"]) . "'"), MYSQLI_ASSOC);

		$row_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . intval($country) . "'"), MYSQLI_ASSOC);

		$time = time();

		$user_number = 0;

		while($user_number == 0){

			$random = rand(10001, 99999);

			$result = mysqli_query($conn, "SELECT * FROM `user_users` WHERE `user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `user_users`.`user_number`='" . $random . "'");

			if($result->num_rows == 0){
				$user_number = $random;
			}

		}

		mkdir("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/user/" . $user_number, 0777);
		mkdir("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/user/" . $user_number . "/userdata", 0777);
		copy("includes/.htaccess", "uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/user/" . $user_number . "/userdata/.htaccess");
		mkdir("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/user/" . $user_number . "/document", 0777);
		copy("includes/.htaccess", "uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/user/" . $user_number . "/document/.htaccess");
		mkdir("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/user/" . $user_number . "/audio", 0777);
		copy("includes/.htaccess", "uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/user/" . $user_number . "/audio/.htaccess");

		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$password = array();
		$alphaLength = strlen($alphabet) - 1;
		for ($i = 0; $i < 8; $i++) {
			$password[] = $alphabet[rand(0, $alphaLength)];
		}
		$pass = implode($password);

		mysqli_query($conn, "INSERT 	`user_users` 
								SET 	`user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`user_users`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`user_users`.`user_number`='" . mysqli_real_escape_string($conn, $user_number) . "', 
										`user_users`.`ref_number`='" . mysqli_real_escape_string($conn, ($ref_number != "" ? $ref_number : $user_number)) . "', 
										`user_users`.`companyname`='" . mysqli_real_escape_string($conn, $companyname) . "', 
										`user_users`.`gender`='" . mysqli_real_escape_string($conn, intval(isset($_POST['gender']) ? $_POST['gender'] : 0)) . "', 
										`user_users`.`firstname`='" . mysqli_real_escape_string($conn, $firstname) . "', 
										`user_users`.`lastname`='" . mysqli_real_escape_string($conn, $lastname) . "', 
										`user_users`.`street`='" . mysqli_real_escape_string($conn, $street) . "', 
										`user_users`.`streetno`='" . mysqli_real_escape_string($conn, $streetno) . "', 
										`user_users`.`zipcode`='" . mysqli_real_escape_string($conn, $zipcode) . "', 
										`user_users`.`city`='" . mysqli_real_escape_string($conn, $city) . "', 
										`user_users`.`country`='" . mysqli_real_escape_string($conn, $country) . "', 
										`user_users`.`phonenumber`='" . mysqli_real_escape_string($conn, $phonenumber) . "', 
										`user_users`.`mobilnumber`='" . mysqli_real_escape_string($conn, $mobilnumber) . "', 
										`user_users`.`email`='" . mysqli_real_escape_string($conn, $email) . "', 
										`user_users`.`password`='" . mysqli_real_escape_string($conn, sha1($pass)) . "', 
										`user_users`.`regverify`='1', 
										`user_users`.`reg_date`='" . $time . "', 
										`user_users`.`upd_date`='" . $time . "'");

		$_POST["id"] = $conn->insert_id;

		$row_status = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`='" . $maindata['user_status_intern'] . "'"), MYSQLI_ASSOC);

		$row_template = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `templates` WHERE `templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `templates`.`id`='" . $row_status['email_template'] . "'"), MYSQLI_ASSOC);

		$row_template['body'] .= $row_admin['email_signature'];

		$status_number = intval($_SESSION["admin"]["id"]) . "A" . date("dmYHis", time());

		$fields = array('subject', 'body', 'admin_mail_subject');

		for($j = 0;$j < count($fields);$j++){

			$row_template[$fields[$j]] = str_replace("[status_id]", $status_number, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[status]", $row_status["name"], $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[id]", $user_number, $row_template[$fields[$j]]);
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

			$row_template[$fields[$j]] = str_replace("[password]", $pass, $row_template[$fields[$j]]);

		}

		mysqli_query($conn, "INSERT 	`" . $users_table . "_statuses` 
								SET 	`" . $users_table . "_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`" . $users_table . "_statuses`.`" . $users_id_field . "`='" . mysqli_real_escape_string($conn, $_POST["id"]) . "', 
										`" . $users_table . "_statuses`.`status_number`='" . mysqli_real_escape_string($conn, $status_number) . "', 
										`" . $users_table . "_statuses`.`admin_id`='" . mysqli_real_escape_string($conn, $_SESSION["admin"]["id"]) . "', 
										`" . $users_table . "_statuses`.`status_id`='" . mysqli_real_escape_string($conn, $row_status['id']) . "', 
										`" . $users_table . "_statuses`.`template`='" . mysqli_real_escape_string($conn, $row_template['name']) . "', 
										`" . $users_table . "_statuses`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
										`" . $users_table . "_statuses`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
										`" . $users_table . "_statuses`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

		$_SESSION["status"]["id"] = $conn->insert_id;

		mysqli_query($conn, "INSERT 	`user_users_events` 
								SET 	`user_users_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`user_users_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`user_users_events`.`" . $users_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`user_users_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
										`user_users_events`.`message`='" . mysqli_real_escape_string($conn, $users_name . " (Intern), erstellt, ID [#" . $_POST["id"] . "]") . "', 
										`user_users_events`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
										`user_users_events`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
										`user_users_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

		if($row_template['mail_with_pdf'] == 1){

			$filename = "begleitschein.pdf";

			$pdf = new Fpdi();

			$pdf->AddPage();

			require('includes/email_template_pdf_code_' . $row_template['id'] . '.php');

			$pdf_file = dirname(__FILE__) . "/pdf/steuergeraete-reparaturauftrag-interaktiv.pdf";
			$file = fopen($pdf_file, 'rb');
			$pdfdoc = fread($file, filesize($pdf_file));
			fclose($file);

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

				$mail->body = $row_template['body'];

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

				$mail->body = $row_template['body'];

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

				$mail->body = $row_template['body'];

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

				$mail->body = $row_template['body'];

				if(!$mail->send()){

				}

			}

		}

		$emsg = "<p>Der neue Kunde, " . $users_name . " wurde erfolgreich hinzugefügt!</p>\n";

		$_POST["edit"] = "bearbeiten";

	}else{

		$_POST["add"] = "hinzufügen";

	}

?>