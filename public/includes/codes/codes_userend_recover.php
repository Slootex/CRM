<?php 

@session_start();

require_once('includes/class_dbbmailer.php');

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$company_id = 1;

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'"), MYSQLI_ASSOC);

$email = "";

$emsg = "";

if(isset($param['email']) && $param['email'] != ""){

	if(preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,26})$/", $param['email']) && $param['email'] != ""){
		$email = $param['email'];
	} else {
		$emsg .= "<span class=\"error\">Die verwendete Emailadresse ist ungültig.</span><br />\n";
	}

	if($emsg == ""){

		$row = mysqli_fetch_array(mysqli_query($conn, "	SELECT 		*
														FROM 		`user_users` 
														WHERE 		`user_users`.`email`='" . mysqli_real_escape_string($conn, $email) . "' 
														AND 		`user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'"), MYSQLI_ASSOC);

		if(isset($row["id"]) && $row["id"] > 0){

			$domain = isset($_SERVER['HTTPS']) ? "https://" . $_SERVER['HTTP_HOST'] : "http://" . $_SERVER['HTTP_HOST'];

			$recoverhash = bin2hex(random_bytes(32));

			mysqli_query($conn, "	UPDATE 	`user_users` 
									SET 	`user_users`.`recoverhash`='" . mysqli_real_escape_string($db->con, $recoverhash) . "' 
									WHERE 	`user_users`.`email`='" . $email . "' 
									AND 	`user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

			$message = "<p>Kennwort wiederherstellen? <a href=\"" . $domain . "/kunden/wiederherstellen/" . $email . "/" . $recoverhash . "\" target=\"_blank\">Ja wiederherstellen!</a></p>\n";

			$row_template = array();

			$row_template['subject'] = "GZA motors - Kennwort wiederherstellen";

			$row_template['body'] = $message;

			$mail = new dbbMailer();

			$mail->host = $maindata['smtp_host'];
			$mail->username = $maindata['smtp_username'];
			$mail->password = $maindata['smtp_password'];
			$mail->secure = $maindata['smtp_secure'];
			$mail->port = intval($maindata['smtp_port']);
			$mail->charset = $maindata['smtp_charset'];

			$mail->setFrom($maindata['email'], strip_tags($row_template['from']));
			$mail->addAddress($row['email'], $row['firstname'] . " " . $row['lastname']);

			//$mail->addAttachment(dirname(__FILE__) . "/../../temp/condition.tar");

			//$mail->addStringAttachment($pdfdoc, $filename, 'base64', 'application/pdf');

			$mail->subject = strip_tags($row_template['subject']);

			$mail->body = str_replace("[track]", "", $row_template['body']);

			if(!$mail->send()){

			}

			$emsg = "<p>Bitte bestätigen Sie die Wiederherstellung ihres Kennwortes.</p>\n";

		}else{

			$emsg = "<p>Die verwendete Emailadresse ist ungültig.</p>\n";

		}

	}

}

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$html = "<br />\n" . 
		"<div class=\"card\">\n" . 
		"	<div class=\"card-header\">\n" . 
		"		<h4 class=\"mb-0\">Kennwort wiederherstellen</h4>\n" . 
		"	</div>\n" . 
		"	<div class=\"card-body\">\n" . 

		($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

		"	</div>\n" . 
		"</div>\n" . 
		"<br /><br /><br />\n";

?>