<?php 

	header("HTTP/1.0 404 Not Found");

	require_once('includes/class_dbbmailer.php');

	$emsg_text = "";

	$company_id = 1;

	$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'"), MYSQLI_ASSOC);

	if(isset($_POST['absenden'])){ // Fehler melden

		$json = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=6LfvPKAUAAAAAPXAumdJQ4koPvil3rJnF621c_wK&response=' . strip_tags($_POST['g-recaptcha-response']));
		$data = json_decode($json);

		if($data->success == true){

			$name = (!empty($_POST["name"])) ? strip_tags($_POST["name"]) : "Info";
			$email = (!empty($_POST["email"])) ? strip_tags($_POST["email"]) : "";
			$nachricht = (!empty($_POST["nachricht"])) ? strip_tags($_POST["nachricht"]) : "";

			$subject = "GZA MOTORS Webseite: Fehler melden";
			$to = "info@gzamotors.de";
			$from = !empty($email) ? $email : $to;

			$row_admin = array();

			$row_admin['email'] = $from;

			$row_template = array();

			$row_template['subject'] = $subject;

			$row_template['body'] = $nachricht;

			$mail = new dbbMailer();

			$mail->host = $maindata['smtp_host'];
			$mail->username = $maindata['smtp_username'];
			$mail->password = $maindata['smtp_password'];
			$mail->secure = $maindata['smtp_secure'];
			$mail->port = intval($maindata['smtp_port']);
			$mail->charset = $maindata['smtp_charset'];

			$mail->setFrom($row_admin['email'], $name);
			$mail->addAddress($email, $name);

			//$mail->addAttachment(dirname(__FILE__) . "/../../temp/condition.tar");

			$mail->addStringAttachment($pdfdoc, $filename, 'base64', 'application/pdf');

			$mail->subject = strip_tags($row_template['subject']);

			$mail->body = str_replace("[track]", "", $row_template['body']);

			if(!$mail->send()){

			}

			$emsg_text = "Vielen Dank wir werden Ihre Anfrage schnellstens bearbeiten.";
			
		}else{
			$emsg_text = "Es ist ein Fehler aufgetreten. Bitte akzeptieren Sie Cookies!";
		}

	}

?>