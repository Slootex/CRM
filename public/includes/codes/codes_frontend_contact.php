<?php

require_once('includes/class_dbbmailer.php');

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$company_id = 3;

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'"), MYSQLI_ASSOC);

$emsg_title = "";
$emsg_text = "";

if(isset($_POST["type"]) && isset($_POST["number"])){

	if(!empty($_POST["type"]) && !empty($_POST["number"])){

		$type = strip_tags($_POST["type"]);
		$number = strip_tags($_POST["number"]);

		$subject = "GZA MOTORS Webseite: Rückrufservice " . ($type == "new" ? "Neukunde" : "Bestandskunde");
		$name = ($type == "new" ? "Neukunde" : "Bestandskunde");

		$body = "<strong>Kundendaten</strong><br><br>";
		$body .= "Kundengruppe: " . ($type == "new" ? "Neukunde" : "Bestandskunde") . "<br>";
		$body .= "Rückruf -Telefonnummer: " . $number . "<br>";

		$row_template = array();

		$row_template['subject'] = $subject;

		$row_template['body'] = $body;

		$mail = new dbbMailer();

		$mail->host = $maindata['smtp_host'];
		$mail->username = $maindata['smtp_username'];
		$mail->password = $maindata['smtp_password'];
		$mail->secure = $maindata['smtp_secure'];
		$mail->port = intval($maindata['smtp_port']);
		$mail->charset = $maindata['smtp_charset'];

		$mail->setFrom($maindata['email'], $maindata['company']);
		$mail->addAddress($maindata['email'], $maindata['company']);

		//$mail->addAttachment(dirname(__FILE__) . "/../../temp/condition.tar");

		//$mail->addStringAttachment($pdfdoc, $filename, 'base64', 'application/pdf');

		$mail->subject = strip_tags($row_template['subject']);

		$mail->body = str_replace("[track]", "", $row_template['body']);

		if(!$mail->send()){

		}

		$emsg_title = "Mich anrufen, " . ($type == "new" ? "Privatkunden" : "Gewerbekunden");

		$emsg_text = "Vielen Dank wir werden Sie schnellstens zurückrufen.";

	}else{

		$emsg_title = "Mich anrufen";

		$emsg_text = "Es ist ein Fehler aufgetreten. Zurück zu <a href=\"/kontakt\">Kontakt</a>.";

	}

}

if(isset($_POST['absenden'])){ // Kontaktformular

	$json = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=6LclQV4bAAAAAGJifjwm2iYQouWWEgG6EOUtQgCm&response=' . strip_tags($_POST['g-recaptcha-response']));
	$data = json_decode($json);

	if($data->success == true){

		$name = (!empty($_POST["name"])) ? strip_tags($_POST["name"]) : "Info";
		$email = (!empty($_POST["email"])) ? strip_tags($_POST["email"]) : "";
		$number = (!empty($_POST["number"])) ? strip_tags($_POST["number"]) : "";
		$nachricht = (!empty($_POST["nachricht"])) ? strip_tags($_POST["nachricht"]) : "";

		$subject = "GZA MOTORS Webseite: Formular Kundenkontakt";

		$body = "<strong>Kundendaten:</strong><br><br>";
		$body .= "Name: " . $name . "<br>";
		$body .= "E-Mail: " . $email . "<br>";
		$body .= "Tel-Nr: " . $number . "<br><br><br>";
		$body .= "<strong>Folgende Nachricht schrieb der Kunde:</strong><br>" . $nachricht . "<br>";

		$row_template = array();

		$row_template['subject'] = $subject;

		$row_template['body'] = $body;

		$mail = new dbbMailer();

		$mail->host = $maindata['smtp_host'];
		$mail->username = $maindata['smtp_username'];
		$mail->password = $maindata['smtp_password'];
		$mail->secure = $maindata['smtp_secure'];
		$mail->port = intval($maindata['smtp_port']);
		$mail->charset = $maindata['smtp_charset'];

		$mail->setFrom($maindata['email'], $maindata['company']);
		$mail->addAddress($maindata['email'], $maindata['company']);

		//$mail->addAttachment(dirname(__FILE__) . "/../../temp/condition.tar");

		//$mail->addStringAttachment($pdfdoc, $filename, 'base64', 'application/pdf');

		$mail->subject = strip_tags($row_template['subject']);

		$mail->body = str_replace("[track]", "", $row_template['body']);

		if(!$mail->send()){

		}

		$emsg_title = "Kontakt";

		$emsg_text = "Vielen Dank wir werden Ihre Anfrage schnellstens bearbeiten.";

	}else{

		$emsg_title = "Kontakt";

		$emsg_text = "Es ist ein Fehler aufgetreten. Bitte akzeptieren Sie Cookies! Zurück zu <a href=\"/kontakt\">Kontakt</a>.";

	}

}

?>