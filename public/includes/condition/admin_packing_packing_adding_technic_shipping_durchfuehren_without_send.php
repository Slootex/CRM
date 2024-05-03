<?php 

	require_once('includes/class_dbbmailer.php');

	use setasign\Fpdi\Fpdi;

	require_once('includes/fpdf/fpdf.php');
	require_once('includes/fpdi/code39.php');
	require_once('includes/fpdi/autoload.php');

	$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

/*	$shipping_costs = array(
		0 =>  8.95,  // Expressversand
		1 =>  5.95,  // Standardversand
		2 =>  15.00, // International
		3 =>  0.00   // Abholung
	);
	
	$payment_costs = array(
		0 =>  0.00, // Überweisung
		1 =>  8.00, // Nachnahme
		2 =>  0.00  // Bar
	);
	
	$saturday_costs = array(
		0 =>  0.00, // Nein
		1 =>  8.30  // Ja
	);
	
	$carriers_services_costs = array(
		"011" =>  0.00, // UPS Standard
		"065" =>  0.00  // UPS Saver
	);

	$carriers_services = array(
		'011' => 'UPS Standard', 
		'065' => 'UPS Saver'
	);*/

	$row_packing1 = mysqli_fetch_array(mysqli_query($conn, "SELECT 	*, 
																	(SELECT `address_addresses`.`servicecode` AS aas FROM `address_addresses` WHERE `address_addresses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `address_addresses`.`id`=`packing_packings`.`address_id`) AS address_service, 
																	(SELECT `file_attachments`.`name` AS f1n FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`packing_packings`.`file1`) AS file1_name, 
																	(SELECT `file_attachments`.`file` AS f1f FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`packing_packings`.`file1`) AS file1_file, 
																	(SELECT `file_attachments`.`name` AS f2n FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`packing_packings`.`file2`) AS file2_name, 
																	(SELECT `file_attachments`.`file` AS f2f FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`packing_packings`.`file2`) AS file2_file 
															FROM 	`packing_packings` 
															WHERE 	`packing_packings`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['recipient'])) . "' 
															AND 	`packing_packings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

	$row_order = mysqli_fetch_array(mysqli_query($conn, "	SELECT 	* 
															FROM 	`order_orders` 
															WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($row_packing1['order_id'])) . "' 
															AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

	$status_field = "";

	if($row_order['mode'] < 2){

		$order_name = "Auftrag";

		$order_table = "order_orders";

		$order_id_field = "order_id";

		$status_field = $row_packing1['type'] == 3 ? "order_packing_user_status" : ($row_packing1['type'] == 4 ? "order_packing_technic_status" : "");

	}else{

		$order_name = "Interessent";

		$order_table = "interested_interesteds";

		$order_id_field = "interested_id";

		$status_field = $row_packing1['type'] == 3 ? "interested_packing_user_status" : ($row_packing1['type'] == 4 ? "interested_packing_technic_status" : "");

	}

	$radio_saturday = 0;

	$emsg_all_other = "";

	if($row_packing1['firstname'] == "" && $row_packing1['lastname'] == ""){
		$row_packing1['firstname'] = $row_packing1['companyname'];
	}

	if($emsg == ""){

		$time = time();

		$domain = isset($_SERVER['HTTPS']) ? "https://" . $_SERVER['HTTP_HOST'] : "http://" . $_SERVER['HTTP_HOST'];

		$row_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "'"), MYSQLI_ASSOC);
		$row_country_to = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . mysqli_real_escape_string($conn, intval($row_packing1['country'])) . "'"), MYSQLI_ASSOC);
		$row_country_from = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . mysqli_real_escape_string($conn, intval($maindata['country'])) . "'"), MYSQLI_ASSOC);

		$row_attachments1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`='" . mysqli_real_escape_string($conn, intval($row_packing1['file1'])) . "'"), MYSQLI_ASSOC);
		$row_attachments2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`='" . mysqli_real_escape_string($conn, intval($row_packing1['file2'])) . "'"), MYSQLI_ASSOC);

		$row_last_paying = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders_payings` WHERE `order_orders_payings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_payings`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' ORDER BY CAST(`order_orders_payings`.`time` AS UNSIGNED) DESC limit 0, 1"), MYSQLI_ASSOC);

		$saturday_delivery = array();

		$row_status = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`='" . mysqli_real_escape_string($conn, intval($maindata[$status_field])) . "'"), MYSQLI_ASSOC);
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
													AND 		`questions`.`parent_id`='" . intval($row_pq_1['id']) . "' 
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

		$fields = array('subject', 'body', 'admin_mail_subject');

		for($j = 0;$j < count($fields);$j++){

			$row_template[$fields[$j]] = str_replace("[status_id]", $status_number, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[status]", $row_status["name"], $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[label_url]", "<a href=\"" . strip_tags($response_label->LabelRecoveryResponse->LabelResults->LabelImage->URL) . "\" target=\"_blank\">öffnen</a>", $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[shipments_id]", "", $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[tracking_url]", "", $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[print_label]", "", $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[id]", $row_order['order_number'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[packing_id]", $row_packing1['packing_number'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[date]", date("d.m.Y (H:i)", $time), $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[from_companyname]", $maindata['company'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[from_firstname]", $maindata['firstname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[from_lastname]", $maindata['lastname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[from_street]", $maindata['street'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[from_streetno]", $maindata['streetno'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[from_zipcode]", $maindata['zipcode'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[from_city]", $maindata['city'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[from_country]", $row_from_country['name'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[from_phonenumber]", $maindata['phonenumber'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[from_mobilnumber]", $maindata['mobilnumber'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[from_email]", "<a href=\"mailto: " . $maindata['email'] . "\">" . $maindata['email'] . "</a>\n", $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[to_gender]", ($row_packing1['gender'] == 1 ? "Sehr geehrte Frau" : "Sehr geehrter Herr"), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[to_sexual]", ($row_packing1['gender'] == 1 ? "Frau" : "Herr"), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[to_companyname]", $row_packing1['companyname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[to_firstname]", $row_packing1['firstname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[to_lastname]", $row_packing1['lastname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[to_street]", $row_packing1['street'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[to_streetno]", $row_packing1['streetno'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[to_zipcode]", $row_packing1['zipcode'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[to_city]", $row_packing1['city'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[to_country]", $row_to_country['name'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[to_phonenumber]", $row_packing1['phonenumber'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[to_mobilnumber]", $row_packing1['mobilnumber'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[to_email]", "<a href=\"mailto: " . $row_packing1['email'] . "\">" . $row_packing1['email'] . "</a>\n", $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[machine]", strip_tags($row_order['machine']), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[model]", strip_tags($row_order['model']), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[constructionyear]", strip_tags($row_order['constructionyear']), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[carid]", strtoupper(strip_tags($row_order['carid'])), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[vin_html]", htmlentities($row_order['vin_html']), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[kw]", strip_tags($row_order['kw']), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[mileage]", number_format(intval($row_order['mileage']), 0, '', '.') . " km", $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[mechanism]", ($row_order['mechanism'] == 0 ? "Schaltung" : "Automatik"), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[fuel]", ($row_order['fuel'] == 0 ? "Benzin" : "Diesel"), $row_template[$fields[$j]]);

//					$row_template[$fields[$j]] = str_replace("[files]", $links, $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[companyname]", $row_packing1['companyname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[gender]", ($row_packing1['gender'] == 1 ? "Sehr geehrte Frau" : "Sehr geehrter Herr"), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[sexual]", ($row_packing1['gender'] == 1 ? "Frau" : "Herr"), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[firstname]", $row_packing1['firstname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[lastname]", $row_packing1['lastname'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[street]", $row_packing1['street'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[streetno]", $row_packing1['streetno'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[zipcode]", $row_packing1['zipcode'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[city]", $row_packing1['city'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[country]", $row_country_to['name'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[phonenumber]", $row_packing1['phonenumber'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[mobilnumber]", $row_packing1['mobilnumber'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[email]", "<a href=\"mailto: " . strip_tags($row_packing1['email']) . "\">" . strip_tags($row_packing1['email']) . "</a>\n", $row_template[$fields[$j]]);

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
			$radio_radio_shipping = array(	"65" => "UPS Saver", 
											"11" => "UPS Standard");
			$row_template[$fields[$j]] = str_replace("[radio_shipping]", $radio_radio_shipping[$row_packing1['radio_shipping']], $row_template[$fields[$j]]);
			$radio_radio_payment = array(	0 => "Überweisung (Sie überweisen den Rechnungsbetrag per Überweisung)", 
											1 => "Nachnahme", 
											2 => "Bar");
			$row_template[$fields[$j]] = str_replace("[radio_payment]", $radio_radio_payment[$row_packing1['radio_payment']], $row_template[$fields[$j]]);
			/*if($radio_payment == 1){
				$row_template[$fields[$j]] = str_replace("[amount]", "<strong><u>Kosten</u></strong> <br>Betrag: " . number_format(row_packing1['amount'], 2, ',', '') . " &euro;<br>Versand: " . number_format($shipping_costs[$row_last_paying['radio_shipping']], 2, ',', '') . " &euro;<br>Bezahlart: " . number_format($payment_costs[$row_last_paying['radio_payment']], 2, ',', '') . " &euro;<br>Samstagszuschlag: " . number_format($saturday_costs[$radio_saturday], 2, ',', '') . " &euro;" . ($carriers_services_costs[$row_packing1['carriers_service']] > 0 ? "<br>UPS-Service: " . number_format($carriers_services_costs[$row_packing1['carriers_service']], 2, ',', '') . " &euro;" : "") . "<br>Gesammt: <u>" . number_format(($row_packing1['amount'] + $saturday_costs[$radio_saturday] + $carriers_services_costs[$row_packing1['carriers_service']] + $shipping_costs[$row_last_paying['radio_shipping']] + $payment_costs[$row_last_paying['radio_payment']]), 2, ',', '') . "</u> &euro;<br>", $row_template[$fields[$j]]);
			}else{
				$row_template[$fields[$j]] = str_replace("[shipping_costs]", "<strong><u>Kosten</u></strong> <br>Versand: " . number_format($shipping_costs[$row_last_paying['radio_shipping']], 2, ',', '') . " &euro;<br>Bezahlart: " . number_format($payment_costs[$row_last_paying['radio_payment']], 2, ',', '') . " &euro;<br>Samstagszuschlag: " . number_format($saturday_costs[$radio_saturday], 2, ',', '') . " &euro;<br>Gesammt: <u>" . number_format(($row_packing1['amount'] + $saturday_costs[$radio_saturday] + $carriers_services_costs[$row_packing1['carriers_service']] + $shipping_costs[$row_last_paying['radio_shipping']] + $payment_costs[$row_last_paying['radio_payment']]), 2, ',', '') . "</u> &euro;<br>", $row_template[$fields[$j]]);
			}*/
			$radio_radio_saturday = array(	0 => "Nein", 
											1 => "Ja");
			$row_template[$fields[$j]] = str_replace("[radio_saturday]", "", $row_template[$fields[$j]]);

		}

		$result_packings = mysqli_query($conn, "	SELECT 		*, 
																(SELECT `countries`.`name` AS c_n FROM `countries` WHERE `countries`.`id`=`packing_packings`.`country`) AS country_name, 
																(SELECT `file_attachments`.`id` AS f1i FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`packing_packings`.`file1`) AS file1_id, 
																(SELECT `file_attachments`.`name` AS f1n FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`packing_packings`.`file1`) AS file1_name, 
																(SELECT `file_attachments`.`file` AS f1f FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`packing_packings`.`file1`) AS file1_file, 
																(SELECT `file_attachments`.`id` AS f2i FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`packing_packings`.`file2`) AS file2_id, 
																(SELECT `file_attachments`.`name` AS f2n FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`packing_packings`.`file2`) AS file2_name, 
																(SELECT `file_attachments`.`file` AS f2f FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`packing_packings`.`file2`) AS file2_file 
													FROM 		`packing_packings` 
													WHERE 		`packing_packings`.`address_id`='" . mysqli_real_escape_string($conn, intval($row_packing1['address_id'])) . "' 
													AND 		`packing_packings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
													AND 		`packing_packings`.`mode`='0' 
													AND 		`packing_packings`.`adding`='1' 
													AND 		`packing_packings`.`type`='4' 
													ORDER BY 	`packing_packings`.`packing_number` ASC");

		while($row_packing = $result_packings->fetch_array(MYSQLI_ASSOC)){

			$row_order = mysqli_fetch_array(mysqli_query($conn, "	SELECT 	* 
																	FROM 	`order_orders` 
																	WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($row_packing['order_id'])) . "' 
																	AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

			$status_field = "";

			if($row_order['mode'] < 2){

				$order_name = "Auftrag";

				$order_table = "order_orders";

				$order_id_field = "order_id";

			}else{

				$order_name = "Interessent";

				$order_table = "interested_interesteds";

				$order_id_field = "interested_id";

			}

			mysqli_query($conn, "	UPDATE 	`packing_packings` 
									SET 	`packing_packings`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`packing_packings`.`mode`='1', 
											`packing_packings`.`is_send`='1', 
											`packing_packings`.`shipments_id`='" . mysqli_real_escape_string($conn, strip_tags("")) . "', 
											`packing_packings`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
									WHERE 	`packing_packings`.`id`='" . mysqli_real_escape_string($conn, intval($row_packing['id'])) . "' 
									AND 	`packing_packings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

			mysqli_query($conn, "	INSERT 	`" . $order_table . "_statuses` 
									SET 	`" . $order_table . "_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
											`" . $order_table . "_statuses`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($row_packing['order_id'])) . "', 
											`" . $order_table . "_statuses`.`status_number`='" . mysqli_real_escape_string($conn, $status_number) . "', 
											`" . $order_table . "_statuses`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`" . $order_table . "_statuses`.`status_id`='" . mysqli_real_escape_string($conn, intval($row_status['id'])) . "', 
											`" . $order_table . "_statuses`.`template`='" . mysqli_real_escape_string($conn, $row_template['name']) . "', 
											`" . $order_table . "_statuses`.`subject`='" . mysqli_real_escape_string($conn, strip_tags($response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber)) . "', 
											`" . $order_table . "_statuses`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
											`" . $order_table . "_statuses`.`public`='1', 
											`" . $order_table . "_statuses`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

			$_SESSION["status"]["id"] = $conn->insert_id;

			$devices = "";

			$result = mysqli_query($conn, "	SELECT 		`order_orders_devices`.`id` AS id, 
														`order_orders_devices`.`device_number` AS device_number, 
														`order_orders_devices`.`atot_mode` AS atot_mode, 
														`order_orders_devices`.`at` AS at, 
														`order_orders_devices`.`ot` AS ot, 
														(SELECT `storage_places`.`name` AS s_s_name FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`=`order_orders_devices`.`storage_space_id`) AS storage_space, 
														`order_orders_devices`.`storage_space_id` AS storage_space_id 
											FROM 		`order_orders_devices` `order_orders_devices` 
											WHERE 		`order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_packing['order_id'])) . "' 
											AND 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
											AND 		`order_orders_devices`.`is_storage`='0' 
											AND 		`order_orders_devices`.`is_shopin_relocate`='0' 
											AND 		`order_orders_devices`.`is_labeling`='0' 
											AND 		`order_orders_devices`.`is_photo`='0' 
											AND 		`order_orders_devices`.`is_relocate`='0' 
											ORDER BY 	`order_orders_devices`.`device_number` ASC");

			while($row_device = $result->fetch_array(MYSQLI_ASSOC)){

				if(isset($_POST['device_' . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : ""))]) && intval($_POST['device_' . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : ""))]) == 1){

					$devices .= $devices == "" ? $row_device['id'] . ":" . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) : "," . $row_device['id'] . ":" . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : ""));

					if($row_device['storage_space_id'] > 0){
						mysqli_query($conn, "UPDATE `storage_places` SET `storage_places`.`used`=`storage_places`.`used`-1 WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['storage_space_id'])) . "'");
						mysqli_query($conn, "	INSERT 	`order_orders_events` 
												SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
														`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
														`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_packing['order_id'])) . "', 
														`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
														`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . ", Daten geändert, Lagerplatz " . $row_device['storage_space'] . " entfernt, ID [#" . intval($_POST["id"]) . "]") . "', 
														`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . ", Daten geändert, Lagerplatz " . $row_device['storage_space'] . " entfernt, ID [#" . intval($_POST["id"]) . "]") . "', 
														`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
														`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
						mysqli_query($conn, "	INSERT 	`order_orders_devices_events` 
												SET 	`order_orders_devices_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
														`order_orders_devices_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
														`order_orders_devices_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_packing['order_id'])) . "', 
														`order_orders_devices_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
														`order_orders_devices_events`.`message`='" . mysqli_real_escape_string($conn, "<span class=\"badge badge-danger\">Gerät " . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . ", Lagerplatz " . $row_device['storage_space'] . " entfernt, ID [#" . $row_device['id'] . "]</span>") . "', 
														`order_orders_devices_events`.`subject`='', 
														`order_orders_devices_events`.`body`='', 
														`order_orders_devices_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

						mysqli_query($conn, "	UPDATE 	`order_orders_devices` 
												SET 	`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
														`order_orders_devices`.`storage_space_id`='0', 
														`order_orders_devices`.`storage_space_owner`='0', 
														`order_orders_devices`.`storage_space_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
														`order_orders_devices`.`is_shipping_user`='0', 
														`order_orders_devices`.`is_shipping_technic`='0', 
														`order_orders_devices`.`is_shipping_extern`='0', 
														`order_orders_devices`.`is_send`='1', 
														`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
												WHERE 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['id'])) . "' 
												AND 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");
					}

				}

			}

			$items = "";

			$arr_order_extended_items = explode("\r\n", $maindata['order_extended_items']);

			if($maindata['order_extended_items'] != ""){

				for($item = 0;$item < count($arr_order_extended_items);$item++){

					$arr_item = explode("|", $arr_order_extended_items[$item]);

					if($arr_item[2] == 1 && isset($_POST['device_' . strtoupper($arr_item[0])]) && intval($_POST['device_' . strtoupper($arr_item[0])]) > 0){

						$items .= $items == "" ? $arr_item[0] . ":" . $arr_item[1] : "," . $arr_item[0] . ":" . $arr_item[1];

					}

				}

			}

			mysqli_query($conn, "	INSERT 	`order_orders_shipments` 
									SET 	`order_orders_shipments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
											`order_orders_shipments`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`order_orders_shipments`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_packing['order_id'])) . "', 
											`order_orders_shipments`.`status_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["status"]["id"])) . "', 
											`order_orders_shipments`.`devices`='" . mysqli_real_escape_string($conn, strip_tags($devices)) . "', 
											`order_orders_shipments`.`file1`='" . mysqli_real_escape_string($conn, intval(isset($_POST['device_BPZ-MSG']) && intval($_POST['device_BPZ-MSG']) > 0 ? $_POST['device_BPZ-MSG'] : 0)) . "', 
											`order_orders_shipments`.`file2`='" . mysqli_real_escape_string($conn, intval(isset($_POST['device_BPZ-HIN']) && intval($_POST['device_BPZ-HIN']) > 0 ? $_POST['device_BPZ-HIN'] : 0)) . "', 
											`order_orders_shipments`.`items`='" . mysqli_real_escape_string($conn, strip_tags($items)) . "', 
											`order_orders_shipments`.`shipments_id`='" . mysqli_real_escape_string($conn, strip_tags("")) . "', 
											`order_orders_shipments`.`carrier_tracking_no`='" . mysqli_real_escape_string($conn, strip_tags("")) . "', 
											`order_orders_shipments`.`label_url`='" . mysqli_real_escape_string($conn, strip_tags("")) . "', 
											`order_orders_shipments`.`graphic_image_jpeg`='" . mysqli_real_escape_string($conn, strip_tags("")) . "', 
											`order_orders_shipments`.`graphic_image_gif`='" . mysqli_real_escape_string($conn, strip_tags("")) . "', 
											`order_orders_shipments`.`price`='" . mysqli_real_escape_string($conn, ($row_packing['id'] == intval($_POST['recipient']) ? $row_packing1['amount'] : 0.00)) . "', 
											`order_orders_shipments`.`total_charges_with_taxes`='" . mysqli_real_escape_string($conn, 0) . "', 
											`order_orders_shipments`.`carrier`='UPS', 
											`order_orders_shipments`.`service`='" . mysqli_real_escape_string($conn, $row_packing1['address_service']) . "', 
											`order_orders_shipments`.`reference_number`='" . mysqli_real_escape_string($conn, $row_packing1['packing_number'] . "-" . $row_order['order_number']) . "', 
											`order_orders_shipments`.`notification_email`='" . mysqli_real_escape_string($conn, $maindata['email']) . "', 
											`order_orders_shipments`.`component`='0', 
											`order_orders_shipments`.`companyname`='" . mysqli_real_escape_string($conn, $row_packing1['companyname']) . "', 
											`order_orders_shipments`.`firstname`='" . mysqli_real_escape_string($conn, $row_packing1['firstname']) . "', 
											`order_orders_shipments`.`lastname`='" . mysqli_real_escape_string($conn, $row_packing1['lastname']) . "', 
											`order_orders_shipments`.`street`='" . mysqli_real_escape_string($conn, $row_packing1['street']) . "', 
											`order_orders_shipments`.`streetno`='" . mysqli_real_escape_string($conn, $row_packing1['streetno']) . "', 
											`order_orders_shipments`.`zipcode`='" . mysqli_real_escape_string($conn, $row_packing1['zipcode']) . "', 
											`order_orders_shipments`.`city`='" . mysqli_real_escape_string($conn, $row_packing1['city']) . "', 
											`order_orders_shipments`.`country`='" . mysqli_real_escape_string($conn, $row_packing1['country']) . "', 
											`order_orders_shipments`.`weight`='" . mysqli_real_escape_string($conn, $row_packing1['weight']) . "', 
											`order_orders_shipments`.`length`='" . mysqli_real_escape_string($conn, $row_packing1['length']) . "', 
											`order_orders_shipments`.`width`='" . mysqli_real_escape_string($conn, $row_packing1['width']) . "', 
											`order_orders_shipments`.`height`='" . mysqli_real_escape_string($conn, $row_packing1['height']) . "', 
											`order_orders_shipments`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

			$_SESSION["shipments"]["id"] = $conn->insert_id;

			mysqli_query($conn, "	INSERT 	`" . $order_table . "_events` 
									SET 	`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
											`" . $order_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`" . $order_table . "_events`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($row_packing['order_id'])) . "', 
											`" . $order_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
											`" . $order_table . "_events`.`message`='" . mysqli_real_escape_string($conn, $order_name . ", Sendung (Multi) durchgeführt, ID [#" . $_SESSION["shipments"]["id"]) . "]', 
											`" . $order_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

			mysqli_query($conn, "	INSERT 	`" . $order_table . "_history` 
									SET 	`" . $order_table . "_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
											`" . $order_table . "_history`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`" . $order_table . "_history`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($row_packing['order_id'])) . "', 
											`" . $order_table . "_history`.`message`='" . mysqli_real_escape_string($conn, $row_status['name'] . " - Die (Multi) Sendung " . strip_tags($response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber) . " wurde an den Kunden versendet.") . "', 
											`" . $order_table . "_history`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

			$_SESSION["history"]["id"] = $conn->insert_id;

			mysqli_query($conn, "	INSERT 	`" . $order_table . "_events` 
									SET 	`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
											`" . $order_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`" . $order_table . "_events`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($row_packing['order_id'])) . "', 
											`" . $order_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
											`" . $order_table . "_events`.`message`='" . mysqli_real_escape_string($conn, $order_name . "-Auftragshistory, Nachricht erstellt, ID [#" . $_SESSION["history"]["id"] . "]") . "', 
											`" . $order_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, $order_name . "-Auftragshistory, Nachricht erstellt, ID [#" . $_SESSION["history"]["id"] . "]") . "', 
											`" . $order_table . "_events`.`body`='" . mysqli_real_escape_string($conn, $row_status['name']) . "', 
											`" . $order_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		}

		$tracking_image = "<img src=\"" . $domain . "/email-logo/" . $_SESSION["admin"]["company_id"] . "/" . $row_order['order_number'] . "/" . $status_number . "\" width=\"0\" height=\"0\" border=\"0\" />\n";

		if($row_template['mail_with_pdf'] == 1){

			$filename = "begleitschein.pdf";

			$pdf = new Fpdi();

			$pdf->AddPage();

			require('includes/email_template_pdf_code_' . $row_template['id'] . '.php');

			$pdfdoc = $pdf->Output("", "S");

			if($row_status['usermail'] == 1 && $row_packing1['email'] != ""){

				$mail = new dbbMailer();

				$mail->host = $maindata['smtp_host'];
				$mail->username = $maindata['smtp_username'];
				$mail->password = $maindata['smtp_password'];
				$mail->secure = $maindata['smtp_secure'];
				$mail->port = intval($maindata['smtp_port']);
				$mail->charset = $maindata['smtp_charset'];

				$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
				$mail->addAddress($row_packing1['email'], $row_packing1['firstname'] . " " . $row_packing1['lastname']);

				//$mail->addAttachment(dirname(__FILE__) . "/../../temp/condition.tar");

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

				//$mail->addAttachment(dirname(__FILE__) . "/../../temp/condition.tar");

				$mail->addStringAttachment($pdfdoc, $filename, 'base64', 'application/pdf');

				$mail->subject = strip_tags($row_template['admin_mail_subject']);

				$mail->body = str_replace("[track]", "", $row_template['body']);

				if(!$mail->send()){

				}

			}

		}else{

			if($row_status['usermail'] == 1 && $row_packing1['email'] != ""){

				$mail = new dbbMailer();

				$mail->host = $maindata['smtp_host'];
				$mail->username = $maindata['smtp_username'];
				$mail->password = $maindata['smtp_password'];
				$mail->secure = $maindata['smtp_secure'];
				$mail->port = intval($maindata['smtp_port']);
				$mail->charset = $maindata['smtp_charset'];
 
				$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
				$mail->addAddress($row_packing1['email'], $row_packing1['firstname'] . " " . $row_packing1['lastname']);

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

		$html_new_shipping_result = 	"					<div class=\"form-group row\">\n" . 
										"						<div class=\"col-12 text-center\">\n" . 
										"							<h2 class=\"text-success\">\n" . 
										" 								Durchgeführt ohne Versandschein...\n" . 
										"							</h2>\n" . 
										"						</div>\n" . 
										"					</div>\n";

		$html_new_shipping_result = $html_new_shipping_result != "" ? "<div class=\"row\"><div class=\"col-sm-6 text-center\">" . $html_new_shipping_result . "</div></div>\n" : $html_new_shipping_result;

	}

//	$_POST['id'] = 0;

	$_POST['pack_adding_technic_shipping'] = "bearbeiten";

?>