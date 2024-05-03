<?php 

@session_start();

require_once('includes/class_dbbmailer.php');

use setasign\Fpdi\Fpdi;

require_once('includes/fpdf/fpdf.php');
require_once('includes/fpdi/code39.php');
require_once('includes/fpdi/autoload.php');

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$company_id = 1;

$html = "";

if(isset($param['slug']) && isset($param['password']) && isset($param['order_number']) && intval($param['order_number']) > 0){

	$company = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `companies` WHERE `companies`.`login_slug`='" . mysqli_real_escape_string($conn, strip_tags($param['slug'])) . "'"), MYSQLI_ASSOC);

	if(isset($company['id']) && intval($company['id']) > 0){

		$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($company['id'])) . "' AND `maindata`.`url_password`='" . mysqli_real_escape_string($conn, strip_tags($param['password'])) . "'"), MYSQLI_ASSOC);

		if(isset($maindata['id']) && intval($maindata['id']) > 0){

			$company_id = $maindata['company_id'];

			$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `order_orders`.`order_number`='" . mysqli_real_escape_string($conn, strip_tags($param['order_number'])) . "'"), MYSQLI_ASSOC);

			if(isset($row_order['id']) && intval($row_order['id']) > 0){

				$row_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `admin`.`id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "'"), MYSQLI_ASSOC);
				$row_reason = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `reasons` WHERE `reasons`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `reasons`.`id`='" . mysqli_real_escape_string($conn, intval($row_order['component'])) . "'"), MYSQLI_ASSOC);
				$row_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . mysqli_real_escape_string($conn, intval($row_order['country'])) . "'"), MYSQLI_ASSOC);
				$row_differing_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . mysqli_real_escape_string($conn, intval($row_order['differing_country'])) . "'"), MYSQLI_ASSOC);

				$time = time();

				$row_last_paying = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders_payings` WHERE `order_orders_payings`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `order_orders_payings`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' ORDER BY CAST(`order_orders_payings`.`time` AS UNSIGNED) DESC limit 0, 1"), MYSQLI_ASSOC);

				if(isset($row_last_paying['id'])){

					mysqli_query($conn, "	UPDATE 	`order_orders_payings` 
											SET 	`order_orders_payings`.`payed`='1', 
													`order_orders_payings`.`payed_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
											WHERE 	`order_orders_payings`.`id`='" . mysqli_real_escape_string($conn, intval($row_last_paying['id'])) . "' 
											AND 	`order_orders_payings`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

				}

				if(intval($row_order['transfer_date']) == 0){

					mysqli_query($conn, "	UPDATE 	`order_orders` 
											SET 	`order_orders`.`mode`='0', 
													`order_orders`.`transfer_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
													`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
											WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
											AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

				}else{

					mysqli_query($conn, "	UPDATE 	`order_orders` 
											SET 	`order_orders`.`mode`='0', 
													`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
											WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
											AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

				}

				$row_status = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `statuses`.`id`='" . mysqli_real_escape_string($conn, intval($maindata['order_payed_status'])) . "'"), MYSQLI_ASSOC);
			
				$row_template = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `templates` WHERE `templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `templates`.`id`='" . mysqli_real_escape_string($conn, intval($row_status['email_template'])) . "'"), MYSQLI_ASSOC);
			
				$row_template['body'] .= $row_admin['email_signature'];
			
				$status_number = intval($maindata['admin_id']) . "A" . date("dmYHis", time());
			
				$domain = isset($_SERVER['HTTPS']) ? "https://" . $_SERVER['HTTP_HOST'] : "http://" . $_SERVER['HTTP_HOST'];
			
				$fields = array('subject', 'body', 'admin_mail_subject');
			
				for($j = 0;$j < count($fields);$j++){
			
					$row_template[$fields[$j]] = str_replace("[status_id]", $status_number, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[status]", $row_status["name"], $row_template[$fields[$j]]);
			
					$row_template[$fields[$j]] = str_replace("[id]", $row_order['order_number'], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[date]", date("d.m.Y (H:i)", $time), $row_template[$fields[$j]]);
			
					$row_template[$fields[$j]] = str_replace("[companyname]", $row_order['companyname'], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[gender]", (isset($row_order['gender']) && $row_order['gender'] == 1 ? "Sehr geehrte Frau" : "Sehr geehrter Herr"), $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[sexual]", (isset($row_order['gender']) && $row_order['gender'] == 1 ? "Frau" : "Herr"), $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[firstname]", $row_order['firstname'], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[lastname]", $row_order['lastname'], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[street]", $row_order['street'], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[streetno]", $row_order['streetno'], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[zipcode]", $row_order['zipcode'], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[city]", $row_order['city'], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[country]", $row_country['name'], $row_template[$fields[$j]]);
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
			
					$row_template[$fields[$j]] = str_replace("[differing_shipping_address]", $row_order['differing_shipping_address'], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[differing_companyname]", $row_order['differing_companyname'], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[differing_firstname]", $row_order['differing_firstname'], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[differing_lastname]", $row_order['differing_lastname'], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[differing_street]", $row_order['differing_street'], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[differing_streetno]", $row_order['differing_streetno'], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[differing_zipcode]", $row_order['differing_zipcode'], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[differing_city]", $row_order['differing_city'], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[differing_country]", $row_differing_country['name'], $row_template[$fields[$j]]);
			
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
			
					$row_template[$fields[$j]] = str_replace("[machine]", $row_order['machine'], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[model]", $row_order['model'], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[constructionyear]", $row_order['constructionyear'], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[carid]", $row_order['carid'], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[vin_html]", htmlentities($row_order['vin_html']), $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[kw]", $row_order['kw'], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[mileage]", number_format(intval($row_order['mileage']), 0, '', '.') . " km", $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[mechanism]", ($row_order['mechanism'] == 0 ? "Schaltung" : "Automatik"), $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[fuel]", ($row_order['fuel'] == 0 ? "Benzin" : "Diesel"), $row_template[$fields[$j]]);
			
					$row_template[$fields[$j]] = str_replace("[reason]", $row_order['reason'], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[description]", $row_order['description'], $row_template[$fields[$j]]);
			
				}
			
				mysqli_query($conn, "	INSERT 	`order_orders_statuses` 
										SET 	`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
												`order_orders_statuses`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "', 
												`order_orders_statuses`.`status_number`='" . mysqli_real_escape_string($conn, $status_number) . "', 
												`order_orders_statuses`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
												`order_orders_statuses`.`status_id`='" . mysqli_real_escape_string($conn, intval($row_status['id'])) . "', 
												`order_orders_statuses`.`template`='" . mysqli_real_escape_string($conn, $row_template['name']) . "', 
												`order_orders_statuses`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
												`order_orders_statuses`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
												`order_orders_statuses`.`public`='1', 
												`order_orders_statuses`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
			
				$_SESSION["status"]["id"] = $conn->insert_id;
			
				mysqli_query($conn, "	INSERT 	`order_orders_events` 
										SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
												`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
												`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "', 
												`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
												`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag bezahlt, ID [#" . $_SESSION["status"]["id"] . "]") . "', 
												`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
												`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
												`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
			
				$tracking_image = "<img src=\"" . $domain . "/email-logo/" . $_SESSION["admin"]["company_id"] . "/" . $row_order['order_number'] . "/" . $status_number . "\" width=\"0\" height=\"0\" border=\"0\" />\n";
			
				if($row_template['mail_with_pdf'] == 1){
			
					$filename = "begleitschein.pdf";
			
					$pdf = new Fpdi();
			
					$pdf->AddPage();
			
					require('includes/email_template_pdf_code_' . $row_template['id'] . '.php');
			
					$pdfdoc = $pdf->Output("", "S");
			
					if($row_status['usermail'] == 1 && $row_order['email'] != ""){
			
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
			
					if($row_status['usermail'] == 1 && $row_order['email'] != ""){
			
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
	
				echo "Der Auftrag wurde als bezahlt markiert.\n";
	
			}else{
	
				echo "Fehlerhafte Anfrage!\n";
	
			}
	
		}else{
	
			echo "Fehlerhafte Anfrage!\n";
	
		}

	}else{

		echo "Fehlerhafte Anfrage!\n";

	}

}else{

	header("HTTP/1.0 404 Not Found");

	echo "Fehlerhafte Anfrage!\n";

}

?>