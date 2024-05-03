<?php 

	$row_packing = mysqli_fetch_array(mysqli_query($conn, "	SELECT 	* 
															FROM 	`packing_packings` 
															WHERE 	`packing_packings`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
															AND 	`packing_packings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

	$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($row_packing['order_id'])) . "'"), MYSQLI_ASSOC);

	$row_last_paying = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders_payings` WHERE `order_orders_payings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_payings`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_packing['order_id'])) . "' ORDER BY CAST(`order_orders_payings`.`time` AS UNSIGNED) DESC limit 0, 1"), MYSQLI_ASSOC);

	$carriers_service = isset($_POST['carriers_service']) ? strip_tags($_POST['carriers_service']) : "11";

	$row_package_template = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `package_templates` WHERE `package_templates`.`id`='" . mysqli_real_escape_string($conn, intval($package_template)) . "'"), MYSQLI_ASSOC);

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

	$arr_devices = array();

	$html_devices_old = "";

	$result = mysqli_query($conn, "	SELECT 		`packing_packings_devices`.`id` AS id, 
												`packing_packings_devices`.`device_id` AS device_id, 
												`packing_packings_devices`.`device_number` AS device_number,  
												`order_orders_devices`.`atot_mode` AS atot_mode, 
												`order_orders_devices`.`at` AS at, 
												`order_orders_devices`.`ot` AS ot 
									FROM 		`packing_packings_devices` `packing_packings_devices` 
									LEFT JOIN	`order_orders_devices` 
									ON			`order_orders_devices`.`id`=`packing_packings_devices`.`device_id` 
									WHERE 		`packing_packings_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									AND 		`packing_packings_devices`.`packing_id`='" . mysqli_real_escape_string($conn, intval($row_packing['id'])) . "' 
									AND 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`packing_packings_devices`.`device_number` AS UNSIGNED) DESC");

	while($row_device = $result->fetch_array(MYSQLI_ASSOC)){
			$html_devices_old .= 	"<div class=\"row mb-4\">\n" . 
									"	<div class=\"col-sm-12\">\n" . 
									"		" . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . "\n" . 
									"	</div>\n" . 
									"</div>\n";
		$arr_devices[$row_device['device_id']] = 1;
	}

	$html_devices_new = "";

	$result = mysqli_query($conn, "	SELECT 		`order_orders_devices`.`id` AS id, 
												`order_orders_devices`.`device_number` AS device_number, 
												`order_orders_devices`.`atot_mode` AS atot_mode, 
												`order_orders_devices`.`at` AS at, 
												`order_orders_devices`.`ot` AS ot 
									FROM 		`order_orders_devices` `order_orders_devices` 
									WHERE 		`order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_packing['order_id'])) . "' 
									AND 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`order_orders_devices`.`device_number` AS UNSIGNED) DESC");

	while($row_device = $result->fetch_array(MYSQLI_ASSOC)){
		if(!isset($arr_devices[$row_device['id']])){
			$html_devices_new .=	"<div class=\"custom-control mt-2\">\n" . 
									"	<label class=\"custom-control-label\" for=\"device_" . $row_device['id'] . "\">\n" . 
									"		" . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . "\n" . 
									"	</label>\n" . 
									"</div>\n";
		}
	}

	$order_extended_items = "";

	$arr_order_extended_items = explode("\r\n", $row_packing['order_extended_items']);

	if($row_packing['order_extended_items'] != ""){

		for($item = 0;$item < count($arr_order_extended_items);$item++){

			$arr_item = explode("|", $arr_order_extended_items[$item]);

			$order_extended_items .= "<i class=\"fa fa-check\" aria-hidden=\"true\"></i> <span>" . $arr_item[1] . "</span><br />\n";

		}

	}

	$order_extended_items = $order_extended_items == "" ? "keine" : $order_extended_items;

	$options_file1 = "";
	$options_file2 = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`file_attachments` 
									WHERE 		`file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`file_attachments`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$options_file1 .= ($row['id'] == $row_packing['file1'] ? $row['name'] : "");
		$options_file2 .= ($row['id'] == $row_packing['file2'] ? $row['name'] : "");

	}

	$options_file1 .= ($options_file1 == "" ? "<span class=\"text-danger\">Kein 1</span>" : "");
	$options_file2 .= ($options_file2 == "" ? "<span class=\"text-danger\">Kein 2</span>" : "");

	$list_files = "";

	$result = mysqli_query($conn, "	SELECT 		*, 
												(SELECT `admin`.`name` AS name FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`=`order_orders_files`.`admin_id`) AS admin_name 
									FROM 		`order_orders_files` 
									WHERE 		`order_orders_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									AND 		`order_orders_files`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
									AND 		`order_orders_files`.`type`<'4' 
									ORDER BY 	CAST(`order_orders_files`.`upd_date` AS UNSIGNED) ASC");

	$i = 0;

	while($row_files = $result->fetch_array(MYSQLI_ASSOC)){

		$list_files .=	"<div class=\"row\">\n" . 
						"	<div class=\"col-sm-9\">\n" . 
						"		" . ($i + 1) . ") <a href=\"/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/document/" . $row_files['file'] . "\" target=\"_blank\">" . substr($row_files['file'], strpos($row_files['file'], "_") + 1) . "</a>\n" . 
						"	</div>\n" . 
						"	<div class=\"col-sm-2\">\n" . 

						"	</div>\n" . 
						"	<div class=\"col-sm-1\">\n" . 
						"	</div>\n" . 
						"</div>\n";

		$i++;

	}

	$options_countries = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`countries` 
									WHERE 		`countries`.`frontend`='1' 
									ORDER BY 	`countries`.`name` ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$options_countries .= "								<option value=\"" . $row['id'] . "\" data-code=\"" . $row['code'] . "\"" . (isset($_POST['packing_user']) && $_POST['packing_user'] == "speichern" ? (intval($country) == $row['id'] ? " selected=\"selected\"" : "") : (intval($row_packing["country"]) == $row['id'] ? " selected=\"selected\"" : "")) . ">" . $row['name'] . "</option>\n";

	}

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<div class=\"row\">\n" . 
				"					<div class=\"col-sm-6\">\n" . 
				"						<h3 class=\"mt-1 mb-0\">Warenausgang ansehen " . $row_packing['packing_number'] . "</h3>\n" . 
				"					</div>\n" . 
				"					<div class=\"col-sm-6 text-right\">\n" . 
				"						<form action=\"" . $packing_action . "\" method=\"post\">\n" . 
				"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
				"							<input type=\"hidden\" name=\"order_id\" value=\"" . intval($row_packing['order_id']) . "\" />\n" . 
				"							<div class=\"btn-group\">\n" . 
				"								<button type=\"submit\" name=\"packing_delete\" value=\"entfernen\" class=\"btn btn-danger\" onclick=\"return confirm('Wollen Sie diesen Eintrag wirklich entfernen?')\">entfernen <i class=\"fa fa-ban\" aria-hidden=\"true\"></i></button>&nbsp;\n" . 
				"								<button type=\"submit\" name=\"error\" value=\"melden\" class=\"btn btn-warning\">melden <i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\"></i></button>&nbsp;\n" . 
				"								<button type=\"submit\" name=\"packing_close\" value=\"schliessen\" class=\"btn btn-secondary\">schliessen <i class=\"fa fa-times\" aria-hidden=\"true\"></i></button>\n" . 
				"							</div>\n" . 
				"						</form>\n" . 
				"					</div>\n" . 
				"				</div>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<h5>Bearbeiten Versandauftrag - Kunde</h5>\n" . 

				"				<div class=\"form-group row\">\n" . 
				"					<label class=\"col-sm-2\">Versandartikel</label>\n" . 
				"					<div class=\"col-sm-2 border-right\">\n" . 

				"						<form action=\"" . $packing_action . "\" method=\"post\">\n" . 

				"							<u>Lager</u><br />\n" . 

				($html_devices_new != "" ? $html_devices_new : "<i class=\"text-danger\">Keine weiteren vorhanden!</i>\n") . 

				"							<br />\n" . 

				"						</form>\n" . 

				"					</div>\n" . 
				"					<div class=\"col-sm-6\">\n" . 

				"						<u>ausgewählt</u>\n" . 

				$html_devices_old . 

				"					</div>\n" . 
				"				</div>\n" . 

				"				<hr />\n" . 

				"				<form action=\"" . $packing_action . "\" method=\"post\" enctype=\"multipart/form-data\" onsubmit=\"var sumsize=0;for(var i=0;i<document.getElementById('file_image').files.length;i++){sumsize+=document.getElementById('file_image').files[i].size;}if(sumsize>(" . (int)ini_get("upload_max_filesize") . "*1024*1024)){alert('Die upload Datengröße ist zu hoch. Es sind nur " . (int)ini_get("upload_max_filesize") . "MB insgesammt erlaubt!');return false;}else{return true;}\">\n" . 
	
				"					<div class=\"row\">\n" . 
				"						<div class=\"col-6 border-right\">\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-6\">Zusatzartikel</label>\n" . 
				"								<div class=\"col-sm-6\">\n" . 

				$order_extended_items . 

				"								</div>\n" . 
				"							</div>\n" . 
	
				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"file_packing\" class=\"col-sm-6 col-form-label\">Beipackzettel</label>\n" . 
				"								<div class=\"col-sm-3\">\n" . 
				"									<span>" . $options_file1 . "</span>\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-3\">\n" . 
				"									<span>" . $options_file2 . "</span>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-6\">&nbsp;</label>\n" . 
				"								<div class=\"col-sm-6\">\n" . 

				($list_files != "" ? $list_files : "<i class=\"text-danger\">Keine!</i>\n") . 

				"								</div>\n" . 
				"							</div>\n" . 
	
				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-6 col-form-label\">Wichtige Information<br />(an den Packtisch)</label>\n" . 
				"								<div class=\"col-sm-6\">\n" . 
				"									<span>" . strip_tags($row_packing['message']) . "</span>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"						</div>\n" . 
				"						<div class=\"col-6\">\n" . 

				"							<div class=\"form-group row mt-3\">\n" . 
				"								<div class=\"col-sm-12\">\n" . 
				"									<strong>Empfänger</strong>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-12\">\n" . 
				"									<div class=\"border px-3 py-2\">" . (isset($_POST['companyname']) ? $companyname : ($row_packing['differing_shipping_address'] == 1 ? $row_packing['differing_companyname'] : $row_packing['companyname'])) . "&nbsp;</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-4 mt-2\">\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"gender_03\" name=\"gender\" value=\"0\"" . ((isset($_POST['gender']) ? intval($_POST['gender']) : ($row_packing['differing_shipping_address'] == 1 ? $row_packing["differing_gender"] : $row_packing["gender"])) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"gender_03\">\n" . 
				"											Herr\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"gender_13\" name=\"gender\" value=\"1\"" . ((isset($_POST['gender']) ? intval($_POST['gender']) : ($row_packing['differing_shipping_address'] == 1 ? $row_packing["differing_gender"] : $row_packing["gender"])) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"gender_13\">\n" . 
				"											Frau\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<div class=\"border px-3 py-2\">" . (isset($_POST['firstname']) ? $firstname : ($row_packing['differing_shipping_address'] == 1 ? ($row_packing['differing_firstname'] == "" && $row_packing['differing_lastname'] == "" ? $row_packing['differing_companyname'] : $row_packing['differing_firstname']) : ($row_packing['firstname'] == "" && $row_packing['lastname'] == "" ? $row_packing['companyname'] : $row_packing['firstname']))) . "&nbsp;</div>\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<div class=\"border px-3 py-2\">" . (isset($_POST['lastname']) ? $lastname : ($row_packing['differing_shipping_address'] == 1 ? $row_packing['differing_lastname'] : $row_packing['lastname'])) . "&nbsp;</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-9\">\n" . 
				"									<div class=\"border px-3 py-2\">" . (isset($_POST['street']) ? $street : ($row_packing['differing_shipping_address'] == 1 ? $row_packing['differing_street'] : $row_packing['street'])) . "&nbsp;</div>\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-3\">\n" . 
				"									<div class=\"border px-3 py-2\">" . (isset($_POST['streetno']) ? $streetno : ($row_packing['differing_shipping_address'] == 1 ? $row_packing['differing_streetno'] : $row_packing['streetno'])) . "&nbsp;</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<div class=\"border px-3 py-2\">" . (isset($_POST['zipcode']) ? $zipcode : ($row_packing['differing_shipping_address'] == 1 ? $row_packing['differing_zipcode'] : $row_packing['zipcode'])) . "&nbsp;</div>\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<div class=\"border px-3 py-2\">" . (isset($_POST['city']) ? $city : ($row_packing['differing_shipping_address'] == 1 ? $row_packing['differing_city'] : $row_packing['city'])) . "&nbsp;</div>\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<select id=\"packing_country\" name=\"country\" class=\"custom-select\">" . $options_countries . "</select>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<div class=\"border px-3 py-2\">" . (isset($_POST['email']) ? $email : ($row_packing['differing_shipping_address'] == 1 ? $row_packing['email'] : $row_packing['email'])) . "&nbsp;</div>\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<div class=\"border px-3 py-2\">" . (isset($_POST['mobilnumber']) ? $mobilnumber : ($row_packing['differing_shipping_address'] == 1 ? $row_packing['mobilnumber'] : $row_packing['mobilnumber'])) . "&nbsp;</div>\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-4\">\n" . 
				"									<div class=\"border px-3 py-2\">" . (isset($_POST['phonenumber']) ? $phonenumber : ($row_packing['differing_shipping_address'] == 1 ? $row_packing['phonenumber'] : $row_packing['phonenumber'])) . "&nbsp;</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\">Nachnahme</label>\n" . 
				"								<div class=\"col-sm-2\">\n" . 
				"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"										<span>" . ($row_packing['radio_payment'] ==  1 ? "Ja" : (isset($row_packing['id']) && $row_packing['radio_payment'] == 1 ? "Ja" : "Nein")) . "</span><div class=\"d-none\"><input type=\"checkbox\" id=\"radio_payment\" name=\"radio_payment\" value=\"1\"" . ($row_packing['radio_payment'] ==  1 ? " checked=\"checked\"" : (isset($row_packing['id']) && $row_packing['radio_payment'] == 1 ? " checked=\"checked\"" : "")) . " class=\"custom-control-input\" onclick=\"if(\$(this).prop('checked') == false){\$('#amount_label').hide();\$('#amount_amount').hide();}else{\$('#amount_label').show();\$('#amount_amount').show();}\" /></div>\n" . 
			/*	"										<label class=\"custom-control-label\" for=\"radio_payment\">\n" . 
				"											Ja\n" . 
				"										</label>\n" . */
				"									</div>\n" . 
				"								</div>\n" . 
				"								<label id=\"amount_label\" class=\"col-sm-2 col-form-label\" style=\"" . ($row_packing['radio_payment'] == 0 ? "display: none" : "") . "\" for=\"amount\">Betrag</label>\n" . 
				"								<div id=\"amount_amount\" class=\"col-sm-4\" style=\"" . ($row_packing['radio_payment'] == 0 ? "display: none" : "") . "\">\n" . 
				"									<div class=\"input-group\">\n" . 
				"										<span>" . (isset($_POST['amount']) ? number_format($amount, 2, ',', '') : (isset($row_packing['id']) && $row_packing['radio_payment'] == 1 ? number_format(($row_packing['price_total']), 2, ',', '') : number_format($row_packing['price_total'], 2, ',', '')))  . "</span>\n" . 
				"									    <span class=\"input-group-append\">\n" . 
				"											<span class=\"input-group-text\">&euro;</span>\n" . 
				"										</span>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label for=\"carriers_services\" class=\"col-sm-4 col-form-label\">Service</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<select id=\"carriers_service\" name=\"carriers_service\" class=\"custom-select\">\n" . 

				"										<option value=\"11\"" . ($row_packing['carriers_service'] == 11 ? " checked=\"checked\"" : "") . ">UPS Standard - 0,00 €</option>\n" . 
				"										<option value=\"65\"" . ($row_packing['carriers_service'] == 65 ? " checked=\"checked\"" : "") . ">UPS Saver - 0,00 €</option>\n" . 

				"									</select>\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-1\">\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\">Maße / Gewicht</label>\n" . 
				"								<div class=\"col-sm-2\">\n" . 
				"									<div class=\"border px-3 py-2\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Länge\">" . $row_packing['length'] . "</div>\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-2\">\n" . 
				"									<div class=\"border px-3 py-2\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Breite\">" . $row_packing['width'] . "</div>\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-2\">\n" . 
				"									<div class=\"border px-3 py-2\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Höhe\">" . $row_packing['height'] . "</div>\n" . 
				"								</div>\n" . 
				"								<div class=\"col-sm-2\">\n" . 
				"									<div class=\"border px-3 py-2\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Gewicht\">" . $row_packing['weight'] . "</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"						</div>\n" . 
				"					</div>\n" . 
	
				"					<div class=\"form-group row mt-3\">\n" . 
				"						<div class=\"col-sm-12 text-center\">\n" . 
				"							&nbsp;\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
	
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-12\">\n" . 
				"							&nbsp;\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
	
				"				</form>\n" . 

				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br />\n" . 
				"<br />\n" . 
				"<br />\n";

?>