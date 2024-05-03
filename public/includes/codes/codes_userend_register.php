<?php 

@session_start();

require_once('includes/class_dbbmailer.php');

use setasign\Fpdi\Fpdi;

require_once('includes/fpdf/fpdf.php');
require_once('includes/fpdi/code39.php');
require_once('includes/fpdi/autoload.php');

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$company_id = 1;

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'"), MYSQLI_ASSOC);

$inp_firstname = "";
$inp_lastname = "";
$inp_email = "";
$inp_password = "";
$inp_password2 = "";

$firstname = "";
$lastname = "";
$email = "";
$password = "";
$password2 = "";

$emsg = "";

if(isset($_POST['save']) && $_POST['save'] == "REGISTRIEREN"){

	if(strlen($_POST['firstname']) < 1 || strlen($_POST['firstname']) > 256){
		$emsg .= "<span class=\"error\">Bitte Ihren Namen eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_firstname = " is-invalid";
	} else {
		$firstname = strip_tags($_POST['firstname']);
	}

	if(strlen($_POST['lastname']) < 1 || strlen($_POST['lastname']) > 256){
		$emsg .= "<span class=\"error\">Bitte Ihren Zunamen eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_lastname = " is-invalid";
	} else {
		$lastname = strip_tags($_POST['lastname']);
	}

	if(preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,26})$/", $_POST['email']) && $_POST['email'] != ""){
		$exist_user = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `user_users` WHERE `user_users`.`email`='" . mysqli_real_escape_string($conn, strip_tags($_POST['email'])) . "' limit 0, 1"), MYSQLI_ASSOC);
		if(isset($exist_user['id'])){
			$emsg .= "<span class=\"error\">Ihre E-Mail-Adresse existiert bereits.</span><br />\n";
			$inp_email = " is-invalid";
		}else{
			$email = strip_tags($_POST['email']);
		}
	} else {
		$emsg .= "<span class=\"error\">Bitte Ihre E-Mail-Adresse eingeben.</span><br />\n";
		$inp_email = " is-invalid";
	}

	if(strlen($_POST['password']) < 1 || strlen($_POST['password']) > 128){
		$emsg .= "<span class=\"error\">Bitte Ihr Kennwort eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_password = " is-invalid";
	} else {
		$password = strip_tags($_POST['password']);
	}

	if(strlen($_POST['password2']) < 1 || strlen($_POST['password2']) > 128){
		$emsg .= "<span class=\"error\">Bitte Ihr Kennwort wiederholt eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_password2 = " is-invalid";
	} else {
		if($_POST['password'] != $_POST['password2']){
			$emsg .= "<span class=\"error\">Bitte Ihr Kennwort wiederholt eingeben. Die beiden Kennwort eingaben sind unterschiedlich. (max. 128 Zeichen)</span><br />\n";
			$inp_password = " is-invalid";
			$inp_password2 = " is-invalid";
		}else{
			$password2 = strip_tags($_POST['password2']);
		}
	}

	if($emsg == ""){

		$row_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `admin`.`id`='" . intval($maindata['admin_id']) . "'"), MYSQLI_ASSOC);

		$domain = isset($_SERVER['HTTPS']) ? "https://" . $_SERVER['HTTP_HOST'] : "http://" . $_SERVER['HTTP_HOST'];

		$reghash = bin2hex(random_bytes(32));

		$time = time();

		$user_number = 0;

		while($user_number == 0){

			$random = rand(10001, 99999);

			$result = mysqli_query($conn, "SELECT * FROM `user_users` WHERE `user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `user_users`.`user_number`='" . $random . "'");

			if($result->num_rows == 0){
				$user_number = $random;
			}

		}

		mkdir("uploads/company/" . intval($company_id) . "/user/" . $user_number, 0777);
		mkdir("uploads/company/" . intval($company_id) . "/user/" . $user_number . "/userdata", 0777);
		copy("includes/.htaccess", "uploads/company/" . intval($company_id) . "/user/" . $user_number . "/userdata/.htaccess");
		mkdir("uploads/company/" . intval($company_id) . "/user/" . $user_number . "/document", 0777);
		copy("includes/.htaccess", "uploads/company/" . intval($company_id) . "/user/" . $user_number . "/document/.htaccess");
		mkdir("uploads/company/" . intval($company_id) . "/user/" . $user_number . "/audio", 0777);
		copy("includes/.htaccess", "uploads/company/" . intval($company_id) . "/user/" . $user_number . "/audio/.htaccess");

		mysqli_query($conn, "	INSERT 	`user_users` 
								SET 	`user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
										`user_users`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`user_users`.`user_number`='" . mysqli_real_escape_string($conn, $user_number) . "', 
										`user_users`.`gender`='" . mysqli_real_escape_string($conn, (isset($_POST['gender']) ? intval($_POST['gender']) : 0)) . "', 
										`user_users`.`firstname`='" . mysqli_real_escape_string($conn, $firstname) . "', 
										`user_users`.`lastname`='" . mysqli_real_escape_string($conn, $lastname) . "', 
										`user_users`.`email`='" . mysqli_real_escape_string($conn, $email) . "', 
										`user_users`.`password`='" . mysqli_real_escape_string($conn, sha1($password)) . "', 
										`user_users`.`reghash`='" . mysqli_real_escape_string($conn, $reghash) . "', 
										`user_users`.`regverify`='0', 
										`user_users`.`reg_date`='" . $time . "', 
										`user_users`.`upd_date`='" . $time . "'");

		$_POST["id"] = $conn->insert_id;

		mysqli_query($conn, "	INSERT 	`user_users_events` 
								SET 	`user_users_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
										`user_users_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
										`user_users_events`.`user_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`user_users_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
										`user_users_events`.`message`='" . mysqli_real_escape_string($conn, "Kunde (Intern), erstellt, ID [#" . $_POST["id"]) . "]', 
										`user_users_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

		$row_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `admin`.`id`='" . intval($maindata['admin_id']) . "'"), MYSQLI_ASSOC);

		$row_status = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `statuses`.`id`='" . $maindata['user_status'] . "'"), MYSQLI_ASSOC);

		$row_template = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `templates` WHERE `templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `templates`.`id`='" . $row_status['email_template'] . "'"), MYSQLI_ASSOC);

		$row_template['body'] .= $row_admin['email_signature'];

		$status_number = intval($maindata['admin_id']) . "A" . date("dmYHis", time());

		mysqli_query($conn, "	INSERT 	`user_users_statuses` 
								SET 	`user_users_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
										`user_users_statuses`.`user_id`='" . mysqli_real_escape_string($conn, $_POST["id"]) . "', 
										`user_users_statuses`.`status_number`='" . mysqli_real_escape_string($conn, $status_number) . "', 
										`user_users_statuses`.`admin_id`='" . mysqli_real_escape_string($conn, $maindata['admin_id']) . "', 
										`user_users_statuses`.`status_id`='" . mysqli_real_escape_string($conn, $row_status['id']) . "', 
										`user_users_statuses`.`subject`='" . mysqli_real_escape_string($conn, $row_template['name']) . "', 
										`user_users_statuses`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

		$_SESSION["status"]["id"] = $conn->insert_id;

		$fields = array('subject', 'body', 'admin_mail_subject');

		for($j = 0;$j < count($fields);$j++){

			$row_template[$fields[$j]] = str_replace("[status_id]", $status_number, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[status]", $row_status["name"], $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[id]", $user_number, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[date]", date("d.m.Y (H:i)", $time), $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[gender]", (isset($_POST['gender']) && $_POST['gender'] == 1 ? "Sehr geehrte Frau" : "Sehr geehrter Herr"), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[firstname]", $firstname, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[lastname]", $lastname, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[email]", "<a href=\"mailto: " . $email . "\">" . $email . "</a>\n", $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[verify_email_link]", "<a href=\"" . $domain . "/kunden/verifizieren/" . $reghash . "\">Ja, ich bestätige</a>\n", $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[password]", $password, $row_template[$fields[$j]]);

		}

		if($row_template['mail_with_pdf'] == 1){

			$filename = "begleitschein.pdf";

			$pdf = new Fpdi();

			$pdf->AddPage();

			require('includes/email_template_pdf_code_' . $row_template['id'] . '.php');

			/*$pdfdoc = $pdf->Output("", "S");*/
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

				$mail->body = str_replace("[track]", "", $row_template['body']);

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

				$mail->body = str_replace("[track]", "", $row_template['body']);

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

				$mail->body = str_replace("[track]", "", $row_template['body']);

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

		$emsg = "<p>Sie haben sich erfolgreich registriert! Bitte bestätigen Sie dies in der von uns gesendeten Email in ihrem Postfach.</p>\n";

	}

}

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$html = "<br />\n";

if(isset($_POST['id']) && $_POST['id'] > 0){

	$html .= 	"<div class=\"card\">\n" . 
				"	<div class=\"card-header\">\n" . 
				"		<h4 class=\"mb-0\">Ihre Daten</h4>\n" . 
				"	</div>\n" . 
				"	<div class=\"card-body\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"	</div>\n" . 
				"</div>\n" . 
				"<br /><br /><br />\n";

}else{
	
	$html .= 	"<div class=\"card\">\n" . 
				"	<div class=\"card-header\">\n" . 
				"		<h4 class=\"mb-0\">Ihre Daten</h4>\n" . 
				"	</div>\n" . 
				"	<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"		<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"			<div class=\"form-group row\">\n" . 
				"				<div class=\"col-sm-12 mt-2\">\n" . 
				"					<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"						<input type=\"radio\" id=\"gender_0\" name=\"gender\" value=\"0\"" . ((isset($_POST['save']) && $_POST['save'] == "REGISTRIEREN" ? $_POST['gender'] : $row_order["gender"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"						<label class=\"custom-control-label\" for=\"gender_0\">\n" . 
				"							Herr\n" . 
				"						</label>\n" . 
				"					</div>\n" . 
				"					<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"						<input type=\"radio\" id=\"gender_1\" name=\"gender\" value=\"1\"" . ((isset($_POST['save']) && $_POST['save'] == "REGISTRIEREN" ? $_POST['gender'] : $row_order["gender"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"						<label class=\"custom-control-label\" for=\"gender_1\">\n" . 
				"							Frau\n" . 
				"						</label>\n" . 
				"					</div>\n" . 
				"				</div>\n" . 
				"			</div>\n" . 
				"			<div class=\"form-group row\">\n" . 
				"				<label for=\"firstname\" class=\"col-sm-2 col-form-label\">Name</label>\n" . 
				"				<div class=\"col-sm-6\">\n" . 
				"					<input type=\"text\" id=\"firstname\" name=\"firstname\" value=\"" . $firstname . "\" class=\"form-control" . $inp_firstname . "\" />\n" . 
				"				</div>\n" . 
				"			</div>\n" . 
				"			<div class=\"form-group row\">\n" . 
				"				<label for=\"lastname\" class=\"col-sm-2 col-form-label\">Zuname</label>\n" . 
				"				<div class=\"col-sm-6\">\n" . 
				"					<input type=\"text\" id=\"lastname\" name=\"lastname\" value=\"" . $lastname . "\" class=\"form-control" . $inp_lastname . "\" />\n" . 
				"				</div>\n" . 
				"			</div>\n" . 
				"			<div class=\"form-group row\">\n" . 
				"				<label for=\"email\" class=\"col-sm-2 col-form-label\">Benutzer/Email</label>\n" . 
				"				<div class=\"col-sm-6\">\n" . 
				"					<input type=\"email\" id=\"user\" name=\"email\" value=\"" . $email . "\" class=\"form-control" . $inp_email . "\" />\n" . 
				"				</div>\n" . 
				"			</div>\n" . 
				"			<div class=\"form-group row\">\n" . 
				"				<label for=\"password\" class=\"col-sm-2 col-form-label\">Kennwort</label>\n" . 
				"				<div class=\"col-sm-6\">\n" . 
				"					<input type=\"password\" id=\"password\" name=\"password\" class=\"form-control" . $inp_password . "\" />\n" . 
				"				</div>\n" . 
				"			</div>\n" . 
				"			<div class=\"form-group row\">\n" . 
				"				<label for=\"password2\" class=\"col-sm-2 col-form-label\">Kennwort wiederholen</label>\n" . 
				"				<div class=\"col-sm-6\">\n" . 
				"					<input type=\"password\" id=\"password2\" name=\"password2\" class=\"form-control" . $inp_password2 . "\" />\n" . 
				"				</div>\n" . 
				"			</div>\n" . 
				"			<div class=\"row px-0 card-footer\">\n" . 
				"				<div class=\"col-sm-6\">\n" . 
				"					<input type=\"submit\" name=\"save\" value=\"REGISTRIEREN\" class=\"btn btn-primary\" />\n" . 
				"				</div>\n" . 
				"				<div class=\"col-sm-6\" align=\"right\">\n" . 
				"					&nbsp;\n" . 
				"				</div>\n" . 
				"			</div>\n" . 
				"		</form>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br /><br /><br />\n";

}
?>