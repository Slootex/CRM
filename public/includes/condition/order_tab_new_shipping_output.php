<?php 

	$carriers_service = isset($_POST['carriers_service']) ? strip_tags($_POST['carriers_service']) : "11";

	$row_package_template = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `package_templates` WHERE `package_templates`.`id`='" . mysqli_real_escape_string($conn, intval($package_template)) . "'"), MYSQLI_ASSOC);

	$countries_options_to = "";
	$countries_options_from = "";

	$to_country_id = 0;

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`countries` 
									WHERE 		`countries`.`frontend`='1' 
									ORDER BY 	`countries`.`name` ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$countries_options_to .= "								<option value=\"" . $row['id'] . "\" data-code=\"" . $row['code'] . "\"" . ((isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung durchführen") || (isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren") ? ($to_country == $row['id'] ? " selected=\"selected\"" : "") : (($row_order['differing_shipping_address'] == 1 ? $row_order['differing_country'] : $row_order['country']) == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";
		$countries_options_from .= "								<option value=\"" . $row['id'] . "\" data-code=\"" . $row['code'] . "\"" . ((isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung durchführen") || (isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren") ? ($from_country == $row['id'] ? " selected=\"selected\"" : "") : ($maindata['country'] == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";

		$to_country_id = ((isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung erstellen") || (isset($_POST['update_country']) && $_POST['update_country'] == "aktualisieren") ? $to_country : ($row_order['differing_shipping_address'] == 1 ? $row_order["differing_country"] : $row_order["country"]));
	}


	if($row_last_paying['radio_shipping'] != 2 && $row_last_paying['radio_shipping'] != 3){
		if($to_country_id == 1){
			if($row_last_paying['radio_saturday'] == 1){
				$carriers_service = "65";
				$carriers_services = array(
					'65' => 'UPS Saver - 0,00 €'
				);
			}else{
				if($row_last_paying['radio_shipping'] == 0){
					$carriers_service = "65";
					$carriers_services = array(
						'65' => 'UPS Saver - 0,00 €'
					);
				}
				if($row_last_paying['radio_shipping'] == 1){
					$carriers_service = "11";
					$carriers_services = array(
						'11' => 'UPS Standard - 0,00 €'
					);
				}
			}
		}else{
			$carriers_service = "11";
			$carriers_services = array(
				'11' => 'UPS Standard - 0,00 €'
			);
		}		
	}else{
		$carriers_service = "00";
		$carriers_services = array();
	}

	$carrier_services_options = "";

	foreach($carriers_services as $key => $val){

		$carrier_services_options .= "<option value=\"" . $key . "\"" . (isset($_POST['carriers_service']) && intval($_POST['carriers_service']) == $key ? " selected=\"selected\"" : ($carriers_service == $key ? " selected=\"selected\"" : "")) . ">" . $val . "</option>\n";

	}

	$carrier_package_templates_options = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`package_templates` 
									ORDER BY 	CAST(`package_templates`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$carrier_package_templates_options .= "								<option value=\"" . $row['id'] . "\"" . ($package_template == $row['id'] ? " selected=\"selected\"" : "") . ">" . $row['name'] . "</option>\n";
		if($package_template == $row['id']){
			
			if(!isset($_POST['update_country']) && !isset($_POST['new_shipping'])){
				$length = $row['length'];
				$width = $row['width'];
				$height = $row['height'];
				$weight = $row['weight'];
			}
		}
	}

	$shipping_costs = array(
		0 =>  8.95, // Expressversand
		1 =>  5.95, // Standardversand
		2 =>  15.00, // International
		3 =>  0.00  // Abholung
	);

	$payment_costs = array(
		0 =>  0.00, // Überweisung
		1 =>  8.00, // Nachnahme
		2 =>  0.00  // Bar
	);

	$tabs_contents .= 	"				<form action=\"" . $order_action . "\" method=\"post\">\n" . 

						$html_new_shipping_result . 

						($emsg_shipment != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg_shipment . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

						"					<div class=\"form-group row\">\n" . 
						"						<div class=\"col-sm-6\">\n" . 

						"							<div class=\"form-group row m-1\">\n" . 
						"								<div class=\"col-sm-12 bg-light border\">\n" . 

						"									<div class=\"form-group row mt-3\">\n" . 
						"										<div class=\"col-sm-12\">\n" . 
						"											<strong>Absender</strong>\n" . 
						"										</div>\n" . 
						"									</div>\n" . 

						"									<div class=\"form-group row\">\n" . 
						"										<div class=\"col-sm-12\">\n" . 
						"											<input type=\"text\" id=\"from_companyname\" name=\"from_companyname\" value=\"" . (isset($_POST['from_companyname']) ? $from_companyname : $maindata['company']) . "\" class=\"form-control" . $inp_from_companyname . "\" placeholder=\"Firma\" />\n" . 
						"										</div>\n" . 
						"									</div>\n" . 

						"									<div class=\"form-group row\">\n" . 
						"										<div class=\"col-sm-4 mt-2\">\n" . 
						"											<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"												<input type=\"radio\" id=\"gender_02\" name=\"from_gender\" value=\"0\"" . ((isset($_POST['from_gender']) ? intval($_POST['from_gender']) : $maindata["gender"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
						"												<label class=\"custom-control-label\" for=\"gender_02\">\n" . 
						"													Herr\n" . 
						"												</label>\n" . 
						"											</div>\n" . 
						"											<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"												<input type=\"radio\" id=\"gender_12\" name=\"from_gender\" value=\"1\"" . ((isset($_POST['from_gender']) ? intval($_POST['from_gender']) : $maindata["gender"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
						"												<label class=\"custom-control-label\" for=\"gender_12\">\n" . 
						"													Frau\n" . 
						"												</label>\n" . 
						"											</div>\n" . 
						"										</div>\n" . 
						"										<div class=\"col-sm-4\">\n" . 
						"											<input type=\"text\" id=\"from_firstname\" name=\"from_firstname\" value=\"" . (isset($_POST['from_firstname']) ? $from_firstname : $maindata['firstname']) . "\" class=\"form-control" . $inp_from_firstname . "\" placeholder=\"Vorname\" />\n" . 
						"										</div>\n" . 
						"										<div class=\"col-sm-4\">\n" . 
						"											<input type=\"text\" id=\"from_lastname\" name=\"from_lastname\" value=\"" . (isset($_POST['from_lastname']) ? $from_lastname : $maindata['lastname']) . "\" class=\"form-control" . $inp_from_lastname . "\" placeholder=\"Nachname\" />\n" . 
						"										</div>\n" . 
						"									</div>\n" . 

						"									<div class=\"form-group row\">\n" . 
						"										<div class=\"col-sm-9\">\n" . 
						"											<input type=\"text\" id=\"shipping_from_route\" name=\"from_street\" value=\"" . (isset($_POST['from_street']) ? $from_street : $maindata['street']) . "\" class=\"form-control" . $inp_from_street . "\" placeholder=\"Straße\" />\n" . 
						"										</div>\n" . 
						"										<div class=\"col-sm-3\">\n" . 
						"											<input type=\"text\" id=\"shipping_from_street_number\" name=\"from_streetno\" value=\"" . (isset($_POST['from_streetno']) ? $from_streetno : $maindata['streetno']) . "\" class=\"form-control" . $inp_from_streetno . "\" placeholder=\"Nr\" />\n" . 
						"										</div>\n" . 
						"									</div>\n" . 

						"									<div class=\"form-group row\">\n" . 
						"										<div class=\"col-sm-4\">\n" . 
						"											<input type=\"text\" id=\"shipping_from_postal_code\" name=\"from_zipcode\" value=\"" . (isset($_POST['from_zipcode']) ? $from_zipcode : $maindata['zipcode']) . "\" class=\"form-control" . $inp_from_zipcode . "\" placeholder=\"Postleitzahl\" />\n" . 
						"										</div>\n" . 
						"										<div class=\"col-sm-4\">\n" . 
						"											<input type=\"text\" id=\"shipping_from_locality\" name=\"from_city\" value=\"" . (isset($_POST['from_city']) ? $from_city : $maindata['city']) . "\" class=\"form-control" . $inp_from_city . "\" placeholder=\"Ort\" />\n" . 
						"										</div>\n" . 
						"										<div class=\"col-sm-4\">\n" . 
						"											<select id=\"shipping_from_country\" name=\"from_country\" class=\"custom-select\">" . $countries_options_from . "</select>\n" . 
						"										</div>\n" . 
						"									</div>\n" . 

						"									<div class=\"form-group row\">\n" . 
						"										<div class=\"col-sm-4\">\n" . 
						"											<input type=\"text\" id=\"from_email\" name=\"from_email\" value=\"" . (isset($_POST['from_email']) ? $from_email : $maindata['email']) . "\" class=\"form-control" . $inp_from_email . "\" placeholder=\"Email\" />\n" . 
						"										</div>\n" . 
						"										<div class=\"col-sm-4\">\n" . 
						"											<input type=\"text\" id=\"from_mobilnumber\" name=\"from_mobilnumber\" value=\"" . (isset($_POST['from_mobilnumber']) ? $from_mobilnumber : $maindata['mobilnumber']) . "\" class=\"form-control" . $inp_from_mobilnumber . "\" placeholder=\"Mobil\" />\n" . 
						"										</div>\n" . 
						"										<div class=\"col-sm-4\">\n" . 
						"											<input type=\"text\" id=\"from_phonenumber\" name=\"from_phonenumber\" value=\"" . (isset($_POST['from_phonenumber']) ? $from_phonenumber : $maindata['phonenumber']) . "\" class=\"form-control" . $inp_from_phonenumber . "\" placeholder=\"Festnetz\" />\n" . 
						"										</div>\n" . 
						"									</div>\n" . 

						"								</div>\n" . 
						"							</div>\n" . 

						"						</div>\n" . 
						"						<div class=\"col-sm-6\">\n" . 

						"							<div class=\"form-group row m-1\">\n" . 
						"								<div class=\"col-sm-12 bg-light border\">\n" . 

						"									<div class=\"form-group row mt-3\">\n" . 
						"										<div class=\"col-sm-12\">\n" . 
						"											<strong>Empfänger</strong>\n" . 
						"										</div>\n" . 
						"									</div>\n" . 

						"									<div class=\"form-group row\">\n" . 
						"										<div class=\"col-sm-12\">\n" . 
						"											<input type=\"text\" id=\"to_companyname\" name=\"to_companyname\" value=\"" . (isset($_POST['to_companyname']) ? $to_companyname : ($row_order['differing_shipping_address'] == 1 ? $row_order['differing_companyname'] : $row_order['companyname'])) . "\" class=\"form-control" . $inp_to_companyname . "\" placeholder=\"Firma\" />\n" . 
						"										</div>\n" . 
						"									</div>\n" . 

						"									<div class=\"form-group row\">\n" . 
						"										<div class=\"col-sm-4 mt-2\">\n" . 
						"											<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"												<input type=\"radio\" id=\"gender_03\" name=\"to_gender\" value=\"0\"" . ((isset($_POST['to_gender']) ? intval($_POST['to_gender']) : ($row_order['differing_shipping_address'] == 1 ? $row_order["differing_gender"] : $row_order["gender"])) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
						"												<label class=\"custom-control-label\" for=\"gender_03\">\n" . 
						"													Herr\n" . 
						"												</label>\n" . 
						"											</div>\n" . 
						"											<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"												<input type=\"radio\" id=\"gender_13\" name=\"to_gender\" value=\"1\"" . ((isset($_POST['to_gender']) ? intval($_POST['to_gender']) : ($row_order['differing_shipping_address'] == 1 ? $row_order["differing_gender"] : $row_order["gender"])) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
						"												<label class=\"custom-control-label\" for=\"gender_13\">\n" . 
						"													Frau\n" . 
						"												</label>\n" . 
						"											</div>\n" . 
						"										</div>\n" . 
						"										<div class=\"col-sm-4\">\n" . 
						"											<input type=\"text\" id=\"to_firstname\" name=\"to_firstname\" value=\"" . (isset($_POST['to_firstname']) ? $to_firstname : ($row_order['differing_shipping_address'] == 1 ? ($row_order['differing_firstname'] == "" && $row_order['differing_lastname'] == "" ? $row_order['differing_companyname'] : $row_order['differing_firstname']) : ($row_order['firstname'] == "" && $row_order['lastname'] == "" ? $row_order['companyname'] : $row_order['firstname']))) . "\" class=\"form-control" . $inp_to_firstname . "\" placeholder=\"Vorname\" />\n" . 
						"										</div>\n" . 
						"										<div class=\"col-sm-4\">\n" . 
						"											<input type=\"text\" id=\"to_lastname\" name=\"to_lastname\" value=\"" . (isset($_POST['to_lastname']) ? $to_lastname : ($row_order['differing_shipping_address'] == 1 ? $row_order['differing_lastname'] : $row_order['lastname'])) . "\" class=\"form-control" . $inp_to_lastname . "\" placeholder=\"Nachname\" />\n" . 
						"										</div>\n" . 
						"									</div>\n" . 

						"									<div class=\"form-group row\">\n" . 
						"										<div class=\"col-sm-9\">\n" . 
						"											<input type=\"text\" id=\"shipping_to_route\" name=\"to_street\" value=\"" . (isset($_POST['to_street']) ? $to_street : ($row_order['differing_shipping_address'] == 1 ? $row_order['differing_street'] : $row_order['street'])) . "\" class=\"form-control" . $inp_to_street . "\" placeholder=\"Straße\" />\n" . 
						"										</div>\n" . 
						"										<div class=\"col-sm-3\">\n" . 
						"											<input type=\"text\" id=\"shipping_to_street_number\" name=\"to_streetno\" value=\"" . (isset($_POST['to_streetno']) ? $to_streetno : ($row_order['differing_shipping_address'] == 1 ? $row_order['differing_streetno'] : $row_order['streetno'])) . "\" class=\"form-control" . $inp_to_streetno . "\" placeholder=\"Nr\" />\n" . 
						"										</div>\n" . 
						"									</div>\n" . 

						"									<div class=\"form-group row\">\n" . 
						"										<div class=\"col-sm-4\">\n" . 
						"											<input type=\"text\" id=\"shipping_to_postal_code\" name=\"to_zipcode\" value=\"" . (isset($_POST['to_zipcode']) ? $to_zipcode : ($row_order['differing_shipping_address'] == 1 ? $row_order['differing_zipcode'] : $row_order['zipcode'])) . "\" class=\"form-control" . $inp_to_zipcode . "\" placeholder=\"Postleitzahl\" />\n" . 
						"										</div>\n" . 
						"										<div class=\"col-sm-4\">\n" . 
						"											<input type=\"text\" id=\"shipping_to_locality\" name=\"to_city\" value=\"" . (isset($_POST['to_city']) ? $to_city : ($row_order['differing_shipping_address'] == 1 ? $row_order['differing_city'] : $row_order['city'])) . "\" class=\"form-control" . $inp_to_city . "\" placeholder=\"Ort\" />\n" . 
						"										</div>\n" . 
						"										<div class=\"col-sm-4\">\n" . 
						"											<select id=\"shipping_to_country\" name=\"to_country\" class=\"custom-select\" onchange=\"$('#update_country').click()\">" . $countries_options_to . "</select>\n" . 
						"										</div>\n" . 
						"									</div>\n" . 

						"									<div class=\"form-group row\">\n" . 
						"										<div class=\"col-sm-4\">\n" . 
						"											<input type=\"text\" id=\"to_email\" name=\"to_email\" value=\"" . (isset($_POST['to_email']) ? $to_email : ($row_order['differing_shipping_address'] == 1 ? $row_order['email'] : $row_order['email'])) . "\" class=\"form-control" . $inp_to_email . "\" placeholder=\"Email\" />\n" . 
						"										</div>\n" . 
						"										<div class=\"col-sm-4\">\n" . 
						"											<input type=\"text\" id=\"to_mobilnumber\" name=\"to_mobilnumber\" value=\"" . (isset($_POST['to_mobilnumber']) ? $to_mobilnumber : ($row_order['differing_shipping_address'] == 1 ? $row_order['mobilnumber'] : $row_order['mobilnumber'])) . "\" class=\"form-control" . $inp_to_mobilnumber . "\" placeholder=\"Mobil\" />\n" . 
						"										</div>\n" . 
						"										<div class=\"col-sm-4\">\n" . 
						"											<input type=\"text\" id=\"to_phonenumber\" name=\"to_phonenumber\" value=\"" . (isset($_POST['to_phonenumber']) ? $to_phonenumber : ($row_order['differing_shipping_address'] == 1 ? $row_order['phonenumber'] : $row_order['phonenumber'])) . "\" class=\"form-control" . $inp_to_phonenumber . "\" placeholder=\"Festnetz\" />\n" . 
						"										</div>\n" . 
						"									</div>\n" . 

						"								</div>\n" . 
						"							</div>\n" . 

						"						</div>\n" . 
						"					</div>\n" . 

						"					<div class=\"form-group row\">\n" . 
						"						<div class=\"col-sm-12\">\n" . 
						"							<hr />\n" . 
						"						</div>\n" . 
						"					</div>\n" . 

						"					<div class=\"form-group row\">\n" . 
						"						<div class=\"col-sm-6\">\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label class=\"col-sm-4 col-form-label\">Referenznummer</label>\n" . 
						"								<div class=\"col-sm-8\">\n" . 
						"									<input type=\"text\" id=\"ref_number\" name=\"ref_number1\" value=\"" . (isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung durchführen" ? strip_tags($_POST['ref_number']) : $row_order['ref_number']) . "\" disabled=\"disabled\" class=\"form-control\" />\n" . 
						"									<input type=\"hidden\" id=\"ref_number1\" name=\"ref_number\" value=\"" . (isset($_POST['new_shipping']) && $_POST['new_shipping'] == "Sendung durchführen" ? strip_tags($_POST['ref_number']) : $row_order['ref_number']) . "\" />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"carriers_services\" class=\"col-sm-4 col-form-label\">Service</label>\n" . 
						"								<div class=\"col-sm-8\">\n" . 
						"									<select id=\"carriers_service\" name=\"carriers_service\" class=\"custom-select\">\n" . 

						$carrier_services_options . 

						"									</select>\n" . 
						"								</div>\n" . 
						"								<div class=\"col-sm-1\">\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"package_template\" class=\"col-sm-4 col-form-label\">Paketvorlage</label>\n" . 
						"								<div class=\"col-sm-8\">\n" . 
						"									<select id=\"package_template\" name=\"package_template\" class=\"custom-select\" onchange=\"\$('#update').click()\">\n" . 

						$carrier_package_templates_options . 

						"									</select>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label class=\"col-sm-4 col-form-label\">Maße / Gewicht</label>\n" . 
						"								<div class=\"col-sm-2\">\n" . 
						"									<input type=\"number\" id=\"length\" name=\"length\" step=\"1\" value=\"" . $length . "\" class=\"form-control\" placeholder=\"Länge\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Länge\" />\n" . 
						"								</div>\n" . 
						"								<div class=\"col-sm-2\">\n" . 
						"									<input type=\"number\" id=\"width\" name=\"width\" step=\"1\" value=\"" . $width . "\" class=\"form-control\" placeholder=\"Breite\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Breite\" />\n" . 
						"								</div>\n" . 
						"								<div class=\"col-sm-2\">\n" . 
						"									<input type=\"number\" id=\"height\" name=\"height\" step=\"1\" value=\"" . $height . "\" class=\"form-control\" placeholder=\"Höhe\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Höhe\" />\n" . 
						"								</div>\n" . 
						"								<div class=\"col-sm-2\">\n" . 
						"									<input type=\"number\" id=\"weight\" name=\"weight\" step=\"0.1\" value=\"" . $weight . "\" class=\"form-control\" placeholder=\"Gewicht\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Gewicht\" />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"						</div>\n" . 
						"						<div class=\"col-sm-6\">\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label class=\"col-sm-4 col-form-label\">Nachnahme</label>\n" . 
						"								<div class=\"col-sm-2\">\n" . 
						"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
						"										<span>" . (isset($_POST['radio_payment']) && $_POST['radio_payment'] ==  1 ? "Ja" : (isset($row_last_paying['id']) && $row_last_paying['radio_payment'] == 1 ? "Ja" : "Nein")) . "</span><input type=\"hidden\" id=\"radio_payment\" name=\"radio_payment\" value=\"1\"" . (isset($_POST['radio_payment']) && $_POST['radio_payment'] ==  1 ? " checked=\"checked\"" : (isset($row_last_paying['id']) && $row_last_paying['radio_payment'] == 1 ? " checked=\"checked\"" : "")) . " class=\"custom-control-input\" onclick=\"if(\$(this).prop('checked') == false){\$('#amount_label').hide();\$('#amount_amount').hide();}else{\$('#amount_label').show();\$('#amount_amount').show();}\" />\n" . 
					/*	"										<label class=\"custom-control-label\" for=\"radio_payment\">\n" . 
						"											Ja\n" . 
						"										</label>\n" . */
						"									</div>\n" . 
						"								</div>\n" . 
						"								<label id=\"amount_label\" class=\"col-sm-2 col-form-label\" style=\"" . ($row_last_paying['radio_payment'] == 0 ? "display: none" : "") . "\" for=\"amount\">Betrag</label>\n" . 
						"								<div id=\"amount_amount\" class=\"col-sm-4\" style=\"" . ($row_last_paying['radio_payment'] == 0 ? "display: none" : "") . "\">\n" . 
						"									<div class=\"input-group\">\n" . 
						"										<input type=\"text\" id=\"amount\" name=\"amount\" value=\"" . (isset($_POST['amount']) ? number_format($amount, 2, ',', '') : (isset($row_last_paying['id']) && $row_last_paying['radio_payment'] == 1 ? number_format(($row_last_paying['price_total']), 2, ',', '') : number_format($row_order['pricemwst'], 2, ',', '')))  . "\" class=\"form-control\" />\n" . 
						"									    <span class=\"input-group-append\">\n" . 
						"											<span class=\"input-group-text\">&euro;</span>\n" . 
						"										</span>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label class=\"col-sm-4 col-form-label\">Versand</label>\n" . 
						"								<div class=\"col-sm-2\">\n" . 
						"									&nbsp;\n" . 
						"								</div>\n" . 
						"								<label class=\"col-sm-2 col-form-label\">zzgl.</label>\n" . 
						"								<div class=\"col-sm-4 mt-2\">\n" . 
						"									" . ($row_last_paying['radio_payment'] == 1 ? number_format($shipping_costs[$row_last_paying['radio_shipping']], 2, ',', '') : "0,00 &euro;") . "\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label class=\"col-sm-4 col-form-label\">Zahlart</label>\n" . 
						"								<div class=\"col-sm-2\">\n" . 
						"									&nbsp;\n" . 
						"								</div>\n" . 
						"								<label class=\"col-sm-2 col-form-label\">zzgl.</label>\n" . 
						"								<div class=\"col-sm-4 mt-2\">\n" . 
						"									" . number_format($payment_costs[$row_last_paying['radio_payment']], 2, ',', '') . " &euro;\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row" . ($carriers_service == "11" ? " d-none" : ($row_last_paying['radio_saturday'] == 1 ? "" : " d-none")) . "\">\n" . 
						"								<label class=\"col-sm-4 col-form-label\">Samstagszuschlag</label>\n" . 
						"								<div class=\"col-sm-2\">\n" . 
						"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
						"										<span>" . ($row_last_paying['radio_saturday'] == 1 ? "Ja" : "Nein") . "</span>\n" . 
						"										<input type=\"hidden\" id=\"radio_saturday\" name=\"radio_saturday\" value=\"1\"" . ($carriers_service == "11" ? "" : ($row_last_paying['radio_saturday'] == 1 ? " checked=\"checked\"" : "")) . " class=\"custom-control-input 1bootstrap-switch\" />\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
						"								<label class=\"col-sm-2 col-form-label\">zzgl.</label>\n" . 
						"								<div class=\"col-sm-4 mt-2\">\n" . 
						"									" . ($carriers_service == "11" ? "0,00 &euro;" : ($row_last_paying['radio_payment'] == 1 ? "8,30 &euro;" : "0,00 &euro;")) . "\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"						</div>\n" . 
						"					</div>\n" . 

						"					<div class=\"row px-0 card-footer\">\n" . 

						"						<div class=\"col-sm-12\">\n" . 
						"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
						"							<button type=\"submit\" name=\"new_shipping\" value=\"Sendung durchführen\" class=\"btn btn-primary\">Sendung durchführen <i class=\"fa fa-truck\" aria-hidden=\"true\"></i></button>\n" . 
						"							<button type=\"submit\" id=\"update\" name=\"update\" value=\"aktualisieren\" class=\"btn btn-success d-none\">aktualisieren</button>\n" . 
						"							<button type=\"submit\" id=\"update_country\" name=\"update_country\" value=\"aktualisieren\" class=\"btn btn-success d-none\">aktualisieren</button>\n" . 
						"						</div>\n" . 

						"					</div>\n" . 

						"				</form>\n";

?>