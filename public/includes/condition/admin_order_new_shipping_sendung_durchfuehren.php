<?php 

	require_once('includes/class_dbbmailer.php');

	use setasign\Fpdi\Fpdi;

	require_once('includes/fpdf/fpdf.php');
	require_once('includes/fpdi/code39.php');
	require_once('includes/fpdi/autoload.php');

	$shipping_costs = array(
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
		11 =>  0.00, // UPS Standard
		65 =>  0.00  // UPS Saver
	);

	$carriers_services = array(
		'11' => 'UPS Standard', 
		'65' => 'UPS Saver'
	);

	$_POST['edit'] = "bearbeiten";

	$emsg_all_other = "";

	if(strlen($_POST['carriers_service']) > 2){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie ein Service aus.</small><br />\n";
		$inp_carriers_service = " is-invalid";
		$emsg_all_other = "Error";
	} else {
		$carriers_service = strip_tags($_POST['carriers_service']);
	}

	if(isset($_POST['radio_payment']) && strlen($_POST['radio_payment']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie eine Versandart aus.</small><br />\n";
		$inp_radio_payment = " is-invalid";
		$emsg_all_other = "Error";
	} else {
		$radio_payment = isset($_POST['radio_payment']) ? intval($_POST['radio_payment']) : 0;
	}

	if(strlen($_POST['amount']) > 13){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Betrag an.</small><br />\n";
		$inp_amount = " is-invalid";
		$emsg_all_other = "Error";
	} else {
		$amount = number_format(str_replace(",", ".", $_POST['amount']), 2, '.', '');
	}

	if(isset($_POST['radio_saturday']) && strlen($_POST['radio_saturday']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie aus ob ein Samstagszuschlag besteht.</small><br />\n";
		$inp_radio_saturday = " is-invalid";
		$emsg_all_other = "Error";
	} else {
		$radio_saturday = isset($_POST['radio_saturday']) ? intval($_POST['radio_saturday']) : 0;
	}

	if(strlen($_POST['from_companyname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Absender-Firmenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_from_companyname = " is-invalid";
		$emsg_all_other = "Error";
	} else {
		$from_companyname = strip_tags($_POST['from_companyname']);
	}

	if(strlen($_POST['from_firstname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Absender-Vorname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_from_firstname = " is-invalid";
		$emsg_all_other = "Error";
	} else {
		$from_firstname = strip_tags($_POST['from_firstname']);
	}

	if(strlen($_POST['from_lastname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Absender-Nachname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_from_lastname = " is-invalid";
		$emsg_all_other = "Error";
	} else {
		$from_lastname = strip_tags($_POST['from_lastname']);
	}

	if(strlen($_POST['from_street']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Absender-Straßenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_from_street = " is-invalid";
		$emsg_all_other = "Error";
	} else {
		$from_street = strip_tags($_POST['from_street']);
	}

	if(strlen($_POST['from_streetno']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Absender-Hausnummer ein. (max. 10 Zeichen)</small><br />\n";
		$inp_from_streetno = " is-invalid";
		$emsg_all_other = "Error";
	} else {
		$from_streetno = strip_tags($_POST['from_streetno']);
	}

	if(strlen($_POST['from_zipcode']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Absender-Postleitzahl ein. (max. 10 Zeichen)</small><br />\n";
		$inp_from_zipcode = " is-invalid";
		$emsg_all_other = "Error";
	} else {
		$from_zipcode = strip_tags($_POST['from_zipcode']);
	}

	if(strlen($_POST['from_city']) > 128){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Absender-Ort ein. (max. 128 Zeichen)</small><br />\n";
		$inp_from_city = " is-invalid";
		$emsg_all_other = "Error";
	} else {
		$from_city = strip_tags($_POST['from_city']);
	}

	if(strlen($_POST['from_country']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie das Absender-Land ein. (max. 11 Zeichen)</small><br />\n";
		$inp_from_country = " is-invalid";
		$emsg_all_other = "Error";
	} else {
		$from_country = intval($_POST['from_country']);
	}

	if($_POST['from_email'] == "" || preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,26})$/", $_POST['from_email'])){
		$from_email = strip_tags($_POST['from_email']);
	} else {
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Absender-E-Mail-Adresse ein.</small><br />\n";
		$inp_from_email = " is-invalid";
		$emsg_all_other = "Error";
	}

	if(strlen($_POST['from_mobilnumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Absender-Mobilnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_from_mobilnumber = " is-invalid";
		$emsg_all_other = "Error";
	} else {
		$from_mobilnumber = strip_tags($_POST['from_mobilnumber']);
	}

	if(strlen($_POST['from_phonenumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Absender-Telefonnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_from_phonenumber = " is-invalid";
		$emsg_all_other = "Error";
	} else {
		$from_phonenumber = strip_tags($_POST['from_phonenumber']);
	}

	if(isset($_POST['admin_mail']) && strlen($_POST['admin_mail']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie aus ob eine Admin-E-Mail versendet werden soll.</small><br />\n";
		$inp_admin_mail = " is-invalid";
		$emsg_all_other = "Error";
	} else {
		$admin_mail = isset($_POST['admin_mail']) ? intval($_POST['admin_mail']) : 0;
	}

	if(isset($_POST['mail_with_pdf']) && strlen($_POST['mail_with_pdf']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie aus ob ein Begleitschein beigefügt werden soll.</small><br />\n";
		$inp_mail_with_pdf = " is-invalid";
		$emsg_all_other = "Error";
	} else {
		$mail_with_pdf = isset($_POST['mail_with_pdf']) ? intval($_POST['mail_with_pdf']) : 0;
	}

	if(strlen($_POST['package_template']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie eine Paketvorlage aus.</small><br />\n";
		$inp_package_template = " is-invalid";
		$emsg_all_other = "Error";
	} else {
		$package_template = intval($_POST['package_template']);
	}

	if(strlen($_POST['length']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Paketlänge ein.</small><br />\n";
		$inp_length = " is-invalid";
		$emsg_all_other = "Error";
	} else {
		$length = intval($_POST['length']);
	}

	if(strlen($_POST['width']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Paketbreite ein.</small><br />\n";
		$inp_width = " is-invalid";
		$emsg_all_other = "Error";
	} else {
		$width = intval($_POST['width']);
	}

	if(strlen($_POST['height']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Pakethöhe ein.</small><br />\n";
		$inp_height = " is-invalid";
		$emsg_all_other = "Error";
	} else {
		$height = intval($_POST['height']);
	}

	if(strlen($_POST['weight']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie das Paketgewicht ein.</small><br />\n";
		$inp_weight = " is-invalid";
		$emsg_all_other = "Error";
	} else {
		$weight = floatval(str_replace(",", ".", $_POST['weight']));
	}

	if(strlen($_POST['ref_number']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Referenznummer ein. (max. 256 Zeichen)</small><br />\n";
		$inp_ref_number = " is-invalid";
		$emsg_all_other = "Error";
	} else {
		$ref_number = strip_tags($_POST['ref_number']);
	}

	if(strlen($_POST['to_companyname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Empfänger-Firmenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_to_companyname = " is-invalid";
		$emsg_all_other = "Error";
	} else {
		$to_companyname = strip_tags($_POST['to_companyname']);
	}

	if(strlen($_POST['to_firstname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Empfänger-Vorname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_to_firstname = " is-invalid";
	} else {
		$to_firstname = strip_tags($_POST['to_firstname']);
	}

	if(strlen($_POST['to_lastname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Empfänger-Nachname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_to_lastname = " is-invalid";
	} else {
		$to_lastname = strip_tags($_POST['to_lastname']);
	}

	if(strlen($_POST['to_street']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Empfänger-Straßenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_to_street = " is-invalid";
		$emsg_all_other = "Error";
	} else {
		$to_street = strip_tags($_POST['to_street']);
	}

	if(strlen($_POST['to_streetno']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Empfänger-Hausnummer ein. (max. 10 Zeichen)</small><br />\n";
		$inp_to_streetno = " is-invalid";
		$emsg_all_other = "Error";
	} else {
		$to_streetno = strip_tags($_POST['to_streetno']);
	}

	if(strlen($_POST['to_zipcode']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Empfänger-Postleitzahl ein. (max. 10 Zeichen)</small><br />\n";
		$inp_to_zipcode = " is-invalid";
		$emsg_all_other = "Error";
	} else {
		$to_zipcode = strip_tags($_POST['to_zipcode']);
	}

	if(strlen($_POST['to_city']) > 128){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Empfänger-Ort ein. (max. 128 Zeichen)</small><br />\n";
		$inp_to_city = " is-invalid";
		$emsg_all_other = "Error";
	} else {
		$to_city = strip_tags($_POST['to_city']);
	}

	if(strlen($_POST['to_country']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie das Empfänger-Land ein. (max. 11 Zeichen)</small><br />\n";
		$inp_to_country = " is-invalid";
		$emsg_all_other = "Error";
	} else {
		$to_country = intval($_POST['to_country']);
	}

	if($_POST['to_email'] == "" || preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,26})$/", $_POST['to_email'])){
		$to_email = strip_tags($_POST['to_email']);
	} else {
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Empfänger-E-Mail-Adresse ein.</small><br />\n";
		$inp_to_email = " is-invalid";
		$emsg_all_other = "Error";
	}

	if(strlen($_POST['to_mobilnumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Empfänger-Mobilnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_to_mobilnumber = " is-invalid";
		$emsg_all_other = "Error";
	} else {
		$to_mobilnumber = strip_tags($_POST['to_mobilnumber']);
	}

	if(strlen($_POST['to_phonenumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Empfänger-Telefonnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_to_phonenumber = " is-invalid";
		$emsg_all_other = "Error";
	} else {
		$to_phonenumber = strip_tags($_POST['to_phonenumber']);
	}

	if($emsg_all_other == "" && $to_firstname == "" && $to_lastname == ""){
		$to_firstname = $to_companyname;
		$emsg = "";
	}

	if($emsg == ""){

		$time = time();

		$domain = isset($_SERVER['HTTPS']) ? "https://" . $_SERVER['HTTP_HOST'] : "http://" . $_SERVER['HTTP_HOST'];

		$row_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "'"), MYSQLI_ASSOC);
		$row_country_to = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . mysqli_real_escape_string($conn, intval($to_country)) . "'"), MYSQLI_ASSOC);
		$row_country_from = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . mysqli_real_escape_string($conn, intval($from_country)) . "'"), MYSQLI_ASSOC);
		$row_reason = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `reasons` WHERE `reasons`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `reasons`.`id`='" . mysqli_real_escape_string($conn, intval($row_order['component'])) . "'"), MYSQLI_ASSOC);

		$row_attachments_matrix = mysqli_fetch_array(mysqli_query($conn, "	SELECT 		`attachments_matrix`.`id` AS id, 
																						`attachments_matrix`.`pos` AS pos, 
																						`attachments_matrix`.`file1` AS file1, 
																						`attachments_matrix`.`file2` AS file2, 
																						(SELECT `file_attachments`.`name` AS name FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`attachments_matrix`.`file1`) AS file1_name, 
																						(SELECT `file_attachments`.`file` AS file1 FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`attachments_matrix`.`file1`) AS file1_file, 
																						(SELECT `file_attachments`.`name` AS name FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`attachments_matrix`.`file2`) AS file2_name, 
																						(SELECT `file_attachments`.`file` AS file2 FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`attachments_matrix`.`file2`) AS file2_file 
								
																			FROM 		`attachments_matrix` 
																			WHERE 		`attachments_matrix`.`component`='" . mysqli_real_escape_string($conn, intval($row_order['component'])) . "' 
																			AND 		`attachments_matrix`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																			AND 		`attachments_matrix`.`text_module`='" . mysqli_real_escape_string($conn, intval($row_order['intern_text_module'])) . "'"), MYSQLI_ASSOC);

		$row_last_paying = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders_payings` WHERE `order_orders_payings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_payings`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' ORDER BY CAST(`order_orders_payings`.`time` AS UNSIGNED) DESC limit 0, 1"), MYSQLI_ASSOC);

		$saturday_delivery = array();

		if($carriers_service == "65" && $radio_saturday == 1){
			$saturday_delivery['SaturdayDeliveryIndicator'] = array('SATURDAY_DELIVERY');
		}

		if($radio_payment == 1){
			$saturday_delivery['COD'] = array(
				'CODFundsCode' => '1', 
				'CODAmount' => array(
					'CurrencyCode' => 'EUR', 
					'MonetaryValue' => '' . ($amount + $saturday_costs[$radio_saturday] + $carriers_services_costs[$carriers_service] + $shipping_costs[$row_last_paying['radio_shipping']] + $payment_costs[$row_last_paying['radio_payment']])
				)
			);
		}

		$data = array(
			'ShipmentRequest' => array(
				'Shipment' => array(
					'Description' => $ref_number, 
					'ShipmentServiceOptions' => $saturday_delivery, 
					'Shipper' => array(
						'Name' => $from_firstname . ' ' . $from_lastname, 
						'AttentionName' => $from_companyname, 
						'TaxIdentificationNumber' => '456999', 
						'Phone' => array(
							'Number' => $maindata['phonenumber']
						), 
						'ShipperNumber' => $maindata['ups_customer_number'], 
						'Address' => array(
							'AddressLine' => $from_street . ' ' . $from_streetno, 
							'City' => $from_city, 
							'StateProvinceCode' => '', 
							'PostalCode' => $from_zipcode, 
							'CountryCode' => $row_country_from['code']
						)
					), 
					'ShipTo' => array(
						'Name' => substr($to_firstname . ' ' . $to_lastname, 0, 34), 
						'AttentionName' => ($to_companyname != "" ? $to_companyname : "keine"), 
						'FaxNumber' => '', 
						'TaxIdentificationNumber' => '456999', 
						'Address' => array(
							'AddressLine' => $to_street . ' ' . $to_streetno, 
							'City' => $to_city, 
							'StateProvinceCode' => '', 
							'PostalCode' => $to_zipcode, 
							'CountryCode' => $row_country_to['code']
						)
					), 
					'ShipFrom' => array(
						'Name' => $from_firstname . ' ' . $from_lastname, 
						'AttentionName' => $from_companyname, 
						'Phone' => array(
							'Number' => $maindata['phonenumber']
						), 
						'FaxNumber' => '', 
						'TaxIdentificationNumber' => '456999', 
						'Address' => array(
							'AddressLine' => $from_street . ' ' . $from_streetno, 
							'City' => $from_city, 
							'StateProvinceCode' => '', 
							'PostalCode' => $from_zipcode, 
							'CountryCode' => $row_country_from['code']
						)
					), 
					'PaymentInformation' => array(
						'ShipmentCharge' => array(
							'Type' => '01', 
							'BillShipper' => array(
								'AccountNumber' => $maindata['ups_customer_number']
							)
						)
					), 
					'Service' => array(
						'Code' => $carriers_service, 
						'Description' => $carriers_services[$carriers_service]
					), 
					'Package' => array(
						array(
							'Description' => 'International Goods', 
							'ReferenceNumber' => array(
								'Value' => $ref_number, 
							),
							'Packaging' => array(
								'Code' => '02'
							), 
							'Dimensions' => array(
								'UnitOfMeasurement' => array(
									'Code' => 'CM', 
									'Description' => 'Zentimeter'
								), 
								'Length' => '' . $length, 
								'Width' => '' . $width, 
								'Height' => '' . $height
							), 
							'PackageWeight' => array(
								'UnitOfMeasurement' => array(
									'Code' => 'KGS'
								), 
								'Weight' => '' . floatval($weight)
							), 
							'PackageServiceOptions' => ''
						)
	// ...
					), 
					'ItemizedChargesRequestedIndicator' => '', 
					'RatingMethodRequestedIndicator' => '', 
					'TaxInformationIndicator' => '', 
					'ShipmentRatingOptions' => array(
						'NegotiatedRatesIndicator' => ''
					)
				), 
				'LabelSpecification' => array(
					'LabelImageFormat' => array(
						'Code' => 'GIF'
					)
				)
			)
		);

		$from_phonenumber1 = $from_mobilnumber != "" ? $from_mobilnumber : $from_phonenumber;

		if($from_phonenumber1 != ""){
			$data['ShipmentRequest']['Shipment']['Shipper']['Phone'] = array('Number' => $from_phonenumber1);
			$data['ShipmentRequest']['Shipment']['ShipFrom']['Phone'] = array('Number' => $from_phonenumber1);
		}

		$to_phonenumber1 = $to_mobilnumber != "" ? $to_mobilnumber : $to_phonenumber;

		if($to_phonenumber1 != ""){
			$data['ShipmentRequest']['Shipment']['ShipTo']['Phone'] = array('Number' => $to_phonenumber1);
		}

		$data_string = json_encode($data, JSON_UNESCAPED_UNICODE);

		$ch = curl_init($maindata['ups_url'] . '/ship/v1/shipments?additionaladdressvalidation=city');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'AccessLicenseNumber: ' . $maindata['ups_access_license_number'],
				'Password: ' . $maindata['ups_password'],
				'Content-Type: application/json',
				'transId: ' . $row_order['order_number'] . $time,
				'transactionSrc: ' . $domain,
				'Username: ' . $maindata['ups_username'],
				'Accept: application/json',
				'Content-Length: ' . strlen($data_string)
			)
		);

		$result = curl_exec($ch);

		$response = json_decode($result);

		sleep($maindata['sleep_shipping_label']);

		if(!isset($response->response->errors[0])){

			$data = array(
				'LabelRecoveryRequest' => array(
					'LabelSpecification' => array(
						'HTTPUserAgent' => strip_tags($_SERVER['HTTP_USER_AGENT']), 
						'LabelImageFormat' => array(
							'Code' => 'GIF'
						), 
		/*					'LabelStockSize' => array(
							'Height' => '6', 
							'Width' => '4'
						)*/
					), 
					'Translate' => array(
						'LanguageCode' => 'deu', 
						'DialectCode' => '97', 
						'Code' => '01'
					), 
					'LabelDelivery' => array(
						'LabelLinkIndicator' => '', 
						'ResendEMailIndicator' => '', 
						'EMailMessage' => array(
							'EMailAddress' => $from_email
						)
					), 
					'TrackingNumber' => $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber . ''
				)
			);

			$data_string = json_encode($data, JSON_UNESCAPED_UNICODE);

			$ch = curl_init($maindata['ups_url'] . '/ship/v1/shipments/labels');
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
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

			$response_label = json_decode($result);

			if(!isset($response_label->response->errors[0])){

				$row_status = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`='" . mysqli_real_escape_string($conn, intval($maindata[$parameter['shipping_status']])) . "'"), MYSQLI_ASSOC);
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

					$row_template[$fields[$j]] = str_replace("[shipments_id]", strip_tags($response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber), $row_template[$fields[$j]]);

					$row_template[$fields[$j]] = str_replace("[tracking_url]", "<a href=\"https://www.ups.com/WebTracking/processInputRequest?tracknum=" . strip_tags($response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber) . "&loc=de_DE\" target=\"_blank\">öffnen</a>", $row_template[$fields[$j]]);

					$row_template[$fields[$j]] = str_replace("[print_label]", "<a href=\"" . $domain . "/versendung/label/" . intval($_SESSION["admin"]["company_id"]) . "/" . strip_tags($response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber) . "\" target=\"_blank\">öffnen</a>", $row_template[$fields[$j]]);

					$row_template[$fields[$j]] = str_replace("[id]", $row_order['order_number'], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[date]", date("d.m.Y (H:i)", $time), $row_template[$fields[$j]]);

					$row_template[$fields[$j]] = str_replace("[from_companyname]", $from_companyname, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[from_firstname]", $from_firstname, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[from_lastname]", $from_lastname, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[from_street]", $from_street, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[from_streetno]", $from_streetno, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[from_zipcode]", $from_zipcode, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[from_city]", $from_city, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[from_country]", $row_from_country['name'], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[from_phonenumber]", $maindata['phonenumber'], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[from_mobilnumber]", $maindata['mobilnumber'], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[from_email]", "<a href=\"mailto: " . $from_email . "\">" . $from_email . "</a>\n", $row_template[$fields[$j]]);

					$row_template[$fields[$j]] = str_replace("[to_gender]", ($row_order['gender'] == 1 ? "Sehr geehrte Frau" : "Sehr geehrter Herr"), $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[to_sexual]", ($row_order['gender'] == 1 ? "Frau" : "Herr"), $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[to_companyname]", $to_companyname, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[to_firstname]", $to_firstname, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[to_lastname]", $to_lastname, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[to_street]", $to_street, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[to_streetno]", $to_streetno, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[to_zipcode]", $to_zipcode, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[to_city]", $to_city, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[to_country]", $row_to_country['name'], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[to_phonenumber]", $row_order['phonenumber'], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[to_mobilnumber]", $row_order['mobilnumber'], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[to_email]", "<a href=\"mailto: " . $row_order['email'] . "\">" . $row_order['email'] . "</a>\n", $row_template[$fields[$j]]);

					$row_template[$fields[$j]] = str_replace("[machine]", strip_tags($row_order['machine']), $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[model]", strip_tags($row_order['model']), $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[constructionyear]", strip_tags($row_order['constructionyear']), $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[carid]", strtoupper(strip_tags($row_order['carid'])), $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[vin_html]", htmlentities($row_order['vin_html']), $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[kw]", strip_tags($row_order['kw']), $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[mileage]", number_format(intval($row_order['mileage']), 0, '', '.') . " km", $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[mechanism]", ($row_order['mechanism'] == 0 ? "Schaltung" : "Automatik"), $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[fuel]", ($row_order['fuel'] == 0 ? "Benzin" : "Diesel"), $row_template[$fields[$j]]);

					//$row_template[$fields[$j]] = str_replace("[files]", $links, $row_template[$fields[$j]]);

					$row_template[$fields[$j]] = str_replace("[companyname]", $to_companyname, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[gender]", ($row_order['gender'] == 1 ? "Sehr geehrte Frau" : "Sehr geehrter Herr"), $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[sexual]", ($row_order['gender'] == 1 ? "Frau" : "Herr"), $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[firstname]", $to_firstname, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[lastname]", $to_lastname, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[street]", $to_street, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[streetno]", $to_streetno, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[zipcode]", $to_zipcode, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[city]", $to_city, $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[country]", $row_country_to['name'], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[phonenumber]", $row_order['phonenumber'], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[mobilnumber]", $row_order['mobilnumber'], $row_template[$fields[$j]]);
					$row_template[$fields[$j]] = str_replace("[email]", "<a href=\"mailto: " . strip_tags($row_order['email']) . "\">" . strip_tags($row_order['email']) . "</a>\n", $row_template[$fields[$j]]);

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
					$row_template[$fields[$j]] = str_replace("[radio_shipping]", $radio_radio_shipping[$row_order['radio_shipping']], $row_template[$fields[$j]]);
					$radio_radio_payment = array(	0 => "Überweisung (Sie überweisen den Rechnungsbetrag per Überweisung)", 
													1 => "Nachnahme", 
													2 => "Bar");
					$row_template[$fields[$j]] = str_replace("[radio_payment]", $radio_radio_payment[$radio_payment], $row_template[$fields[$j]]);
					if($radio_payment == 1){
						$row_template[$fields[$j]] = str_replace("[amount]", "<strong><u>Kosten</u></strong> <br>Betrag: " . number_format($amount, 2, ',', '') . " &euro;<br>Versand: " . number_format($shipping_costs[$row_last_paying['radio_shipping']], 2, ',', '') . " &euro;<br>Bezahlart: " . number_format($payment_costs[$row_last_paying['radio_payment']], 2, ',', '') . " &euro;<br>Samstagszuschlag: " . number_format($saturday_costs[$radio_saturday], 2, ',', '') . " &euro;" . ($carriers_services_costs[$carriers_service] > 0 ? "<br>UPS-Service: " . number_format($carriers_services_costs[$carriers_service], 2, ',', '') . " &euro;" : "") . "<br>Gesammt: <u>" . number_format(($amount + $saturday_costs[$radio_saturday] + $carriers_services_costs[$carriers_service] + $shipping_costs[$row_last_paying['radio_shipping']] + $payment_costs[$row_last_paying['radio_payment']]), 2, ',', '') . "</u> &euro;<br>", $row_template[$fields[$j]]);
					}else{
						$row_template[$fields[$j]] = str_replace("[shipping_costs]", "<strong><u>Kosten</u></strong> <br>Versand: " . number_format($shipping_costs[$row_last_paying['radio_shipping']], 2, ',', '') . " &euro;<br>Bezahlart: " . number_format($payment_costs[$row_last_paying['radio_payment']], 2, ',', '') . " &euro;<br>Samstagszuschlag: " . number_format($saturday_costs[$radio_saturday], 2, ',', '') . " &euro;<br>Gesammt: <u>" . number_format(($amount + $saturday_costs[$radio_saturday] + $carriers_services_costs[$carriers_service] + $shipping_costs[$row_last_paying['radio_shipping']] + $payment_costs[$row_last_paying['radio_payment']]), 2, ',', '') . "</u> &euro;<br>", $row_template[$fields[$j]]);
					}
					$radio_radio_saturday = array(	0 => "Nein", 
													1 => "Ja");
					$row_template[$fields[$j]] = str_replace("[radio_saturday]", $radio_radio_saturday[$radio_saturday], $row_template[$fields[$j]]);

				}

				mysqli_query($conn, "	INSERT 	`" . $order_table . "_statuses` 
										SET 	`" . $order_table . "_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
												`" . $order_table . "_statuses`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
												`" . $order_table . "_statuses`.`status_number`='" . mysqli_real_escape_string($conn, $status_number) . "', 
												`" . $order_table . "_statuses`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
												`" . $order_table . "_statuses`.`status_id`='" . mysqli_real_escape_string($conn, intval($row_status['id'])) . "', 
												`" . $order_table . "_statuses`.`template`='" . mysqli_real_escape_string($conn, $row_template['name']) . "', 
												`" . $order_table . "_statuses`.`subject`='" . mysqli_real_escape_string($conn, strip_tags($response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber)) . "', 
												`" . $order_table . "_statuses`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
												`" . $order_table . "_statuses`.`public`='1', 
												`" . $order_table . "_statuses`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

				$_SESSION["status"]["id"] = $conn->insert_id;

				mysqli_query($conn, "	INSERT 	`order_orders_shipments` 
										SET 	`order_orders_shipments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
												`order_orders_shipments`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
												`order_orders_shipments`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
												`order_orders_shipments`.`status_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["status"]["id"])) . "', 
												`order_orders_shipments`.`shipments_id`='" . mysqli_real_escape_string($conn, strip_tags($response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber)) . "', 
												`order_orders_shipments`.`carrier_tracking_no`='" . mysqli_real_escape_string($conn, strip_tags($response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber)) . "', 
												`order_orders_shipments`.`label_url`='" . mysqli_real_escape_string($conn, strip_tags($response_label->LabelRecoveryResponse->LabelResults->LabelImage->URL)) . "', 
												`order_orders_shipments`.`graphic_image_jpeg`='" . mysqli_real_escape_string($conn, strip_tags($response->ShipmentResponse->ShipmentResults->PackageResults->ShippingLabel->GraphicImage)) . "', 
												`order_orders_shipments`.`graphic_image_gif`='" . mysqli_real_escape_string($conn, strip_tags($response_label->LabelRecoveryResponse->LabelResults->LabelImage->GraphicImage)) . "', 
												`order_orders_shipments`.`price`='" . mysqli_real_escape_string($conn, $amount) . "', 
												`order_orders_shipments`.`total_charges_with_taxes`='" . mysqli_real_escape_string($conn, number_format(($amount + $saturday_costs[$radio_saturday] + $carriers_services_costs[$carriers_service] + $shipping_costs[$row_last_paying['radio_shipping']] + $payment_costs[$row_last_paying['radio_payment']]), 2, '.', '')) . "', 
												`order_orders_shipments`.`carrier`='UPS', 
												`order_orders_shipments`.`service`='" . mysqli_real_escape_string($conn, $carriers_service) . "', 
												`order_orders_shipments`.`reference_number`='" . mysqli_real_escape_string($conn, $ref_number) . "', 
												`order_orders_shipments`.`notification_email`='" . mysqli_real_escape_string($conn, $from_email) . "', 
												`order_orders_shipments`.`component`='" . mysqli_real_escape_string($conn, intval($row_order['component'])) . "', 
												`order_orders_shipments`.`companyname`='" . mysqli_real_escape_string($conn, $to_companyname) . "', 
												`order_orders_shipments`.`firstname`='" . mysqli_real_escape_string($conn, $to_firstname) . "', 
												`order_orders_shipments`.`lastname`='" . mysqli_real_escape_string($conn, $to_lastname) . "', 
												`order_orders_shipments`.`street`='" . mysqli_real_escape_string($conn, $to_street) . "', 
												`order_orders_shipments`.`streetno`='" . mysqli_real_escape_string($conn, $to_streetno) . "', 
												`order_orders_shipments`.`zipcode`='" . mysqli_real_escape_string($conn, $to_zipcode) . "', 
												`order_orders_shipments`.`city`='" . mysqli_real_escape_string($conn, $to_city) . "', 
												`order_orders_shipments`.`country`='" . mysqli_real_escape_string($conn, $to_country) . "', 
												`order_orders_shipments`.`weight`='" . mysqli_real_escape_string($conn, $weight) . "', 
												`order_orders_shipments`.`length`='" . mysqli_real_escape_string($conn, $length) . "', 
												`order_orders_shipments`.`width`='" . mysqli_real_escape_string($conn, $width) . "', 
												`order_orders_shipments`.`height`='" . mysqli_real_escape_string($conn, $height) . "', 
												`order_orders_shipments`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

				$_SESSION["shipments"]["id"] = $conn->insert_id;

				mysqli_query($conn, "	INSERT 	`" . $order_table . "_events` 
										SET 	`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
												`" . $order_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
												`" . $order_table . "_events`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
												`" . $order_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
												`" . $order_table . "_events`.`message`='" . mysqli_real_escape_string($conn, $order_name . ", Sendung durchgeführt, ID [#" . $_SESSION["shipments"]["id"]) . "]', 
												`" . $order_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

				mysqli_query($conn, "	INSERT 	`" . $order_table . "_history` 
										SET 	`" . $order_table . "_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
												`" . $order_table . "_history`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
												`" . $order_table . "_history`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
												`" . $order_table . "_history`.`message`='" . mysqli_real_escape_string($conn, $row_status['name'] . " - Die Sendung " . strip_tags($response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber) . " wurde an den Kunden versendet.") . "', 
												`" . $order_table . "_history`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
		
				$_SESSION["history"]["id"] = $conn->insert_id;
		
				mysqli_query($conn, "	INSERT 	`" . $order_table . "_events` 
										SET 	`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
												`" . $order_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
												`" . $order_table . "_events`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
												`" . $order_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
												`" . $order_table . "_events`.`message`='" . mysqli_real_escape_string($conn, $order_name . "-Auftragshistory, Nachricht erstellt, ID [#" . $_SESSION["history"]["id"] . "]") . "', 
												`" . $order_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, $order_name . "-Auftragshistory, Nachricht erstellt, ID [#" . $_SESSION["history"]["id"] . "]") . "', 
												`" . $order_table . "_events`.`body`='" . mysqli_real_escape_string($conn, $row_status['name']) . "', 
												`" . $order_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

				$tracking_image = "<img src=\"" . $domain . "/email-logo/" . $_SESSION["admin"]["company_id"] . "/" . $row_order['order_number'] . "/" . $status_number . "\" width=\"0\" height=\"0\" border=\"0\" />\n";

				if($mail_with_pdf == 1){

					$filename = "begleitschein.pdf";

					$pdf = new Fpdi();

					$pdf->AddPage();

					require('includes/email_template_pdf_code_' . $row_template['id'] . '.php');

					$pdfdoc = $pdf->Output("", "S");

					if(isset($_POST['from_mail']) && intval($_POST['from_mail']) == 1 && $from_email != ""){

						$mail = new dbbMailer();

						$mail->host = $maindata['smtp_host'];
						$mail->username = $maindata['smtp_username'];
						$mail->password = $maindata['smtp_password'];
						$mail->secure = $maindata['smtp_secure'];
						$mail->port = intval($maindata['smtp_port']);
						$mail->charset = $maindata['smtp_charset'];
		 
						$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
						$mail->addAddress($from_email, $from_firstname . " " . $from_lastname);

						//$mail->addAttachment(dirname(__FILE__) . "/../../temp/condition.tar");

						$mail->addStringAttachment($pdfdoc, $filename, 'base64', 'application/pdf');

						$mail->subject = strip_tags($row_template['subject']);

						$mail->body = str_replace("[track]", $tracking_image, $row_template['body']);

						if(!$mail->send()){

						}

					}

					if(isset($_POST['to_mail']) && intval($_POST['to_mail']) == 1 && $to_email != ""){

						$mail = new dbbMailer();

						$mail->host = $maindata['smtp_host'];
						$mail->username = $maindata['smtp_username'];
						$mail->password = $maindata['smtp_password'];
						$mail->secure = $maindata['smtp_secure'];
						$mail->port = intval($maindata['smtp_port']);
						$mail->charset = $maindata['smtp_charset'];

						$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
						$mail->addAddress($to_email, $to_firstname . " " . $to_lastname);

						//$mail->addAttachment(dirname(__FILE__) . "/../../temp/condition.tar");

						$mail->addStringAttachment($pdfdoc, $filename, 'base64', 'application/pdf');

						$mail->subject = strip_tags($row_template['subject']);

						$mail->body = str_replace("[track]", $tracking_image, $row_template['body']);

						if(!$mail->send()){

						}

					}

					if(isset($_POST['user_mail']) && intval($_POST['user_mail']) == 1 && $row_order['email'] != ""){

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

					if(isset($_POST['admin_mail']) && intval($_POST['admin_mail']) == 1){

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

					if(isset($_POST['from_mail']) && intval($_POST['from_mail']) == 1 && $from_email != ""){

						$mail = new dbbMailer();

						$mail->host = $maindata['smtp_host'];
						$mail->username = $maindata['smtp_username'];
						$mail->password = $maindata['smtp_password'];
						$mail->secure = $maindata['smtp_secure'];
						$mail->port = intval($maindata['smtp_port']);
						$mail->charset = $maindata['smtp_charset'];
		 
						$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
						$mail->addAddress($from_email, $from_firstname . " " . $from_lastname);

						$mail->subject = strip_tags($row_template['subject']);

						$mail->body = str_replace("[track]", $tracking_image, $row_template['body']);

						if(!$mail->send()){

						}

					}

					if(isset($_POST['to_mail']) && intval($_POST['to_mail']) == 1 && $to_email != ""){

						$mail = new dbbMailer();

						$mail->host = $maindata['smtp_host'];
						$mail->username = $maindata['smtp_username'];
						$mail->password = $maindata['smtp_password'];
						$mail->secure = $maindata['smtp_secure'];
						$mail->port = intval($maindata['smtp_port']);
						$mail->charset = $maindata['smtp_charset'];
		 
						$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
						$mail->addAddress($to_email, $to_firstname . " " . $to_lastname);

						$mail->subject = strip_tags($row_template['subject']);

						$mail->body = str_replace("[track]", $tracking_image, $row_template['body']);

						if(!$mail->send()){

						}

					}

					if(isset($_POST['user_mail']) && intval($_POST['user_mail']) == 1 && $row_order['email'] != ""){

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

					if(isset($_POST['admin_mail']) && intval($_POST['admin_mail']) == 1){

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
												"						<div class=\"col-12\">\n" . 
												"							<strong class=\"text-success\">\n" . 
												" 								Die Sendung wurde durchgeführt!\n" . 
												"							</strong>\n" . 
												"						</div>\n" . 
												"					</div>\n";

	/*			if(isset($response_label->LabelRecoveryResponse->LabelResults->LabelImage->URL)){
					$html_new_shipping_result .= 	"<script>\n" . 
													"window.open(\"" . $response_label->LabelRecoveryResponse->LabelResults->LabelImage->URL . "\", \"Label_URL\", \"titlebar=1,menubar=1,toolbar=1,bookmarks=1,resizable=1,scrollbars=1,status=1\");\n" . 
													"</script>\n";
				}*/

				if(isset($response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber)){
					$html_new_shipping_result .= 	"<button type=\"button\" class=\"btn btn-success btn-sm\" onclick=\"if(navigator.appName == 'Microsoft Internet Explorer'){document.getElementById('label_frame').print();}else{document.getElementById('label_frame').contentWindow.print();}\">drucken <i class=\"fa fa-print\"> </i></button> \n" . 
													"<iframe src=\"/sendung/label/" . intval($_SESSION["admin"]["company_id"]) . "/" . $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber . "\" id=\"label_frame\" width=\"30\" height=\"20\" style=\"visibility: hidden\"></iframe><br />\n" . 
													"<script>\n" . 
													"var labelWindow = document.getElementById('label_frame');\n" . 
													"setTimeout(function(){\n" . 
													"	if(navigator.appName == 'Microsoft Internet Explorer'){\n" . 
													"		labelWindow.print();\n" . 
													"	}else{\n" . 
													"		labelWindow.contentWindow.print();\n" . 
													"	}\n" . 
													"}, 2000);\n" . 
													"</script>\n";
				}

	/*			if(isset($shipment->tracking_url)){
					$html_new_shipping_result .= 	"<script>\n" . 
													"window.open(\"https://www.ups.com/WebTracking/processInputRequest?tracknum=" . $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber . "&loc=de_DE\", \"tracking\", \"titlebar=1,menubar=1,toolbar=1,bookmarks=1,resizable=1,scrollbars=1,status=1\");\n" . 
													"</script>\n";
				}*/

				if($row_attachments_matrix['file1'] > 0){
					$html_new_shipping_result .= 	"<button type=\"button\" class=\"btn btn-success btn-sm\" onclick=\"if(navigator.appName == 'Microsoft Internet Explorer'){document.getElementById('iframe_file1').print();}else{document.getElementById('iframe_file1').contentWindow.print();}\">Datei-1 drucken <i class=\"fa fa-print\"> </i></button> \n" . 
													"<iframe src=\"/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/attachments/" . $row_attachments_matrix['file1_file'] . "\" id=\"iframe_file1\" width=\"30\" height=\"20\" style=\"visibility: hidden\"></iframe><br />\n";
				}

				if($row_attachments_matrix['file2'] > 0){
					$html_new_shipping_result .= 	"<button type=\"button\" class=\"btn btn-success btn-sm\" onclick=\"if(navigator.appName == 'Microsoft Internet Explorer'){document.getElementById('iframe_file2').print();}else{document.getElementById('iframe_file2').contentWindow.print();}\">Datei-2 drucken <i class=\"fa fa-print\"> </i></button> \n" . 
													"<iframe src=\"/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/attachments/" . $row_attachments_matrix['file2_file'] . "\" id=\"iframe_file2\" width=\"30\" height=\"20\" style=\"visibility: hidden\"></iframe><br />\n";
				}

			}else{

				$emsg_shipment .= isset($response_label->response->errors[0]) ? "<small class=\"error bg-success text-white\">" . $response_label->response->errors[0]->message . "</small><br />\n" : "";

			}

		}else{

			$emsg_shipment = isset($response->response->errors[0]) ? "<small class=\"error bg-success text-white\">" . $response->response->errors[0]->message . "</small><br />\n" : "";

		}

	}

?>