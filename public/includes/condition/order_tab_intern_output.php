<?php 

	$options_intern_text_module = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`text_modules` 
									WHERE 		`text_modules`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`text_modules`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$options_intern_text_module .= "								<option value=\"" . $row['id'] . "\" data-text=\"" . str_replace("\r\n", "<br>", $row['text']) . "\" data-tech_info=\"" . str_replace("\r\n", "<br>", $row['tech_info']) . "\" data-price_total=\"" . number_format($row['price_total'], 2, ',', '') . "\" data-radio_paying=\"" . $row['radio_paying'] . "\"" . ($row_order['intern_text_module'] == $row['id'] ? " selected=\"selected\"" : "") . ">" . $row['name'] . "</option>\n";

	}

	$options_countries = "";

	$options_differing_countries = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`countries` 
									WHERE 		`countries`.`frontend`='1' 
									ORDER BY 	`countries`.`name` ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$options_countries .= "								<option value=\"" . $row['id'] . "\" data-code=\"" . $row['code'] . "\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern") || (isset($_POST['intern']) && $_POST['intern'] == "speichern") ? (intval($_POST['country']) == $row['id'] ? " selected=\"selected\"" : "") : (intval($row_order["country"]) == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";

		$options_differing_countries .= "								<option value=\"" . $row['id'] . "\" data-code=\"" . $row['code'] . "\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern") || (isset($_POST['intern']) && $_POST['intern'] == "speichern") ? (intval($_POST['differing_country']) == $row['id'] ? " selected=\"selected\"" : "") : (intval($row_order["differing_country"]) == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";

	}

	$and = "";

	switch($_SESSION["admin"]["roles"]["searchresult_rights"]){

		case 0:
			$and .= "AND `address_addresses`.`admin_id`=" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . " ";
			break;

		case 1:
			$and .= "AND (`address_addresses`.`admin_id`=" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . " OR `address_addresses`.`admin_id`=" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . ") ";
			break;
		
	}

	$options_intern_allocation = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`address_addresses` 
									WHERE 		`address_addresses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									" . $and . " 
									ORDER BY 	`address_addresses`.`shortcut` ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$options_intern_allocation .= "								<option value=\"" . $row['id'] . "\"" . ((isset($_POST['intern']) && $_POST['intern'] == "speichern") || (isset($_POST['intern_history']) && $_POST['intern_history'] == "eintragen") ? ($intern_allocation == $row['id'] ? " selected=\"selected\"" : "") : (intval($row_order["intern_allocation"]) == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['shortcut'] . "</option>\n";

	}

	$options_intern_compare = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`compare_modules` 
									WHERE 		`compare_modules`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	`compare_modules`.`name` ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$options_intern_compare .= "								<option value=\"" . $row['id'] . "\">" . $row['name'] . "</option>\n";

	}

	$row_paying = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS count_payings FROM `order_orders_payings` WHERE `order_orders_payings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_payings`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "'"), MYSQLI_ASSOC);

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
		1 =>  8.30, // Ja
	);
	
	$row_shopping_count = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS count FROM `shopping_shoppings` WHERE `shopping_shoppings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `shopping_shoppings`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "'"), MYSQLI_ASSOC);

	$tabs_contents .= 	($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

						"				<form action=\"" . $order_action . "\" method=\"post\" enctype=\"multipart/form-data\" onsubmit=\"var sumsize=0;for(var i=0;i<document.getElementById('file_image').files.length;i++){sumsize+=document.getElementById('file_image').files[i].size;}if(sumsize>(" . (int)ini_get("upload_max_filesize") . "*1024*1024)){alert('Die upload Datengröße ist zu hoch. Es sind nur " . (int)ini_get("upload_max_filesize") . "MB insgesammt erlaubt!');return false;}else{return true;}\">\n" . 

						"					<div class=\"row\">\n" . 
						"						<div class=\"col-6 border-right\">\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<div class=\"col-sm-12\">\n" . 
						"									<strong>Intern</strong>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"intern_time\" class=\"col-sm-5 col-form-label\">Voraussichtl. Bearbeitungsdauer</label>\n" . 
						"								<div class=\"col-sm-5\">\n" . 
						"									<input type=\"number\" id=\"intern_time\" name=\"intern_time\" min=\"0\" max=\"100\" step=\"1\" value=\"" . (isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $intern_time : $row_order["intern_time"]) . "\" class=\"form-control" . $inp_intern_time . "\" />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<div class=\"col-sm-12\">\n" . 
						"									<hr />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"intern_text_module\" class=\"col-sm-5 col-form-label\">Ergebnis</label>\n" . 
						"								<div class=\"col-sm-5\">\n" . 
						"									<select id=\"intern_text_module\" name=\"intern_text_module\" class=\"custom-select\" onchange=\"if(\$(this).find(':selected').val() == '5'){\$('#div_intern_exchange_instruction').removeClass('d-none');}else{\$('#div_intern_exchange_instruction').addClass('d-none');}\$('#intern_description').val(\$(this).find(':selected').data('text').replace(/<br>/gi, '\\r\\n'));\$('#intern_tech_info').val(\$(this).find(':selected').data('tech_info').replace(/<br>/gi, '\\r\\n'));\$('#intern_price_total').val(\$(this).find(':selected').data('price_total'));if(\$(this).find(':selected').data('radio_paying') == 0){\$('#radio_paying_netto').prop('checked', true);\$('#radio_paying_brutto').prop('checked', false);}else{\$('#radio_paying_netto').prop('checked', false);\$('#radio_paying_brutto').prop('checked', true);}if(\$('#radio_paying_netto').prop('checked') == true){\$('#calculate_data').html('<div class=\'row\'><div class=\'col-sm-3\'>Nettobetrag:<br>MwSt.:<br>Bruttobetrag:<br></div><div class=\'col-sm-3 text-right\'>' + \$('#intern_price_total').val() + ' &euro;<br>' + ((\$('#intern_price_total').val().replace(',', '.') / 100 * \$('#mwst').val()).toFixed(2) + '').replace('.', ',') + ' &euro;<br>' + ((\$('#intern_price_total').val().replace(',', '.') / 100 * parseInt(100 + parseInt(\$('#mwst').val()))).toFixed(2) + '').replace('.', ',') + ' &euro;<br></div></div>');}else{\$('#calculate_data').html('<div class=\'row\'><div class=\'col-sm-3\'>Nettobetrag:<br>MwSt.:<br>Bruttobetrag:<br></div><div class=\'col-sm-3 text-right\'>' + ((\$('#intern_price_total').val().replace(',', '.') / (100 + parseInt(\$('#mwst').val())) * 100).toFixed(2) + '').replace('.', ',') + ' &euro;<br>' + ((\$('#intern_price_total').val().replace(',', '.') / (100 + parseInt(\$('#mwst').val())) * parseInt(\$('#mwst').val())).toFixed(2) + '').replace('.', ',') + ' &euro;<br>' + \$('#intern_price_total').val() + ' &euro;<br></div></div>');}\">\n" . 
						"										<option value=\"0\" data-text=\"\" data-tech_info=\"\" data-price_total=\"" . number_format(0.00, 2, ',', '') . "\" data-radio_paying=\"\"" . ($row_order['intern_text_module'] == 0 ? " selected=\"selected\"" : "") . ">Bitte wählen</option>\n" . 

						$options_intern_text_module . 

						"									</select>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label class=\"col-sm-5 col-form-label\">An Telefonhistorie</label>\n" . 
						"								<div class=\"col-sm-5\">\n" . 
						"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
						"										<input type=\"checkbox\" id=\"intern_to_history\" name=\"intern_to_history\" value=\"1\"" . ((isset($_POST['intern']) && $_POST['intern'] == "speichern" ? 0 : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
						"										<label class=\"custom-control-label\" for=\"intern_to_history\">\n" . 
						"											Ja\n" . 
						"										</label>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"intern_ref_number\" class=\"col-sm-5 col-form-label\">Referenznummer</label>\n" . 
						"								<div class=\"col-sm-5\">\n" . 
						"									<input type=\"text\" id=\"intern_ref_number\" name=\"intern_ref_number1\" value=\"" . (isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $row_order["ref_number"] : $row_order["ref_number"]) . "\" disabled=\"disabled\" class=\"form-control\" />\n" . 
						"									<input type=\"hidden\" id=\"intern_ref_number1\" name=\"intern_ref_number\" value=\"" . (isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $row_order["ref_number"] : $row_order["ref_number"]) . "\" class=\"form-control\" />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"intern_accounting\" class=\"col-sm-5 col-form-label\">Buchhaltung</label>\n" . 
						"								<div class=\"col-sm-5\">\n" . 
						"									<input type=\"text\" id=\"intern_accounting\" name=\"intern_accounting1\" value=\"" . (isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $row_order["ref_number"] : $row_order["ref_number"]) . "\" disabled=\"disabled\" class=\"form-control\" />\n" . 
						"									<input type=\"hidden\" id=\"intern_accounting1\" name=\"intern_accounting\" value=\"" . (isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $row_order["ref_number"] : $row_order["ref_number"]) . "\" class=\"form-control\" />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label class=\"col-sm-5 col-form-label\">Aufnahme Einverständnis 1</label>\n" . 
						"								<div class=\"col-sm-5\">\n" . 
						"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
						"										<input type=\"checkbox\" id=\"intern_acceptance_agreement_1\" name=\"intern_acceptance_agreement_1\" value=\"1\"" . ((isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $intern_acceptance_agreement_1 : $row_order["intern_acceptance_agreement_1"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
						"										<label class=\"custom-control-label\" for=\"intern_acceptance_agreement_1\">\n" . 
						"											Ja\n" . 
						"										</label>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label class=\"col-sm-5 col-form-label\">Mündlicher Vertrag</label>\n" . 
						"								<div class=\"col-sm-5\">\n" . 
						"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
						"										<input type=\"checkbox\" id=\"intern_verbal_contract\" name=\"intern_verbal_contract\" value=\"1\"" . ((isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $intern_verbal_contract : $row_order["intern_verbal_contract"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
						"										<label class=\"custom-control-label\" for=\"intern_verbal_contract\">\n" . 
						"											Ja\n" . 
						"										</label>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"intern_conversation_partner\" class=\"col-sm-5 col-form-label\">Gesprächspartner</label>\n" . 
						"								<div class=\"col-sm-5\">\n" . 
						"									<input type=\"text\" id=\"intern_conversation_partner\" name=\"intern_conversation_partner\" value=\"" . (isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $intern_conversation_partner : $row_order["intern_conversation_partner"]) . "\" class=\"form-control" . $inp_intern_conversation_partner . "\" />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label class=\"col-sm-5 col-form-label\">Versand nach Zahlungseingang</label>\n" . 
						"								<div class=\"col-sm-5\">\n" . 
						"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
						"										<input type=\"checkbox\" id=\"intern_shipping_after_paying\" name=\"intern_shipping_after_paying\" value=\"1\"" . ((isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $intern_shipping_after_paying : $row_order["intern_shipping_after_paying"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
						"										<label class=\"custom-control-label\" for=\"intern_shipping_after_paying\">\n" . 
						"											Ja\n" . 
						"										</label>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label class=\"col-sm-5 col-form-label font-weight-bold text-danger\">Freigabe / Preis OK</label>\n" . 
						"								<div class=\"col-sm-6\">\n" . 
						"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
						"										<input type=\"checkbox\" id=\"intern_release_price\" name=\"intern_release_price\" value=\"1\"" . ((isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $intern_release_price : $row_order["intern_release_price"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
						"										<label class=\"custom-control-label font-weight-bold text-danger\" for=\"intern_release_price\">\n" . 
						"											Ja\n" . 
						"										</label>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label class=\"col-sm-5 col-form-label font-weight-bold text-danger\">Rücknahmebelehrung</label>\n" . 
						"								<div class=\"col-sm-6\">\n" . 
						"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
						"										<input type=\"checkbox\" id=\"intern_redemption_instruction\" name=\"intern_redemption_instruction\" value=\"1\"" . ((isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $intern_redemption_instruction : $row_order["intern_redemption_instruction"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
						"										<label class=\"custom-control-label font-weight-bold text-danger\" for=\"intern_redemption_instruction\">\n" . 
						"											Ja\n" . 
						"										</label>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div id=\"div_intern_exchange_instruction\" class=\"form-group row" . ($row_order['intern_text_module'] != 5 ? " d-none" : "") . "\">\n" . 
						"								<label class=\"col-sm-5 col-form-label font-weight-bold text-danger\">Austauschgeräte Belehrung</label>\n" . 
						"								<div class=\"col-sm-6\">\n" . 
						"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
						"										<input type=\"checkbox\" id=\"intern_exchange_instruction\" name=\"intern_exchange_instruction\" value=\"1\"" . ((isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $intern_exchange_instruction : $row_order["intern_exchange_instruction"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
						"										<label class=\"custom-control-label font-weight-bold text-danger\" for=\"intern_exchange_instruction\">\n" . 
						"											Ja\n" . 
						"										</label>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"intern_birthday\" class=\"col-sm-5 col-form-label\">Geburtstag</label>\n" . 
						"								<div class=\"col-sm-6\">\n" . 
						"									<div class=\"input-group\">\n" . 
						"										<input type=\"text\" id=\"intern_datepicker\" name=\"intern_birthday\" value=\"" .(isset($_POST['intern']) && $_POST['intern'] == "speichern" ? date("d.m.Y", $intern_birthday) : date("d.m.Y", intval($row_order["intern_birthday"]))) . "\" class=\"form-control\" />\n" . 
						"										<div class=\"input-group-append\"><span class=\"input-group-text\">Datum</span></div>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label class=\"col-sm-5 col-form-label\">Aufnahme Einverständnis 2</label>\n" . 
						"								<div class=\"col-sm-6\">\n" . 
						"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
						"										<input type=\"checkbox\" id=\"intern_acceptance_agreement_2\" name=\"intern_acceptance_agreement_2\" value=\"1\"" . ((isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $intern_acceptance_agreement_2 : $row_order["intern_acceptance_agreement_2"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
						"										<label class=\"custom-control-label\" for=\"intern_acceptance_agreement_2\">\n" . 
						"											Ja\n" . 
						"										</label>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<div class=\"col-sm-12\">\n" . 
						"									<strong>Rechnungsanschrift</strong>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<div class=\"col-sm-12\">\n" . 
						"									<input type=\"text\" id=\"companyname\" name=\"companyname\" value=\"" . (isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $companyname : $row_order["companyname"]) . "\" class=\"form-control" . $inp_companyname . "\" placeholder=\"Firma\" />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<div class=\"col-sm-4 mt-2\">\n" . 
						"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"										<input type=\"radio\" id=\"gender_01\" name=\"gender\" value=\"0\"" . ((isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $_POST['gender'] : $row_order["gender"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
						"										<label class=\"custom-control-label\" for=\"gender_01\">\n" . 
						"											Herr\n" . 
						"										</label>\n" . 
						"									</div>\n" . 
						"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"										<input type=\"radio\" id=\"gender_11\" name=\"gender\" value=\"1\"" . ((isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $_POST['gender'] : $row_order["gender"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
						"										<label class=\"custom-control-label\" for=\"gender_11\">\n" . 
						"											Frau\n" . 
						"										</label>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
						"								<div class=\"col-sm-4\">\n" . 
						"									<input type=\"text\" id=\"firstname\" name=\"firstname\" value=\"" . (isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $firstname : $row_order["firstname"]) . "\" class=\"form-control" . $inp_firstname . "\" placeholder=\"Vorname\" />\n" . 
						"								</div>\n" . 
						"								<div class=\"col-sm-4\">\n" . 
						"									<input type=\"text\" id=\"lastname\" name=\"lastname\" value=\"" . (isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $lastname : $row_order["lastname"]) . "\" class=\"form-control" . $inp_lastname . "\" placeholder=\"Nachname\" />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<div class=\"col-sm-9\">\n" . 
						"									<input type=\"text\" id=\"intern_route\" name=\"street\" value=\"" . (isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $street : $row_order["street"]) . "\" class=\"form-control" . $inp_street . "\" placeholder=\"Straße\" />\n" . 
						"								</div>\n" . 
						"								<div class=\"col-sm-3\">\n" . 
						"									<input type=\"text\" id=\"intern_street_number\" name=\"streetno\" value=\"" . (isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $streetno : $row_order["streetno"]) . "\" class=\"form-control" . $inp_streetno . "\" placeholder=\"Nr\" />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<div class=\"col-sm-4\">\n" . 
						"									<input type=\"text\" id=\"intern_postal_code\" name=\"zipcode\" value=\"" . (isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $zipcode : $row_order["zipcode"]) . "\" class=\"form-control" . $inp_zipcode . "\" placeholder=\"Postleitzahl\" />\n" . 
						"								</div>\n" . 
						"								<div class=\"col-sm-4\">\n" . 
						"									<input type=\"text\" id=\"intern_locality\" name=\"city\" value=\"" . (isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $city : $row_order["city"]) . "\" class=\"form-control" . $inp_city . "\" placeholder=\"Ort\" />\n" . 
						"								</div>\n" . 
						"								<div class=\"col-sm-4\">\n" . 
						"									<select id=\"intern_country\" name=\"country\" class=\"custom-select" . $inp_country . "\">\n" . 
						$options_countries . 
						"									</select>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<div class=\"col-sm-4\">\n" . 
						"									<input type=\"text\" id=\"email\" name=\"email2\" value=\"" . (isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $email : $row_order["email"]) . "\" class=\"form-control" . $inp_email . "\" placeholder=\"Email\" />\n" . 
						"								</div>\n" . 
						"								<div class=\"col-sm-4\">\n" . 
						"									<input type=\"text\" id=\"mobilnumber\" name=\"mobilnumber2\" value=\"" . (isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $mobilnumber : $row_order["mobilnumber"]) . "\" class=\"form-control" . $inp_mobilnumber . "\" placeholder=\"Mobil\" />\n" . 
						"								</div>\n" . 
						"								<div class=\"col-sm-4\">\n" . 
						"									<input type=\"text\" id=\"phonenumber\" name=\"phonenumber2\" value=\"" . (isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $phonenumber : $row_order["phonenumber"]) . "\" class=\"form-control" . $inp_phonenumber . "\" placeholder=\"Festnetz\" />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label class=\"col-sm-5 col-form-label\">Andere Lieferadresse</label>\n" . 
						"								<div class=\"col-sm-7\">\n" . 
						"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
						"										<input type=\"checkbox\" id=\"differing_shipping_address1\" name=\"differing_shipping_address\" value=\"1\"" . ((isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $differing_shipping_address : $row_order["differing_shipping_address"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" onclick=\"\$('#differing_shipping_address_hide1').toggleClass('d-none').toggleClass('d-block');\" />\n" . 
						"										<label class=\"custom-control-label\" for=\"differing_shipping_address1\">\n" . 
						"											Ja\n" . 
						"										</label>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div id=\"differing_shipping_address_hide1\" class=\"" . ((isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $differing_shipping_address : $row_order["differing_shipping_address"]) == 1 ? "d-block" : "d-none") . "\">\n" . 

						"								<div class=\"form-group row\">\n" . 
						"									<div class=\"col-sm-12\">\n" . 
						"										<input type=\"text\" id=\"differing_companyname\" name=\"differing_companyname\" value=\"" . (isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $differing_companyname : $row_order["differing_companyname"]) . "\" class=\"form-control" . $inp_differing_companyname . "\" placeholder=\"Firma\" />\n" . 
						"									</div>\n" . 
						"								</div>\n" . 

						"								<div class=\"form-group row\">\n" . 
						"									<div class=\"col-sm-4 mt-2\">\n" . 
						"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"											<input type=\"radio\" id=\"differing_gender_01\" name=\"differing_gender\" value=\"0\"" . ((isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $_POST['differing_gender'] : $row_order["differing_gender"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
						"											<label class=\"custom-control-label\" for=\"differing_gender_01\">\n" . 
						"												Herr\n" . 
						"											</label>\n" . 
						"										</div>\n" . 
						"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"											<input type=\"radio\" id=\"differing_gender_11\" name=\"differing_gender\" value=\"1\"" . ((isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $_POST['differing_gender'] : $row_order["differing_gender"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
						"											<label class=\"custom-control-label\" for=\"differing_gender_11\">\n" . 
						"												Frau\n" . 
						"											</label>\n" . 
						"										</div>\n" . 
						"									</div>\n" . 
						"									<div class=\"col-sm-4\">\n" . 
						"										<input type=\"text\" id=\"differing_firstname\" name=\"differing_firstname\" value=\"" . (isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $differing_firstname : $row_order["differing_firstname"]) . "\" class=\"form-control" . $inp_differing_firstname . "\" placeholder=\"Vorname\" />\n" . 
						"									</div>\n" . 
						"									<div class=\"col-sm-4\">\n" . 
						"										<input type=\"text\" id=\"differing_lastname\" name=\"differing_lastname\" value=\"" . (isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $differing_lastname : $row_order["differing_lastname"]) . "\" class=\"form-control" . $inp_differing_lastname . "\" placeholder=\"Nachname\" />\n" . 
						"									</div>\n" . 
						"								</div>\n" . 

						"								<div class=\"form-group row\">\n" . 
						"									<div class=\"col-sm-9\">\n" . 
						"										<input type=\"text\" id=\"intern_differing_route\" name=\"differing_street\" value=\"" . (isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $differing_street : $row_order["differing_street"]) . "\" class=\"form-control" . $inp_differing_street . "\" placeholder=\"Straße\" />\n" . 
						"									</div>\n" . 
						"									<div class=\"col-sm-3\">\n" . 
						"										<input type=\"text\" id=\"intern_differing_street_number\" name=\"differing_streetno\" value=\"" . (isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $differing_streetno : $row_order["differing_streetno"]) . "\" class=\"form-control" . $inp_differing_streetno . "\" placeholder=\"Nr\" />\n" . 
						"									</div>\n" . 
						"								</div>\n" . 

						"								<div class=\"form-group row\">\n" . 
						"									<div class=\"col-sm-4\">\n" . 
						"										<input type=\"text\" id=\"intern_differing_postal_code\" name=\"differing_zipcode\" value=\"" . (isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $differing_zipcode : $row_order["differing_zipcode"]) . "\" class=\"form-control" . $inp_differing_zipcode . "\" placeholder=\"Postleitzahl\" />\n" . 
						"									</div>\n" . 
						"									<div class=\"col-sm-4\">\n" . 
						"										<input type=\"text\" id=\"intern_differing_locality\" name=\"differing_city\" value=\"" . (isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $differing_city : $row_order["differing_city"]) . "\" class=\"form-control" . $inp_differing_city . "\" placeholder=\"Ort\" />\n" . 
						"									</div>\n" . 
						"									<div class=\"col-sm-4\">\n" . 
						"										<select id=\"intern_differing_country\" name=\"differing_country\" class=\"custom-select" . $inp_differing_country . "\">\n" . 
						$options_differing_countries . 
						"										</select>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 

						"							</div>\n" . 

						"						</div>\n" . 
						"						<div class=\"col-6\">\n" . 

						"							<div class=\"form-group row mb-0\">\n" . 
						"								<div class=\"col-sm-11\">\n" . 
						"									<button class=\"btn btn-primary btn-block\" type=\"button\" data-toggle=\"collapse\" data-target=\".multi-collapse\" aria-expanded=\"false\" aria-controls=\"collapsePaying collapseShopping\">Zahlungen / Einkäufe</button>\n" . 
						"								</div>\n" . 
						"								<div class=\"col-sm-1 text-right\">\n" . 
						"								<button type=\"submit\" name=\"refresh_intern\" value=\"aktualisieren\" class=\"btn btn-secondary\"><i class=\"fa fa-refresh\" aria-hidden=\"true\"></i></button>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<div class=\"col-sm-12 mt-0\">\n" . 
						"									<hr />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"collapse multi-collapse show\" id=\"collapsePaying\">\n" . 

						"								<div class=\"form-group row\">\n" . 
						"									<div class=\"col-sm-4\">\n" . 
						"										<strong>Zahlungen:</strong> <span>" . $row_paying['count_payings'] . " Buchungen!</span>\n" . 
						"									</div>\n" . 
						"									<div class=\"col-sm-8 text-right\">\n" . 
						"										&nbsp;\n" . 
						"									</div>\n" . 
						"								</div>\n" . 

						"								<div class=\"form-group row\">\n" . 
						"									<label class=\"col-sm-4 col-form-label\">Zweck</label>\n" . 
						"									<div class=\"col-sm-8 mt-2\">\n" . 
						"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"											<input type=\"radio\" id=\"intern_radio_purpose3\" name=\"intern_radio_purpose\" value=\"2\" checked=\"checked\" class=\"custom-control-input\" />\n" . 
						"											<label class=\"custom-control-label\" for=\"intern_radio_purpose3\">\n" . 
						"												Rechnung\n" . 
						"											</label>\n" . 
						"										</div>\n" . 
						"										<div class=\"custom-control custom-radio d-inline\">\n" . 
						"											<input type=\"radio\" id=\"intern_radio_purpose4\" name=\"intern_radio_purpose\" value=\"3\" class=\"custom-control-input\" />\n" . 
						"											<label class=\"custom-control-label\" for=\"intern_radio_purpose4\">\n" . 
						"												Differenzrechnung\n" . 
						"											</label>\n" . 
						"										</div>\n" . 
						"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"											<input type=\"radio\" id=\"intern_radio_purpose1\" name=\"intern_radio_purpose\" value=\"0\" class=\"custom-control-input\" />\n" . 
						"											<label class=\"custom-control-label\" for=\"intern_radio_purpose1\">\n" . 
						"												Angebot\n" . 
						"											</label>\n" . 
						"										</div>\n" . 
						"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"											<input type=\"radio\" id=\"intern_radio_purpose2\" name=\"intern_radio_purpose\" value=\"1\" class=\"custom-control-input\" />\n" . 
						"											<label class=\"custom-control-label\" for=\"intern_radio_purpose2\">\n" . 
						"												Gutschrift\n" . 
						"											</label>\n" . 
						"										</div>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 

						"								<div class=\"form-group row\">\n" . 
						"									<label class=\"col-sm-4 col-form-label\">Versand</label>\n" . 
						"									<div class=\"col-sm-8 mt-2\">\n" . 
						(
							$_SESSION["admin"]["roles"]["shipping_edit"] == 1 ? 
							"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
							"											<input type=\"radio\" id=\"radio_shipping_standart1\" name=\"radio_shipping\" value=\"1\"" . ((isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $radio_shipping : $row_order["radio_shipping"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" onclick=\"\$('#int_radio_saturday').hide();\$('#intern_radio_saturday0').prop('checked', true);\$('#intern_radio_saturday1').prop('checked', false)\" />\n" . 
							"											<label class=\"custom-control-label text-right\" for=\"radio_shipping_standart1\">\n" . 
							"												Standard<br /><small>5,95 &euro;</small>\n" . 
							"											</label>\n" . 
							"										</div>\n" . 
							"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
							"											<input type=\"radio\" id=\"radio_shipping_express1\" name=\"radio_shipping\" value=\"0\"" . ((isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $radio_shipping : intval($row_order["radio_shipping"])) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" onclick=\"\$('#int_radio_saturday').show()\" />\n" . 
							"											<label class=\"custom-control-label text-right\" for=\"radio_shipping_express1\">\n" . 
							"												Express<br /><small>8,95 &euro;</small>\n" . 
							"											</label>\n" . 
							"										</div>\n" . 
							"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
							"											<input type=\"radio\" id=\"radio_shipping_international1\" name=\"radio_shipping\" value=\"2\"" . ((isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $radio_shipping : $row_order["radio_shipping"]) == 2 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" onclick=\"\$('#int_radio_saturday').hide();\$('#intern_radio_saturday0').prop('checked', true);\$('#intern_radio_saturday1').prop('checked', false)\" />\n" . 
							"											<label class=\"custom-control-label text-right\" for=\"radio_shipping_international1\">\n" . 
							"												International<br /><small>15,00 &euro;</small>\n" . 
							"											</label>\n" . 
							"										</div>\n" . 
							"										<div class=\"custom-control custom-radio d-inline\">\n" . 
							"											<input type=\"radio\" id=\"radio_shipping_self1\" name=\"radio_shipping\" value=\"3\"" . ((isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $radio_shipping : $row_order["radio_shipping"]) == 3 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" onclick=\"\$('#int_radio_saturday').hide();\$('#intern_radio_saturday0').prop('checked', true);\$('#intern_radio_saturday1').prop('checked', false)\" />\n" . 
							"											<label class=\"custom-control-label text-right\" for=\"radio_shipping_self1\">\n" . 
							"												Abholung<br /><small>0,00 &euro;</small>\n" . 
							"											</label>\n" . 
							"										</div>\n" : 
							((isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $radio_shipping : $row_order["radio_shipping"]) == 0 ? "										Expressversand<input type=\"hidden\" name=\"radio_shipping\" value=\"0\" />\n" : "") . 
							((isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $radio_shipping : $row_order["radio_shipping"]) == 1 ? "										Standardversand<input type=\"hidden\" name=\"radio_shipping\" value=\"1\" />\n" : "") . 
							((isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $radio_shipping : $row_order["radio_shipping"]) == 2 ? "										International<input type=\"hidden\" name=\"radio_shipping\" value=\"2\" />\n" : "") . 
							((isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $radio_shipping : $row_order["radio_shipping"]) == 3 ? "										Abholung<input type=\"hidden\" name=\"radio_shipping\" value=\"3\" />\n" : "")
						) . 
						"									</div>\n" . 
						"								</div>\n" . 

						"								<div class=\"form-group row\">\n" . 
						"									<label class=\"col-sm-4 col-form-label text-right\">- Kostenlos</label>\n" . 
						"									<div class=\"col-sm-8 mt-2\">\n" . 
						"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"											<input type=\"radio\" id=\"shipping_free0\" name=\"shipping_free\" value=\"1\" class=\"custom-control-input\" />\n" . 
						"											<label class=\"custom-control-label\" for=\"shipping_free0\">\n" . 
						"												Ja\n" . 
						"											</label>\n" . 
						"										</div>\n" . 
						"										<div class=\"custom-control custom-radio d-inline\">\n" . 
						"											<input type=\"radio\" id=\"shipping_free1\" name=\"shipping_free\" value=\"0\" checked=\"checked\" class=\"custom-control-input\" />\n" . 
						"											<label class=\"custom-control-label\" for=\"shipping_free1\">\n" . 
						"												Nein\n" . 
						"											</label>\n" . 
						"										</div>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 

						"								<div id=\"int_radio_saturday\" class=\"form-group row\" style=\"" . ((isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $radio_shipping : $row_order["radio_shipping"]) == 0 ? "" : "display: none") . "\">\n" . 
						"									<label class=\"col-sm-4 col-form-label\">Samstagszuschlag</label>\n" . 
						"									<div class=\"col-sm-8 mt-2\">\n" . 
						"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"											<input type=\"radio\" id=\"intern_radio_saturday1\" name=\"intern_radio_saturday\" value=\"1\" class=\"custom-control-input\" />\n" . 
						"											<label class=\"custom-control-label\" for=\"intern_radio_saturday1\">\n" . 
						"												Ja<br /><small>8,30 &euro;</small>\n" . 
						"											</label>\n" . 
						"										</div>\n" . 
						"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"											<input type=\"radio\" id=\"intern_radio_saturday0\" name=\"intern_radio_saturday\" value=\"0\" checked=\"checked\" class=\"custom-control-input\" />\n" . 
						"											<label class=\"custom-control-label text-right\" for=\"intern_radio_saturday0\">\n" . 
						"												Nein<br /><small>0,00 &euro;</small>\n" . 
						"											</label>\n" . 
						"										</div>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 

						"								<div class=\"form-group row\">\n" . 
						"									<label class=\"col-sm-4 col-form-label\">Zahlart</label>\n" . 
						"									<div class=\"col-sm-8 mt-2\">\n" . 
						(
							$_SESSION["admin"]["roles"]["payment_edit"] == 1 ? 
							"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
							"											<input type=\"radio\" id=\"radio_payment_nachnahme1\" name=\"radio_payment\" value=\"1\"" . ((isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $radio_payment : $row_order["radio_payment"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
							"											<label class=\"custom-control-label text-right\" for=\"radio_payment_nachnahme1\">\n" . 
							"												Nachnahme<br /><small>8,00 &euro;</small>\n" . 
							"											</label>\n" . 
							"										</div>\n" . 
							"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
							"											<input type=\"radio\" id=\"radio_payment_ueberweisung1\" name=\"radio_payment\" value=\"0\"" . ((isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $radio_payment : $row_order["radio_payment"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
							"											<label class=\"custom-control-label text-right\" for=\"radio_payment_ueberweisung1\">\n" . 
							"												Überweisung<br /><small>0,00 &euro;</small>\n" . 
							"											</label>\n" . 
							"										</div>\n" . 
							"										<div class=\"custom-control custom-radio d-inline\">\n" . 
							"											<input type=\"radio\" id=\"radio_payment_bar1\" name=\"radio_payment\" value=\"2\"" . ((isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $radio_payment : $row_order["radio_payment"]) == 2 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
							"											<label class=\"custom-control-label\" for=\"radio_payment_bar1\">\n" . 
							"												Bar<br /><small>0,00 &euro;</small>\n" . 
							"											</label>\n" . 
							"										</div>\n" : 
							((isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $radio_payment : $row_order["radio_payment"]) == 0 ? "										Überweisung (Sie überweisen den Rechnungsbetrag per Überweisung)<input type=\"hidden\" name=\"radio_payment\" value=\"0\" />\n" : "") . 
							((isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $radio_payment : $row_order["radio_payment"]) == 1 ? "										Nachnahme<input type=\"hidden\" name=\"radio_payment\" value=\"1\" />\n" : "") . 
							((isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $radio_payment : $row_order["radio_payment"]) == 2 ? "										Bar<input type=\"hidden\" name=\"radio_payment\" value=\"2\" />\n" : "")
						) . 
						"									</div>\n" . 
						"								</div>\n" . 

						"								<div class=\"form-group row\">\n" . 
						"									<label class=\"col-sm-4 col-form-label text-right\">- Kostenlos</label>\n" . 
						"									<div class=\"col-sm-8 mt-2\">\n" . 
						"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"											<input type=\"radio\" id=\"payment_free0\" name=\"payment_free\" value=\"1\" class=\"custom-control-input\" />\n" . 
						"											<label class=\"custom-control-label\" for=\"payment_free0\">\n" . 
						"												Ja\n" . 
						"											</label>\n" . 
						"										</div>\n" . 
						"										<div class=\"custom-control custom-radio d-inline\">\n" . 
						"											<input type=\"radio\" id=\"payment_free1\" name=\"payment_free\" value=\"0\" checked=\"checked\" class=\"custom-control-input\" />\n" . 
						"											<label class=\"custom-control-label\" for=\"payment_free1\">\n" . 
						"												Nein\n" . 
						"											</label>\n" . 
						"										</div>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 

						"								<div class=\"form-group row\">\n" . 
						"									<label for=\"intern_price_total\" class=\"col-sm-4 col-form-label\">Gesamtsumme</label>\n" . 
						"									<div class=\"col-sm-3\">\n" . 
						"										<input type=\"hidden\" id=\"mwst\" name=\"mwst\" value=\"" . $maindata['mwst'] . "\" />\n" . 
						"										<input type=\"hidden\" id=\"intern_brutto_netto\" name=\"intern_brutto_netto\" value=\"" . ((isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $intern_radio_paying : $row_order["intern_radio_paying"]) == 0 ? (isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $intern_price_total : $row_order["intern_price_total"]) : (isset($_POST['intern']) && $_POST['intern'] == "speichern" ? number_format($intern_price_total / (100 + $maindata['mwst']) * 100, 2, '.', '') : number_format($row_order["intern_price_total"] / (100 + $maindata['mwst']) * 100, 2, '.', ''))) . "\" />\n" . 
						"										<div class=\"input-group\">\n" . 
						"											<input type=\"text\" id=\"intern_price_total\" name=\"intern_price_total\" value=\"" . (isset($_POST['intern']) && $_POST['intern'] == "speichern" ? number_format($intern_price_total, 2, ',', '') : number_format($row_order["intern_price_total"], 2, ',', '')) . "\" class=\"form-control" . $inp_intern_price_total . "\" onkeyup=\"if(\$('#radio_paying_netto').prop('checked') == true){\$('#intern_brutto_netto').val(\$('#intern_price_total').val().replace(',', '.'));\$('#calculate_data').html('<div class=\'row\'><div class=\'col-sm-3\'>Nettobetrag:<br>MwSt.:<br>Bruttobetrag:<br></div><div class=\'col-sm-3 text-right\'>' + \$('#intern_price_total').val() + ' &euro;<br>' + ((\$('#intern_price_total').val().replace(',', '.') / 100 * \$('#mwst').val()).toFixed(2) + '').replace('.', ',') + ' &euro;<br>' + ((\$('#intern_price_total').val().replace(',', '.') / 100 * parseInt(100 + parseInt(\$('#mwst').val()))).toFixed(2) + '').replace('.', ',') + ' &euro;<br></div></div>');}else{\$('#intern_brutto_netto').val(((\$('#intern_price_total').val().replace(',', '.') / (100 + parseInt(\$('#mwst').val())) * 100).toFixed(2) + ''));\$('#calculate_data').html('<div class=\'row\'><div class=\'col-sm-3\'>Nettobetrag:<br>MwSt.:<br>Bruttobetrag:<br></div><div class=\'col-sm-3 text-right\'>' + ((\$('#intern_price_total').val().replace(',', '.') / (100 + parseInt(\$('#mwst').val())) * 100).toFixed(2) + '').replace('.', ',') + ' &euro;<br>' + ((\$('#intern_price_total').val().replace(',', '.') / (100 + parseInt(\$('#mwst').val())) * parseInt(\$('#mwst').val())).toFixed(2) + '').replace('.', ',') + ' &euro;<br>' + \$('#intern_price_total').val() + ' &euro;<br></div></div>');}\" />\n" . 
						"											<div class=\"input-group-append\"><span class=\"input-group-text\">&euro;</span></div>\n" . 
						"										</div>\n" . 
						"									</div>\n" . 
						"									<div class=\"col-sm-5 mt-1\">\n" . 
						"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"											<input type=\"radio\" id=\"radio_paying_netto\" name=\"intern_radio_paying\" value=\"0\"" . ((isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $intern_radio_paying : $row_order["intern_radio_paying"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" onclick=\"\$('#intern_brutto_netto').val(\$('#intern_price_total').val().replace(',', '.'));\$('#calculate_data').html('<div class=\'row\'><div class=\'col-sm-3\'>Nettobetrag:<br>MwSt.:<br>Bruttobetrag:<br></div><div class=\'col-sm-3 text-right\'>' + \$('#intern_price_total').val() + ' &euro;<br>' + ((\$('#intern_price_total').val().replace(',', '.') / 100 * \$('#mwst').val()).toFixed(2) + '').replace('.', ',') + ' &euro;<br>' + ((\$('#intern_price_total').val().replace(',', '.') / 100 * parseInt(100 + parseInt(\$('#mwst').val()))).toFixed(2) + '').replace('.', ',') + ' &euro;<br></div></div>')\" />\n" . 
						"											<label class=\"custom-control-label\" for=\"radio_paying_netto\">\n" . 
						"												Netto\n" . 
						"											</label>\n" . 
						"										</div>\n" . 
						"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"											<input type=\"radio\" id=\"radio_paying_brutto\" name=\"intern_radio_paying\" value=\"1\"" . ((isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $intern_radio_paying : $row_order["intern_radio_paying"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" onclick=\"\$('#intern_brutto_netto').val(((\$('#intern_price_total').val().replace(',', '.') / (100 + parseInt(\$('#mwst').val())) * 100).toFixed(2) + ''));\$('#calculate_data').html('<div class=\'row\'><div class=\'col-sm-3\'>Nettobetrag:<br>MwSt.:<br>Bruttobetrag:<br></div><div class=\'col-sm-3 text-right\'>' + ((\$('#intern_price_total').val().replace(',', '.') / (100 + parseInt(\$('#mwst').val())) * 100).toFixed(2) + '').replace('.', ',') + ' &euro;<br>' + ((\$('#intern_price_total').val().replace(',', '.') / (100 + parseInt(\$('#mwst').val())) * parseInt(\$('#mwst').val())).toFixed(2) + '').replace('.', ',') + ' &euro;<br>' + \$('#intern_price_total').val() + ' &euro;<br></div></div>')\" />\n" . 
						"											<label class=\"custom-control-label\" for=\"radio_paying_brutto\">\n" . 
						"												Brutto\n" . 
						"											</label>\n" . 
						"										</div>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 

						"								<div class=\"form-group row\">\n" . 
						"									<label class=\"col-sm-4 col-form-label\">&nbsp;</label>\n" . 
						"									<div class=\"col-sm-8\">\n" . 
						"										<div id=\"calculate_data\">\n" . 
						"											<div class=\"row\">\n" . 
						"												<div class=\"col-sm-3\">\n" . 
						"													Nettobetrag:<br />\n" . 
						"													MwSt.:<br />\n" . 
						"													Bruttobetrag:<br />\n" . 
						"												</div>\n" . 
						"												<div class=\"col-sm-3 text-right\">\n" . 
						"													" . (isset($_POST['intern']) && $_POST['intern'] == "speichern" ? number_format(($intern_radio_paying == 0 ? $intern_price_total : $intern_price_total / (100 + $maindata['mwst']) * 100), 2, ',', '') : number_format(($row_order["intern_radio_paying"] == 0 ? $row_order["intern_price_total"] : $row_order["intern_price_total"] / (100 + $maindata['mwst']) * 100), 2, ',', '')) . " &euro;<br />\n" . 
						"													" . (isset($_POST['intern']) && $_POST['intern'] == "speichern" ? number_format(($intern_radio_paying == 0 ? $intern_price_total / 100 * $maindata['mwst'] : $intern_price_total / (100 + $maindata['mwst']) * $maindata['mwst']), 2, ',', '') : number_format(($row_order["intern_radio_paying"] == 0 ? $row_order["intern_price_total"] / 100 * $maindata['mwst'] : $row_order["intern_price_total"] / (100 + $maindata['mwst']) * $maindata['mwst']), 2, ',', '')) . " &euro;<br />\n" . 
						"													" . (isset($_POST['intern']) && $_POST['intern'] == "speichern" ? number_format(($intern_radio_paying == 0 ? $intern_price_total / 100 * (100 + $maindata['mwst']) : $intern_price_total), 2, ',', '') : number_format(($row_order["intern_radio_paying"] == 0 ? $row_order["intern_price_total"] / 100 * (100 + $maindata['mwst']) : $row_order["intern_price_total"]), 2, ',', '')) . " &euro;<br />\n" . 
						"												</div>\n" . 
						"											</div>\n" . 
						"										</div>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 

						"								<div class=\"form-group row\">\n" . 
						"									<label for=\"intern_price_total\" class=\"col-sm-4 col-form-label\">Offener Betrag</label>\n" . 
						"									<div class=\"col-sm-3\">\n" . 
						"										<div class=\"input-group\">\n" . 
						"											<input type=\"text\" name=\"open_sum\" value=\"" . $payings->getSignSum() . "\" class=\"form-control " . ($payings->getSum() >= 0 ? "text-success" : "text-danger") . "\" />\n" . 
						"											<div class=\"input-group-append\"><span class=\"input-group-text\">&euro;</span></div>\n" . 
						"										</div>\n" . 
						"									</div>\n" . 
						"									<div class=\"col-sm-5 mt-1\">\n" . 
						"									</div>\n" . 
						"								</div>\n" . 

						"								<div class=\"form-group row\">\n" . 
						"									<label class=\"col-sm-4 col-form-label\">&nbsp;</label>\n" . 
						"									<div class=\"col-sm-5 mt-2\">\n" . 
						"										<button type=\"submit\" name=\"paying_new\" value=\"neu\" class=\"btn btn-sm btn-primary\">Neue Buchung <i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i></button>&nbsp;&nbsp;&nbsp;\n" . 
						"										<button type=\"button\" value=\"ansehen\" class=\"btn btn-sm btn-success\" onclick=\"\$('#iframeModal_xl > .modal-dialog');\$('#iframeModal_xl div div div .modal-title').text('Zahlungen des Auftrags: " . $row_order['order_number'] . "');\$('#iframeModal_xl div div div iframe').attr('src', '/crm/auftraege/zahlungen/" . $row_order["id"] . "');\$('#iframeModal_xl').modal();\">Buchungen anzeigen <i class=\"fa fa-search-plus\" aria-hidden=\"true\"></i></button>\n" . 
						"									</div>\n" . 
						"									<div class=\"col-sm-3 mt-2\">\n" . 
						"									</div>\n" . 
						"								</div>\n" . 

						"							</div>\n" . 

						"							<div class=\"collapse multi-collapse\" id=\"collapseShopping\">\n" . 

						"								<div class=\"form-group row\">\n" . 
						"									<div class=\"col-sm-4\">\n" . 
						"										<strong>Einkäufe / Retouren:</strong> <span>" . $row_shopping_count['count'] . " Stück!</span>\n" . 
						"									</div>\n" . 
						"									<div class=\"col-sm-8 text-right\">\n" . 
						"										&nbsp;\n" . 
						"									</div>\n" . 
						"								</div>\n" . 

						"								<div class=\"form-group row\">\n" . 
						"									<label class=\"col-sm-4 col-form-label\" for=\"order_number\">Auftragsnummer</label>\n" . 
						"									<div class=\"col-sm-8\">\n" . 
						"										<input type=\"text\" id=\"order_number1\" name=\"order_number1\" value=\"" . $row_order['order_number'] . "\" disabled=\"disabled\" class=\"form-control\" />\n" . 
						"										<input type=\"hidden\" id=\"order_number\" name=\"order_number\" value=\"" . $row_order['order_number'] . "\" />\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
		
						"								<div class=\"form-group row\">\n" . 
						"									<label class=\"col-sm-4 col-form-label\" for=\"mode\">Bereich</label>\n" . 
						"									<div class=\"col-sm-8\">\n" . 
						"										<select id=\"mode\" name=\"mode\" value=\"\" class=\"custom-select\">\n" . 
						"											<option value=\"0\">Einkäufe-Aktive</option>\n" . 
						"											<option value=\"1\">Einkäufe-Archiv</option>\n" . 
						"											<option value=\"2\">Retouren-Aktive</option>\n" . 
						"										</select>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
		
						"								<div class=\"form-group row\">\n" . 
						"									<label class=\"col-sm-4 col-form-label\" for=\"item_number\">Externe Auftragsnummer</label>\n" . 
						"									<div class=\"col-sm-8\">\n" . 
						"										<input type=\"text\" id=\"item_number\" name=\"item_number\" value=\"\" class=\"form-control\" />\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
		
						"								<div class=\"form-group row\">\n" . 
						"									<label class=\"col-sm-4 col-form-label\">Lieferanten</label>\n" . 
						"									<div class=\"col-sm-8 mt-2\">\n" . 
						"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"											<input type=\"radio\" id=\"suppliers_0\" name=\"suppliers\" value=\"0\" class=\"custom-control-input\" />\n" . 
						"											<label class=\"custom-control-label\" for=\"suppliers_0\">\n" . 
						"												eBAY\n" . 
						"											</label>\n" . 
						"										</div>\n" . 
						"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"											<input type=\"radio\" id=\"suppliers_1\" name=\"suppliers\" value=\"1\" class=\"custom-control-input\" />\n" . 
						"											<label class=\"custom-control-label\" for=\"suppliers_1\">\n" . 
						"												Allegro\n" . 
						"											</label>\n" . 
						"										</div>\n" . 
						"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"											<input type=\"radio\" id=\"suppliers_2\" name=\"suppliers\" value=\"2\" class=\"custom-control-input\" />\n" . 
						"											<label class=\"custom-control-label\" for=\"suppliers_2\">\n" . 
						"												Webseite\n" . 
						"											</label>\n" . 
						"										</div>\n" . 
						"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"											<input type=\"radio\" id=\"suppliers_3\" name=\"suppliers\" value=\"3\" class=\"custom-control-input\" />\n" . 
						"											<label class=\"custom-control-label\" for=\"suppliers_3\">\n" . 
						"												Amazon\n" . 
						"											</label>\n" . 
						"										</div>\n" . 
						"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"											<input type=\"radio\" id=\"suppliers_4\" name=\"suppliers\" value=\"4\" class=\"custom-control-input\" />\n" . 
						"											<label class=\"custom-control-label\" for=\"suppliers_4\">\n" . 
						"												Technik\n" . 
						"											</label>\n" . 
						"										</div>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
		
						"								<div class=\"form-group row\">\n" . 
						"									<label class=\"col-sm-4 col-form-label\" for=\"supplier\">Lieferant</label>\n" . 
						"									<div class=\"col-sm-8\">\n" . 
						"										<input type=\"text\" id=\"supplier\" name=\"supplier\" value=\"\" class=\"form-control\" />\n" . 
						"									</div>\n" . 
						"								</div>\n" . 

						"								<div class=\"form-group row\">\n" . 
						"									<label class=\"col-sm-4 col-form-label\" for=\"description\">Beschreibung</label>\n" . 
						"									<div class=\"col-sm-8\">\n" . 
						"										<input type=\"text\" id=\"description\" name=\"description\" value=\"\" class=\"form-control\" />\n" . 
						"									</div>\n" . 
						"								</div>\n" . 

						"								<div class=\"form-group row\">\n" . 
						"									<label class=\"col-sm-4 col-form-label\" for=\"contact_emails\">Angeschrieben</label>\n" . 
						"									<div class=\"col-sm-8\">\n" . 
						"										<input type=\"number\" id=\"contact_emails\" name=\"contact_emails\" min=\"0\" max=\"10000\" step=\"1\" value=\"0\" class=\"form-control\" />\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
		
						"								<div class=\"form-group row\">\n" . 
						"									<label class=\"col-sm-4 col-form-label\" for=\"info\">Info</label>\n" . 
						"									<div class=\"col-sm-8\">\n" . 
						"										<input type=\"text\" id=\"info\" name=\"info\" value=\"\" class=\"form-control\" />\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
		
						"								<div class=\"form-group row\">\n" . 
						"									<label class=\"col-sm-4 col-form-label\" for=\"price\">Preis</label>\n" . 
						"									<div class=\"col-sm-8\">\n" . 
						"										<div class=\"input-group\">\n" . 
						"											<input type=\"text\" id=\"price\" name=\"price\" value=\"0,00\" class=\"form-control\" />\n" . 
						"											<div class=\"input-group-append\"><span class=\"input-group-text\">&euro;</span></div>\n" . 
						"										</div>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
		
						"								<div class=\"form-group row\">\n" . 
						"									<label class=\"col-sm-4 col-form-label\">Zahlart</label>\n" . 
						"									<div class=\"col-sm-8 mt-2\">\n" . 
						"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"											<input type=\"radio\" id=\"radio_payment_0\" name=\"radio_payment\" value=\"0\" class=\"custom-control-input\" />\n" . 
						"											<label class=\"custom-control-label\" for=\"radio_payment_0\">\n" . 
						"												PayPal\n" . 
						"											</label>\n" . 
						"										</div>\n" . 
						"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"											<input type=\"radio\" id=\"radio_payment_1\" name=\"radio_payment\" value=\"1\" class=\"custom-control-input\" />\n" . 
						"											<label class=\"custom-control-label\" for=\"radio_payment_1\">\n" . 
						"												Kreditkarte\n" . 
						"											</label>\n" . 
						"										</div>\n" . 
						"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"											<input type=\"radio\" id=\"radio_payment_2\" name=\"radio_payment\" value=\"2\" class=\"custom-control-input\" />\n" . 
						"											<label class=\"custom-control-label\" for=\"radio_payment_2\">\n" . 
						"												Überweisung\n" . 
						"											</label>\n" . 
						"										</div>\n" . 
						"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"											<input type=\"radio\" id=\"radio_payment_3\" name=\"radio_payment\" value=\"3\" class=\"custom-control-input\" />\n" . 
						"											<label class=\"custom-control-label\" for=\"radio_payment_3\">\n" . 
						"												Rechnung\n" . 
						"											</label>\n" . 
						"										</div>\n" . 
						"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"											<input type=\"radio\" id=\"radio_payment_4\" name=\"radio_payment\" value=\"4\" class=\"custom-control-input\" />\n" . 
						"											<label class=\"custom-control-label\" for=\"radio_payment_4\">\n" . 
						"												Storniert\n" . 
						"											</label>\n" . 
						"										</div>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
		
						"								<div class=\"form-group row\">\n" . 
						"									<label class=\"col-sm-4 col-form-label\" for=\"url\">Link</label>\n" . 
						"									<div class=\"col-sm-8\">\n" . 
						"										<input type=\"text\" id=\"url\" name=\"url\" value=\"\" class=\"form-control\" />\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
		
						"								<div class=\"form-group row\">\n" . 
						"									<label class=\"col-sm-4 col-form-label\" for=\"url\">Screenshot (*.pdf)</label>\n" . 
						"									<div class=\"col-sm-8\">\n" . 
						"										<input type=\"file\" id=\"file_image\" name=\"file_image\" accept=\".pdf\" class=\"form-control\" onchange=\"var sumsize=0;for(var i=0;i<this.files.length;i++){sumsize+=this.files[i].size;}if(sumsize>(" . (int)ini_get("upload_max_filesize") . "*1024*1024)){alert('Die upload Datengröße ist zu hoch. Es sind nur " . (int)ini_get("upload_max_filesize") . "MB insgesammt erlaubt!');}\" />\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
		
						"								<div class=\"form-group row\">\n" . 
						"									<label class=\"col-sm-4 col-form-label\" for=\"email\">Lieferant E-Mail</label>\n" . 
						"									<div class=\"col-sm-8\">\n" . 
						"										<input type=\"text\" id=\"email\" name=\"email\" value=\"\" class=\"form-control\" />\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
		
						"								<div class=\"form-group row\">\n" . 
						"									<label class=\"col-sm-4 col-form-label\" for=\"phonenumber\">Lieferant Telefon</label>\n" . 
						"									<div class=\"col-sm-8\">\n" . 
						"										<input type=\"text\" id=\"phonenumber\" name=\"phonenumber\" value=\"\" class=\"form-control\" />\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
		
						"								<div class=\"form-group row\">\n" . 
						"									<label class=\"col-sm-4 col-form-label\" for=\"faxnumber\">Lieferant Fax</label>\n" . 
						"									<div class=\"col-sm-8\">\n" . 
						"										<input type=\"text\" id=\"faxnumber\" name=\"faxnumber\" value=\"\" class=\"form-control\" />\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
		
						"								<div class=\"form-group row\">\n" . 
						"									<label class=\"col-sm-4 col-form-label\">Retoure Versand</label>\n" . 
						"									<div class=\"col-sm-8 mt-2\">\n" . 
						"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"											<input type=\"radio\" id=\"retoure_carrier_0\" name=\"retoure_carrier\" value=\"0\" class=\"custom-control-input\" />\n" . 
						"											<label class=\"custom-control-label\" for=\"retoure_carrier_0\">\n" . 
						"												DHL\n" . 
						"											</label>\n" . 
						"										</div>\n" . 
						"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"											<input type=\"radio\" id=\"retoure_carrier_1\" name=\"retoure_carrier\" value=\"1\" class=\"custom-control-input\" />\n" . 
						"											<label class=\"custom-control-label\" for=\"retoure_carrier_1\">\n" . 
						"												UPS\n" . 
						"											</label>\n" . 
						"										</div>\n" . 
						"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"											<input type=\"radio\" id=\"retoure_carrier_2\" name=\"retoure_carrier\" value=\"2\" class=\"custom-control-input\" />\n" . 
						"											<label class=\"custom-control-label\" for=\"retoure_carrier_2\">\n" . 
						"												Hermes\n" . 
						"											</label>\n" . 
						"										</div>\n" . 
						"										<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"											<input type=\"radio\" id=\"retoure_carrier_3\" name=\"retoure_carrier\" value=\"3\" class=\"custom-control-input\" />\n" . 
						"											<label class=\"custom-control-label\" for=\"retoure_carrier_3\">\n" . 
						"												DPD\n" . 
						"											</label>\n" . 
						"										</div>\n" . 
							"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"											<input type=\"radio\" id=\"retoure_carrier_4\" name=\"retoure_carrier\" value=\"4\" class=\"custom-control-input\" />\n" . 
						"											<label class=\"custom-control-label\" for=\"retoure_carrier_4\">\n" . 
						"												TNT\n" . 
						"											</label>\n" . 
						"										</div>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
		
						"								<div class=\"form-group row\">\n" . 
						"									<label class=\"col-sm-4 col-form-label\" for=\"shipping_id\">Sendungsnummer</label>\n" . 
						"									<div class=\"col-sm-8\">\n" . 
						"										<input type=\"text\" id=\"shipping_id\" name=\"shipping_id\" value=\"\" class=\"form-control\" />\n" . 
						"									</div>\n" . 
						"								</div>\n" . 

						"								<div class=\"form-group row\">\n" . 
						"									<label class=\"col-sm-4 col-form-label\">&nbsp;</label>\n" . 
						"									<div class=\"col-sm-8 mt-2\">\n" . 
						"										<button type=\"submit\" name=\"shopping_new\" value=\"neu\" class=\"btn btn-sm btn-primary\">Neue/r Einkauf/Retoure <i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i></button>&nbsp;&nbsp;&nbsp;\n" . 
						"										<button type=\"button\" value=\"ansehen\" class=\"btn btn-sm btn-success\" onclick=\"\$('#iframeModal_xl > .modal-dialog');\$('#iframeModal_xl div div div .modal-title').text('Einkäufe / Retouren des Auftrags: " . $row_order['order_number'] . "');\$('#iframeModal_xl div div div iframe').attr('src', '/crm/auftraege/einkaeufe/" . $row_order["id"] . "');\$('#iframeModal_xl').modal();\">Einkäufe/Retouren anzeigen <i class=\"fa fa-search-plus\" aria-hidden=\"true\"></i></button>\n" . 
						"									</div>\n" . 
						"									<div class=\"col-sm-3 mt-2\">\n" . 
						"									</div>\n" . 
						"								</div>\n" . 

						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<div class=\"col-sm-12 mt-2\">\n" . 
						"									<hr />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"intern_compare\" class=\"col-sm-4 col-form-label\">Vergleich</label>\n" . 
						"								<div class=\"col-sm-3\">\n" . 
						"									<select id=\"intern_compare_text\" name=\"intern_compare_text\" class=\"custom-select" . $inp_intern_compare_text . "\">\n" . 
						"										<option value=\"0\">Bitte wählen</option>\n" . 
						$options_intern_compare . 
						"									</select>\n" . 
						"								</div>\n" . 
						"								<div class=\"col-sm-3\">\n" . 
						"									<div class=\"input-group\">\n" . 
						"										<input type=\"text\" id=\"intern_compare_price\" name=\"intern_compare_price\" value=\"" . (isset($_POST['intern_compare_save']) && $_POST['intern_compare_save'] == "speichern" ? number_format($intern_compare_price, 2, ',', '')  : "0,00") . "\" class=\"form-control" . $inp_intern_compare_price . "\" />\n" . 
						"										<div class=\"input-group-append\"><span class=\"input-group-text\">&euro;</span></div>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
						"								<div class=\"col-sm-2 mt-1\">\n" . 
						"									<button type=\"submit\" name=\"intern_compare_save\" value=\"speichern\" class=\"btn btn-sm btn-primary\">speichern <i class=\"fa fa-arrow-right\" aria-hidden=\"true\"></i></button>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<div class=\"col-sm-12 mt-2\">\n" . 
						"									<hr />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"intern_note\" class=\"col-sm-4 col-form-label\">Interner Vermerk</label>\n" . 
						"								<div class=\"col-sm-6\">\n" . 
						"									<textarea id=\"intern_note\" name=\"intern_note\" style=\"height: 300px\" class=\"form-control" . $inp_intern_note . "\">" . (isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $intern_note : $row_order["intern_note"]) . "</textarea>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"intern_text_module\" class=\"col-sm-10 col-form-label\">Textbaustein</label>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<div class=\"col-sm-10\">\n" . 
						"									<textarea id=\"intern_description\" name=\"intern_description\" class=\"form-control" . $inp_intern_description . "\">" . (isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $intern_description : $row_order["intern_description"]) . "</textarea>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"intern_text_module\" class=\"col-sm-10 col-form-label\">Technikerinfo</label>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<div class=\"col-sm-10\">\n" . 
						"									<textarea id=\"intern_tech_info\" name=\"intern_tech_info\" class=\"form-control" . $inp_intern_tech_info . "\">" . (isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $intern_tech_info : $row_order["intern_tech_info"]) . "</textarea>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"intern_allocation\" class=\"col-sm-4 col-form-label\">Zuteilung</label>\n" . 
						"								<div class=\"col-sm-3\">\n" . 
						"									<select id=\"intern_allocation\" name=\"intern_allocation\" class=\"custom-select" . $inp_intern_allocation . "\">\n" . 
						"										<option value=\"0\">Bitte wählen</option>\n" . 
						$options_intern_allocation . 
						"									</select>\n" . 
						"								</div>\n" . 
						"								<div class=\"col-sm-3\">\n" . 
						"									<input type=\"text\" id=\"intern_info\" name=\"intern_info\" value=\"" . (isset($_POST['intern']) && $_POST['intern'] == "speichern" ? $intern_info : $row_order["intern_info"]) . "\" class=\"form-control" . $inp_intern_info . "\" />\n" . 
						"								</div>\n" . 
						"								<div class=\"col-sm-2 mt-1\">\n" . 
						"									<button type=\"submit\" name=\"intern_history\" value=\"eintragen\" class=\"btn btn-sm btn-primary\">eintragen <i class=\"fa fa-arrow-right\" aria-hidden=\"true\"></i></button>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"						</div>\n" . 
						"					</div>\n" . 

						"					<div class=\"row px-0 card-footer\">\n" . 
						"						<div class=\"col-sm-6\">\n" . 
						"							<button type=\"submit\" name=\"intern\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
						"						</div>\n" . 
						"						<div class=\"col-sm-6 text-right\">\n" . 
						"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
						"							<button type=\"submit\" name=\"move\" value=\"Buchhaltung\" class=\"btn btn-danger\" onclick=\"return confirm('Wollen Sie den Eintrag wircklich in die Buchhaltung übertragen?')\"" . ($row_order['booking'] > 0 ? " disabled=\"disabled\"" : "") . ">Buchhaltung <i class=\"fa fa-book\" aria-hidden=\"true\"></i></button>\n" . 
						"						</div>\n" . 
						"					</div>\n" . 

						"				</form>\n";

?>