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

	$time = time();

	$row_packing1 = mysqli_fetch_array(mysqli_query($conn, "SELECT 	* 
															FROM 	`packing_packings` 
															WHERE 	`packing_packings`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
															AND 	`packing_packings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

	$radio_saturday = 0;

	$radio_shipping = 0;

	$emsg_all_other = "";

	if(isset($_POST['radio_saturday']) && strlen($_POST['radio_saturday']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie aus ob ein Samstagszuschlag besteht.</small><br />\n";
		$inp_radio_saturday = " is-invalid";
	} else {
		$radio_saturday = isset($_POST['radio_saturday']) ? intval($_POST['radio_saturday']) : 0;
	}

	if($row_packing1['firstname'] == "" && $row_packing1['lastname'] == ""){
		$row_packing1['firstname'] = $row_packing1['companyname'];
	}

	if($emsg == ""){

		$time = time();

		$domain = isset($_SERVER['HTTPS']) ? "https://" . $_SERVER['HTTP_HOST'] : "http://" . $_SERVER['HTTP_HOST'];

		$row_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "'"), MYSQLI_ASSOC);
		$row_country_to = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . mysqli_real_escape_string($conn, intval($row_packing1['country'])) . "'"), MYSQLI_ASSOC);
		$row_country_from = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . mysqli_real_escape_string($conn, intval($maindata['country'])) . "'"), MYSQLI_ASSOC);

		//$row_last_paying = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders_payings` WHERE `order_orders_payings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_payings`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' ORDER BY CAST(`order_orders_payings`.`time` AS UNSIGNED) DESC limit 0, 1"), MYSQLI_ASSOC);

		$saturday_delivery = array();

		if($row_packing1['carriers_service'] == "65" && $row_packing1['radio_saturday'] == 1){
			$saturday_delivery['SaturdayDeliveryIndicator'] = array('SATURDAY_DELIVERY');
		}

		if($row_packing1['radio_payment'] == 1){
			$saturday_delivery['COD'] = array(
				'CODFundsCode' => '1', 
				'CODAmount' => array(
					'CurrencyCode' => 'EUR', 
					'MonetaryValue' => '' . ($row_packing1['amount'] + $saturday_costs[$row_packing1['radio_saturday']] + $carriers_services_costs[$row_packing1['carriers_service']] + $shipping_costs[$row_packing1['radio_shipping']] + $payment_costs[$row_packing1['radio_payment']])
				)
			);
		}

		$data = array(
			'ShipmentRequest' => array(
				'Shipment' => array(
					'Description' => $row_packing1['packing_number'] . "-" . $row_order['order_number'], 
					'ShipmentServiceOptions' => $saturday_delivery, 
					'Shipper' => array(
						'Name' => $maindata['firstname'] . ' ' . $maindata['lastname'], 
						'AttentionName' => $maindata['company'], 
						'TaxIdentificationNumber' => '456999', 
						'Phone' => array(
							'Number' => $maindata['phonenumber']
						), 
						'ShipperNumber' => $maindata['ups_customer_number'], 
						'Address' => array(
							'AddressLine' => $maindata['street'] . ' ' . $maindata['streetno'], 
							'City' => $maindata['city'], 
							'StateProvinceCode' => '', 
							'PostalCode' => $maindata['zipcode'], 
							'CountryCode' => $row_country_from['code']
						)
					), 
					'ShipTo' => array(
						'Name' => substr($row_packing1['firstname'] . ' ' . $row_packing1['lastname'], 0, 34), 
						'AttentionName' => ($row_packing1['companyname'] != "" ? $row_packing1['companyname'] : "keine"), 
						'FaxNumber' => '', 
						'TaxIdentificationNumber' => '456999', 
						'Address' => array(
							'AddressLine' => $row_packing1['street'] . ' ' . $row_packing1['streetno'], 
							'City' => $row_packing1['city'], 
							'StateProvinceCode' => '', 
							'PostalCode' => $row_packing1['zipcode'], 
							'CountryCode' => $row_country_to['code']
						)
					), 
					'ShipFrom' => array(
						'Name' => $maindata['firstname'] . ' ' . $maindata['lastname'], 
						'AttentionName' => $maindata['company'], 
						'Phone' => array(
							'Number' => $maindata['phonenumber']
						), 
						'FaxNumber' => '', 
						'TaxIdentificationNumber' => '456999', 
						'Address' => array(
							'AddressLine' => $maindata['street'] . ' ' . $maindata['streetno'], 
							'City' => $maindata['city'], 
							'StateProvinceCode' => '', 
							'PostalCode' => $maindata['zipcode'], 
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
						'Code' => $row_packing1['carriers_service'], 
						'Description' => $carriers_services[$row_packing1['carriers_service']]
					), 
					'Package' => array(
						array(
							'Description' => 'International Goods', 
							'ReferenceNumber' => array(
								'Value' => $row_packing1['packing_number'], 
							),
							'Packaging' => array(
								'Code' => '02'
							), 
							'Dimensions' => array(
								'UnitOfMeasurement' => array(
									'Code' => 'CM', 
									'Description' => 'Zentimeter'
								), 
								'Length' => '' . $row_packing1['length'], 
								'Width' => '' . $row_packing1['width'], 
								'Height' => '' . $row_packing1['height']
							), 
							'PackageWeight' => array(
								'UnitOfMeasurement' => array(
									'Code' => 'KGS'
								), 
								'Weight' => '' . floatval($row_packing1['weight'])
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

		$from_phonenumber1 = $maindata['mobilnumber'] != "" ? $maindata['mobilnumber'] : $maindata['phonenumber'];

		if($from_phonenumber1 != ""){
			$data['ShipmentRequest']['Shipment']['Shipper']['Phone'] = array('Number' => $from_phonenumber1);
			$data['ShipmentRequest']['Shipment']['ShipFrom']['Phone'] = array('Number' => $from_phonenumber1);
		}

		$to_phonenumber1 = $row_packing1['mobilnumber'] != "" ? $row_packing1['mobilnumber'] : $row_packing1['phonenumber'];

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

				$status_number = intval($_SESSION["admin"]["id"]) . "A" . date("dmYHis", time());

				mysqli_query($conn, "	UPDATE 	`packing_packings` 
										SET 	`packing_packings`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
												`packing_packings`.`mode`='1', 
												`packing_packings`.`is_send`='1', 
												`packing_packings`.`shipments_id`='" . mysqli_real_escape_string($conn, strip_tags($response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber)) . "', 
												`packing_packings`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
										WHERE 	`packing_packings`.`id`='" . mysqli_real_escape_string($conn, intval($row_packing1['id'])) . "' 
										AND 	`packing_packings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

				/*mysqli_query($conn, "	INSERT 	`order_orders_shipments` 
										SET 	`order_orders_shipments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
												`order_orders_shipments`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
												`order_orders_shipments`.`order_id`='0', 
												`order_orders_shipments`.`status_id`='0', 
												`order_orders_shipments`.`devices`='', 
												`order_orders_shipments`.`file1`='0', 
												`order_orders_shipments`.`file2`='0', 
												`order_orders_shipments`.`items`='', 
												`order_orders_shipments`.`shipments_id`='" . mysqli_real_escape_string($conn, strip_tags($response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber)) . "', 
												`order_orders_shipments`.`carrier_tracking_no`='" . mysqli_real_escape_string($conn, strip_tags($response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber)) . "', 
												`order_orders_shipments`.`label_url`='" . mysqli_real_escape_string($conn, strip_tags($response_label->LabelRecoveryResponse->LabelResults->LabelImage->URL)) . "', 
												`order_orders_shipments`.`graphic_image_jpeg`='" . mysqli_real_escape_string($conn, strip_tags($response->ShipmentResponse->ShipmentResults->PackageResults->ShippingLabel->GraphicImage)) . "', 
												`order_orders_shipments`.`graphic_image_gif`='" . mysqli_real_escape_string($conn, strip_tags($response_label->LabelRecoveryResponse->LabelResults->LabelImage->GraphicImage)) . "', 
												`order_orders_shipments`.`price`='" . mysqli_real_escape_string($conn, $row_packing1['amount']) . "', 
												`order_orders_shipments`.`total_charges_with_taxes`='" . mysqli_real_escape_string($conn, number_format(($row_packing1['amount'] + $saturday_costs[$radio_saturday] + $carriers_services_costs[$row_packing1['carriers_service']] + $shipping_costs[$radio_shipping] + $payment_costs[$row_packing1['radio_payment']]), 2, '.', '')) . "', 
												`order_orders_shipments`.`carrier`='UPS', 
												`order_orders_shipments`.`service`='" . mysqli_real_escape_string($conn, $row_packing1['carriers_service']) . "', 
												`order_orders_shipments`.`reference_number`='" . mysqli_real_escape_string($conn, $row_packing1['packing_number'] . "', 
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
												`order_orders_shipments`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");*/

				mysqli_query($conn, "	INSERT 	`shipping_history` 
										SET 	`shipping_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
												`shipping_history`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
												`shipping_history`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['order_id'])) . "', 
												`shipping_history`.`devices`='" . mysqli_real_escape_string($conn, strip_tags($_SESSION["devices"])) . "', 
												`shipping_history`.`shipments_id`='" . mysqli_real_escape_string($conn, strip_tags($response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber)) . "', 
												`shipping_history`.`carrier_tracking_no`='" . mysqli_real_escape_string($conn, strip_tags($response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber)) . "', 
												`shipping_history`.`label_url`='" . mysqli_real_escape_string($conn, strip_tags($response_label->LabelRecoveryResponse->LabelResults->LabelImage->URL)) . "', 
												`shipping_history`.`graphic_image_jpeg`='" . mysqli_real_escape_string($conn, strip_tags($response->ShipmentResponse->ShipmentResults->PackageResults->ShippingLabel->GraphicImage)) . "', 
												`shipping_history`.`graphic_image_gif`='" . mysqli_real_escape_string($conn, strip_tags($response_label->LabelRecoveryResponse->LabelResults->LabelImage->GraphicImage)) . "', 
												`shipping_history`.`total_charges_with_taxes`='" . mysqli_real_escape_string($conn, number_format($response->ShipmentResponse->ShipmentResults->NegotiatedRateCharges->TotalChargesWithTaxes->MonetaryValue, 2, '.', '')) . "', 
												`shipping_history`.`carrier`='UPS', 
												`shipping_history`.`service`='" . mysqli_real_escape_string($conn, $row_packing1['carriers_service']) . "', 

												`shipping_history`.`from_shortcut`='" . mysqli_real_escape_string($conn, 0) . "', 
												`shipping_history`.`from_companyname`='" . mysqli_real_escape_string($conn, "") . "', 
												`shipping_history`.`from_gender`='" . mysqli_real_escape_string($conn, 0) . "', 
												`shipping_history`.`from_firstname`='" . mysqli_real_escape_string($conn, "") . "', 
												`shipping_history`.`from_lastname`='" . mysqli_real_escape_string($conn, "") . "', 
												`shipping_history`.`from_street`='" . mysqli_real_escape_string($conn, "") . "', 
												`shipping_history`.`from_streetno`='" . mysqli_real_escape_string($conn, "") . "', 
												`shipping_history`.`from_zipcode`='" . mysqli_real_escape_string($conn, "") . "', 
												`shipping_history`.`from_city`='" . mysqli_real_escape_string($conn, "") . "', 
												`shipping_history`.`from_country`='" . mysqli_real_escape_string($conn, 0) . "', 
												`shipping_history`.`from_email`='" . mysqli_real_escape_string($conn, "") . "', 
												`shipping_history`.`from_phonenumber`='" . mysqli_real_escape_string($conn, "") . "', 
												`shipping_history`.`from_mobilnumber`='" . mysqli_real_escape_string($conn, "") . "', 

												`shipping_history`.`to_shortcut`='" . mysqli_real_escape_string($conn, $row_packing1['address_id']) . "', 
												`shipping_history`.`to_companyname`='" . mysqli_real_escape_string($conn, $row_packing1['companyname']) . "', 
												`shipping_history`.`to_gender`='" . mysqli_real_escape_string($conn, $row_packing1['gender']) . "', 
												`shipping_history`.`to_firstname`='" . mysqli_real_escape_string($conn, $row_packing1['firstname']) . "', 
												`shipping_history`.`to_lastname`='" . mysqli_real_escape_string($conn, $row_packing1['lastname']) . "', 
												`shipping_history`.`to_street`='" . mysqli_real_escape_string($conn, $row_packing1['street']) . "', 
												`shipping_history`.`to_streetno`='" . mysqli_real_escape_string($conn, $row_packing1['streetno']) . "', 
												`shipping_history`.`to_zipcode`='" . mysqli_real_escape_string($conn, $row_packing1['zipcode']) . "', 
												`shipping_history`.`to_city`='" . mysqli_real_escape_string($conn, $row_packing1['city']) . "', 
												`shipping_history`.`to_country`='" . mysqli_real_escape_string($conn, $row_packing1['country']) . "', 
												`shipping_history`.`to_email`='" . mysqli_real_escape_string($conn, $row_packing1['email']) . "', 
												`shipping_history`.`to_phonenumber`='" . mysqli_real_escape_string($conn, $row_packing1['phonenumber']) . "', 
												`shipping_history`.`to_mobilnumber`='" . mysqli_real_escape_string($conn, $row_packing1['mobilnumber']) . "', 

												`shipping_history`.`weight`='" . mysqli_real_escape_string($conn, $row_packing1['weight']) . "', 
												`shipping_history`.`length`='" . mysqli_real_escape_string($conn, intval($row_packing1['length'])) . "', 
												`shipping_history`.`width`='" . mysqli_real_escape_string($conn, intval($row_packing1['width'])) . "', 
												`shipping_history`.`height`='" . mysqli_real_escape_string($conn, intval($row_packing1['height'])) . "', 

												`shipping_history`.`radio_payment`='" . mysqli_real_escape_string($conn, $row_packing1['radio_payment']) . "', 
												`shipping_history`.`amount`='" . mysqli_real_escape_string($conn, $row_packing1['amount']) . "', 
												`shipping_history`.`radio_saturday`='" . mysqli_real_escape_string($conn, 0) . "', 
												`shipping_history`.`description`='" . mysqli_real_escape_string($conn, $row_packing1['message']) . "', 

												`shipping_history`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

				//$_SESSION["shipments"]["id"] = $conn->insert_id;

				$html_new_shipping_result = 	"					<div class=\"form-group row\">\n" . 
												"						<div class=\"col-12 text-center\">\n" . 
												"							<h2 class=\"text-success\">\n" . 
												" 								Versandschein wird gedruckt ...\n" . 
												"							</h2>\n" . 
												"						</div>\n" . 
												"					</div>\n";

	/*			if(isset($response_label->LabelRecoveryResponse->LabelResults->LabelImage->URL)){
					$html_new_shipping_result .= 	"<script>\n" . 
													"window.open(\"" . $response_label->LabelRecoveryResponse->LabelResults->LabelImage->URL . "\", \"Label_URL\", \"titlebar=1,menubar=1,toolbar=1,bookmarks=1,resizable=1,scrollbars=1,status=1\");\n" . 
													"</script>\n";
				}*/

				if(isset($response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber)){
					$html_new_shipping_result .= 	"<button type=\"button\" class=\"btn btn-lg btn-success\" onclick=\"if(navigator.appName == 'Microsoft Internet Explorer'){document.getElementById('label_frame').print();}else{document.getElementById('label_frame').contentWindow.print();}\">Versandschein nachdrucken <i class=\"fa fa-print\"> </i></button> \n" . 
													"<iframe src=\"/sendung/label-blank/" . intval($_SESSION["admin"]["company_id"]) . "/" . $response->ShipmentResponse->ShipmentResults->ShipmentIdentificationNumber . "\" id=\"label_frame\" width=\"30\" height=\"20\" style=\"visibility: hidden\"></iframe><br /><br />\n" . 
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

				/*if($row_attachments1['id'] > 0){
					$html_new_shipping_result .= 	"<button type=\"button\" class=\"btn btn-success btn-sm\" onclick=\"if(navigator.appName == 'Microsoft Internet Explorer'){document.getElementById('iframe_file1').print();}else{document.getElementById('iframe_file1').contentWindow.print();}\">Datei-1 drucken <i class=\"fa fa-print\"> </i></button> \n" . 
													"<iframe src=\"/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/attachments/" . $row_attachments1['file'] . "\" id=\"iframe_file1\" width=\"30\" height=\"20\" style=\"visibility: hidden\"></iframe><br />\n";
				}*/

				/*if($row_attachments2['id'] > 0){
					$html_new_shipping_result .= 	"<button type=\"button\" class=\"btn btn-success btn-sm\" onclick=\"if(navigator.appName == 'Microsoft Internet Explorer'){document.getElementById('iframe_file2').print();}else{document.getElementById('iframe_file2').contentWindow.print();}\">Datei-2 drucken <i class=\"fa fa-print\"> </i></button> \n" . 
													"<iframe src=\"/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/attachments/" . $row_attachments2['file'] . "\" id=\"iframe_file2\" width=\"30\" height=\"20\" style=\"visibility: hidden\"></iframe><br />\n";
				}*/

				$html_new_shipping_result = $html_new_shipping_result != "" ? "<div class=\"row\"><div class=\"col-sm-6 text-center\">" . $html_new_shipping_result . "</div></div>\n" : $html_new_shipping_result;

			}else{

				$emsg_shipment .= isset($response_label->response->errors[0]) ? "<small class=\"error bg-success text-white\">" . $response_label->response->errors[0]->message . "</small><br />\n" : "";

			}

		}else{

			$emsg_shipment = isset($response->response->errors[0]) ? "<small class=\"error bg-success text-white\">" . $response->response->errors[0]->message . "</small><br />\n" : "";

		}

	}

//	$_POST['id'] = 0;

	$_POST['pack_blank'] = "packing";

?>