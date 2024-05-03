<?php 

	$row_devices_count = mysqli_fetch_array(mysqli_query($conn, "	SELECT 		COUNT(*) AS count 
																	FROM		`order_orders_devices` 
																	WHERE		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																	AND 		`order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
																	AND 		`order_orders_devices`.`storage_space_id`>'0' 
																	AND 		`order_orders_devices`.`is_send`='0'"), MYSQLI_ASSOC);

	$html_devices_photo = "";

	$result = mysqli_query($conn, "	SELECT 		`order_orders_devices`.`id` AS id, 
												`order_orders_devices`.`device_number` AS device_number, 
												`order_orders_devices`.`atot_mode` AS atot_mode, 
												`order_orders_devices`.`at` AS at, 
												`order_orders_devices`.`ot` AS ot 
									FROM 		`order_orders_devices` `order_orders_devices` 
									WHERE 		`order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
									AND 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									AND 		`order_orders_devices`.`storage_space_id`>'0' 
									AND 		`order_orders_devices`.`is_photo`='0' 
									AND 		`order_orders_devices`.`is_labeling`='0' 
									AND 		`order_orders_devices`.`is_relocate`='0' 
									AND 		`order_orders_devices`.`is_send`='0' 
									ORDER BY 	`order_orders_devices`.`device_number` ASC");

	while($row_device = $result->fetch_array(MYSQLI_ASSOC)){

		$row_intern = mysqli_fetch_array(mysqli_query($conn, "	SELECT	* 
																FROM	`intern_interns` 
																WHERE	`intern_interns`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																AND 	`intern_interns`.`mode`='0' 
																AND 	`intern_interns`.`device_id`='" . mysqli_real_escape_string($conn, intval($row_device['id'])) . "'"), MYSQLI_ASSOC);

		if(isset($row_intern['id']) && $row_intern['id'] > 0){

			//$is_used = true;

		}else{

			$html_devices_photo .=	"<div class=\"custom-control custom-checkbox mt-2\">\n" . 
									"	<input type=\"checkbox\" id=\"device_" . $row_device['id'] . "\" name=\"device_" . $row_device['id'] . "\" value=\"1\" class=\"custom-control-input\">\n" . 
									"	<label class=\"custom-control-label\" for=\"device_" . $row_device['id'] . "\">\n" . 
									"		" . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . "\n" . 
									"	</label>\n" . 
									"</div>\n";

		}

	}

	$html_devices_shipping = "";

	$result = mysqli_query($conn, "	SELECT 		`order_orders_devices`.`id` AS id, 
												`order_orders_devices`.`device_number` AS device_number, 
												`order_orders_devices`.`atot_mode` AS atot_mode, 
												`order_orders_devices`.`at` AS at, 
												`order_orders_devices`.`ot` AS ot 
									FROM 		`order_orders_devices` `order_orders_devices` 
									WHERE 		`order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
									AND 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									AND 		`order_orders_devices`.`storage_space_id`>'0' 
									AND 		`order_orders_devices`.`is_storage`='0' 
									AND 		`order_orders_devices`.`is_shopin_relocate`='0' 
									AND 		`order_orders_devices`.`is_shipping_user`='0' 
									AND 		`order_orders_devices`.`is_shipping_technic`='0' 
									AND 		`order_orders_devices`.`is_shipping_extern`='0' 
									AND 		`order_orders_devices`.`is_send`='0' 
									AND 		`order_orders_devices`.`is_photo`='0' 
									AND 		`order_orders_devices`.`is_labeling`='0' 
									AND 		`order_orders_devices`.`is_relocate`='0' 
									ORDER BY 	`order_orders_devices`.`device_number` ASC");

	while($row_device = $result->fetch_array(MYSQLI_ASSOC)){

		$row_intern = mysqli_fetch_array(mysqli_query($conn, "	SELECT	* 
																FROM	`intern_interns` 
																WHERE	`intern_interns`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																AND 	`intern_interns`.`mode`='0' 
																AND 	`intern_interns`.`device_id`='" . mysqli_real_escape_string($conn, intval($row_device['id'])) . "'"), MYSQLI_ASSOC);

		if(isset($row_intern['id']) && $row_intern['id'] > 0){

			//$is_used = true;

		}else{

			$html_devices_shipping .=	"<div class=\"custom-control custom-checkbox mt-2\">\n" . 
										"	<input type=\"checkbox\" id=\"device_" . $row_device['id'] . "\" name=\"device_" . $row_device['id'] . "\" value=\"1\" class=\"custom-control-input\">\n" . 
										"	<label class=\"custom-control-label\" for=\"device_" . $row_device['id'] . "\">\n" . 
										"		" . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . "\n" . 
										"	</label>\n" . 
										"</div>\n";

		}

	}

	$options_file1 = "<option value=\"0\">Bitte auswählen</option>\n";

	$options_file2 = "<option value=\"0\">Bitte auswählen</option>\n";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`file_attachments` 
									WHERE 		`file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`file_attachments`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$options_file1 .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['file1']) && intval($_POST['file1']) == $row['id'] ? " selected=\"selected\"" : "") . ">" . $row['name'] . "</option>\n";

		$options_file2 .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['file2']) && intval($_POST['file2']) == $row['id'] ? " selected=\"selected\"" : "") . ">" . $row['name'] . "</option>\n";

	}

	$html_devices_relocate = "";

	$result = mysqli_query($conn, "	SELECT 		`order_orders_devices`.`id` AS id, 
												`order_orders_devices`.`admin_id` AS admin_id, 
												`order_orders_devices`.`order_id` AS order_id, 
												`order_orders_devices`.`device_number` AS device_number, 
												`order_orders_devices`.`atot_mode` AS atot_mode, 
												`order_orders_devices`.`at` AS at, 
												`order_orders_devices`.`ot` AS ot, 
												`order_orders_devices`.`manufacturer` AS manufacturer, 
												`order_orders_devices`.`serial` AS serial, 
												`order_orders_devices`.`additional_numbers` AS additional_numbers, 
												`order_orders_devices`.`fromthiscar` AS fromthiscar, 
												`order_orders_devices`.`open_by_user` AS open_by_user, 
												(SELECT `storage_places`.`name` AS s_s_name FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`=`order_orders_devices`.`storage_space_id`) AS storage_space, 
												`order_orders_devices`.`storage_space_id` AS storage_space_id, 
												`order_orders_devices`.`atot_mode` AS atot_mode, 
												`order_orders_devices`.`at` AS at, 
												`order_orders_devices`.`ot` AS ot, 
												`order_orders_devices`.`star` AS star, 
												`order_orders_devices`.`reg_date` AS reg_date, 
												`order_orders_devices`.`upd_date` AS upd_date, 
												(SELECT `reasons`.`name` AS r_name FROM `reasons` WHERE `reasons`.`id`=`order_orders_devices`.`component`) AS reason_name 
									FROM 		`order_orders_devices` 
									WHERE 		`order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
									AND 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									AND 		`order_orders_devices`.`storage_space_id`>'0' 
									AND 		`order_orders_devices`.`is_storage`='0' 
									AND 		`order_orders_devices`.`is_shopin_relocate`='0' 
									AND 		`order_orders_devices`.`is_shipping_user`='0' 
									AND 		`order_orders_devices`.`is_shipping_technic`='0' 
									AND 		`order_orders_devices`.`is_shipping_extern`='0' 
									AND 		`order_orders_devices`.`is_send`='0' 
									AND 		`order_orders_devices`.`is_relocate`='0' 
									ORDER BY 	CAST(`order_orders_devices`.`reg_date` AS UNSIGNED) ASC");
	
	while($row_devices = $result->fetch_array(MYSQLI_ASSOC)){
	
		$row_intern = mysqli_fetch_array(mysqli_query($conn, "	SELECT	* 
																FROM	`intern_interns` 
																WHERE	`intern_interns`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																AND 	`intern_interns`.`mode`='0' 
																AND 	`intern_interns`.`device_id`='" . mysqli_real_escape_string($conn, intval($row_device['id'])) . "'"), MYSQLI_ASSOC);

		if(isset($row_intern['id']) && $row_intern['id'] > 0){

			//$is_used = true;

		}else{

			$html_devices_relocate .= 	"	<tr" . ($row_devices['star'] == 1 ? " class=\"bg-warning text-white\"" : "") . ">\n" . 
										"		<td class=\"text-center\"><small>" . $row_devices['device_number'] . ($row_devices['atot_mode'] == 1 ? "-AT-" . $row_devices['at'] : ($row_devices['atot_mode'] == 2 ? "-ORG-" . $row_devices['ot'] : "")) . "</small></td>\n" . 
										"		<td class=\"text-center\"><small>" . $row_devices['storage_space'] . "</small></td>\n" . 
										"		<td class=\"text-center\">\n" . 
										"			<select id=\"storage_space_id_" . $row_devices['id'] . "\" name=\"storage_space_id_" . $row_devices['id'] . "\" style=\"width: 220px\">\n";

			$options_storage_places = "												<option value=\"0\">Bitte auswählen</option>\n";

			$result_rooms = mysqli_query($conn, "	SELECT 		* 
													FROM 		`storage_rooms` 
													WHERE 		`storage_rooms`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
													ORDER BY 	CAST(`storage_rooms`.`pos` AS UNSIGNED) ASC");

			while($row_room = $result_rooms->fetch_array(MYSQLI_ASSOC)){
				$options_storage_places .= "											<optgroup label=\"" . $row_room['name'] . "\">\n";
				$result_places = mysqli_query($conn, "	SELECT 		* 
														FROM 		`storage_places` 
														WHERE 		`storage_places`.`room_id`='" . mysqli_real_escape_string($conn, intval($row_room['id'])) . "' 
														AND 		`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
														ORDER BY 	CAST(`storage_places`.`pos` AS UNSIGNED) ASC");
				while($row_place = $result_places->fetch_array(MYSQLI_ASSOC)){
					$options_storage_places .= "												<option value=\"" . $row_place['id'] . "\" class=\"text-white " . ($row_place['used'] < $row_place['parts'] ? "bg-success" : "bg-danger") . "\"" . ($row_place['id'] == $row_devices['storage_space_id'] ? " selected=\"selected\"" : "") . ">" . $row_place['name'] . " (" . $row_place['used'] . " von " . $row_place['parts'] . " Teile belegt!)</option>\n";
				}
				$options_storage_places .= "											</optgroup>\n";
			}

			$html_devices_relocate .= 	$options_storage_places . 
	
										"			</select>\n" . 
										"		</td>\n" . 
										"	</tr>\n";

		}

	}

	$technic_addresses_options = "<option value=\"0\">Bitte auswählen</option>\n";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`address_addresses` 
									WHERE 		`address_addresses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	`address_addresses`.`shortcut` ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$technic_addresses_options .= "								<option value=\"" . $row['id'] . "\"" . (isset($_POST['technic_address']) && intval($_POST['technic_address']) == $row['id'] ? " selected=\"selected\"" : "") . ">" . $row['shortcut'] . "</option>\n";

		if(!isset($_POST['packing_technic']) && !isset($_POST['packing_technic_order_history']) && isset($_POST['technic_address']) && intval($_POST['technic_address']) == $row['id']){

			$companyname = $row['companyname'];
			$_POST['gender'] = $row['gender'];
			$firstname = $row['firstname'];
			$lastname = $row['lastname'];
			$street = $row['street'];
			$streetno = $row['streetno'];
			$zipcode = $row['zipcode'];
			$city = $row['city'];
			$country = $row['country'];
			$phonenumber = $row['phonenumber'];
			$mobilnumber = $row['mobilnumber'];
			$email = $row['email'];

		}

	}

	$countries_options_packing = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`countries` 
									WHERE 		`countries`.`frontend`='1' 
									ORDER BY 	`countries`.`name` ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$countries_options_packing .= "								<option value=\"" . $row['id'] . "\" data-code=\"" . $row['code'] . "\"" . ($country == $row['id'] ? " selected=\"selected\"" : "") . ">" . $row['name'] . "</option>\n";
	}

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
		$carriers_service = "11";
		$carriers_services = array(
			'11' => 'UPS Standard - 0,00 €'
		);
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

	$buttons_orderhistory = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`text_history` 
									WHERE 		`text_history`.`enable`='1' 
									AND 		`text_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`text_history`.`pos` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		if($row['area'] == 0){

		}else{

			$buttons_orderhistory .= "								<button type=\"button\" class=\"btn btn-warning btn-sm mb-1\" onclick=\"var space = ($('#message_phonehistory').text() == '' ? '' : ' ');\$('#message_orderhistory').text(\$('#message_orderhistory').text() + space + '" . $row['text'] . "');/*\$('#history_order').click();*/\">" . $row['name'] . " <i class=\"fa fa-arrow-circle-o-up\"> </i></button> \n";

		}

	}

	$script_paste = "";

	$list_order_history = 	"				<div class=\"table-responsive overflow-auto border\" style=\"height: auto\">\n" . 
							"					<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
							"						<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
							"							<th width=\"150\"><strong>Datum</strong></th>\n" . 
							"							<th width=\"180\"><strong>Mitarbeiter</strong></th>\n" . 
							"							<th><strong>Nachricht</strong></th>\n" . 
							"							<th width=\"210\" class=\"text-center\"><strong>Aktion</strong></th>\n" . 
							"						</tr></thead>\n";

	$result = mysqli_query($conn, "	SELECT 		`order_orders_history`.`id` AS id, 
												(
													SELECT 	name 
													FROM 	`admin` `admin` 
													WHERE 	`admin`.`id`=`order_orders_history`.`admin_id` 
													AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
												) AS admin_name, 
												`order_orders_history`.`type` AS type, 
												`order_orders_history`.`message` AS message, 
												`order_orders_history`.`status` AS status, 
												`order_orders_history`.`script` AS script, 
												`order_orders_history`.`time` AS time 
									FROM 		`order_orders_history` `order_orders_history` 
									WHERE 		`order_orders_history`.`order_id`='" . $row_order['id'] . "' 
									AND 		`order_orders_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`order_orders_history`.`time` AS UNSIGNED) DESC");

	while($row_history = $result->fetch_array(MYSQLI_ASSOC)){

		if(isset($_POST['packing_form']) && intval($_POST['packing_form']) == $row_history['type']){
			$script_paste .= "function orders_paste_" . $row_history['id'] . "(){\n" . $row_history['script'] . "}\n";
		}

		$list_order_history .= 	"<tr" . ($row_history['status'] == 0 ? " class=\"bg-transparent text-black\"" : ($row_history['status'] == 1 ? " class=\"bg-danger text-white\"" : ($row_history['status'] == 2 ? " class=\"bg-success text-white\"" : ($row_history['status'] == 3 ? " class=\"bg-warning text-white\"" : "")))) . ">\n" . 
								"	<td>" . date("d.m.Y (H:i)", $row_history['time']) . "</td>\n" . 
								"	<td>" . $row_history['admin_name'] . "</td>\n" . 
								"	<td>" . str_replace("\r\n", " - ", $row_history['message']) . "</td>\n" . 
								"	<td align=\"center\">\n" . 
								"		<form action=\"" . $order_action . "\" method=\"post\" class=\"d-inline\">\n" . 
								"			<input type=\"hidden\" name=\"id\" value=\"" . $row_order['id'] . "\" />\n" . 
								"			<input type=\"hidden\" name=\"history_id\" value=\"" . $row_history['id'] . "\" />\n" . 
								"			<div class=\"btn-group\">\n" . 
								"				" . (isset($_POST['packing_form']) && intval($_POST['packing_form']) == $row_history['type'] ? "<button type=\"button\" name=\"paste_script\" value=\"paste\" class=\"btn btn-sm btn-warning text-light\" data-toggle=\"tooltip\" data-placement=\"left\" data-original-title=\"Daten übertragen\" title=\"\" onclick=\"orders_paste_" . $row_history['id'] . "()\"><i class=\"fa fa-chevron-up\" aria-hidden=\"true\"></i></button>\n" : "\n") . 
								"				<button type=\"submit\" name=\"history_status_order\" value=\"speichern_0\" class=\"btn btn-sm btn-primary text-light\" data-toggle=\"tooltip\" data-placement=\"left\" data-original-title=\"Neutral\" title=\"\"><i class=\"fa fa-comment\" aria-hidden=\"true\"></i></button>\n" . 
								"				<button type=\"submit\" name=\"history_status_order\" value=\"speichern_1\" class=\"btn btn-sm btn-danger\" data-toggle=\"tooltip\" data-placement=\"left\" data-original-title=\"Anweisung\" title=\"\"><i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\"></i></button>\n" . 
								"				<button type=\"submit\" name=\"history_status_order\" value=\"speichern_2\" class=\"btn btn-sm btn-success\" data-toggle=\"tooltip\" data-placement=\"left\" data-original-title=\"Erledigt\" title=\"\"><i class=\"fa fa-check-square\" aria-hidden=\"true\"></i></button>\n" . 
								"			</div>\n" . 
								"		</form>\n" . 
								"		<form action=\"" . $order_action . "\" method=\"post\" class=\"d-inline\">\n" . 
								"			<input type=\"hidden\" name=\"id\" value=\"" . $row_order['id'] . "\" />\n" . 
								"			<input type=\"hidden\" name=\"history_id\" value=\"" . $row_history['id'] . "\" />\n" . 
								"			<div class=\"btn-group\">\n" . 
								"				" . ($_SESSION["admin"]["roles"]["history_message_delete"] == 1 ? "<button type=\"submit\" name=\"history_delete_order\" value=\"X\" class=\"btn btn-sm btn-danger\" data-toggle=\"tooltip\" data-placement=\"left\" data-original-title=\"Entfernen\" title=\"\" onclick=\"return confirm('Sind Sie sicher, das Sie die Nachricht entfernen wollen?')\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></button>\n" : "\n") . 
								"				<button type=\"button\" name=\"show_details\" value=\"DETAILS\" class=\"btn btn-success btn-sm\" data-toggle=\"tooltip\" data-placement=\"left\" data-original-title=\"Details\" title=\"\" onclick=\"showStatussesDialog('" . str_replace("\"", "\\'", str_replace("\n", "", str_replace("\r\n", "<br />", $row_history['message']))) . "', '', '')\"><i class=\"fa fa-search-plus\" aria-hidden=\"true\"></i></button>\n" . 
								"			</div>\n" . 
								"		</form>\n" . 
								"	</td>\n" . 
								"</tr>\n";

	}

	$list_interessent_history = 	"				<div class=\"table-responsive overflow-auto border\" style=\"height: auto\">\n" . 
									"					<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
									"						<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
									"							<th width=\"150\"><strong>Datum</strong></th>\n" . 
									"							<th width=\"180\"><strong>Mitarbeiter</strong></th>\n" . 
									"							<th><strong>Nachricht</strong></th>\n" . 
									"							<th width=\"210\" class=\"text-center\"><strong>Aktion</strong></th>\n" . 
									"						</tr></thead>\n";

	$result = mysqli_query($conn, "	SELECT 		`interested_interesteds_history`.`id` AS id, 
												(
													SELECT 	name 
													FROM 	`admin` `admin` 
													WHERE 	`admin`.`id`=`interested_interesteds_history`.`admin_id` 
													AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
												) AS admin_name, 
												`interested_interesteds_history`.`type` AS type, 
												`interested_interesteds_history`.`message` AS message, 
												`interested_interesteds_history`.`status` AS status, 
												`interested_interesteds_history`.`script` AS script, 
												`interested_interesteds_history`.`time` AS time 
									FROM 		`interested_interesteds_history` `interested_interesteds_history` 
									WHERE 		`interested_interesteds_history`.`interested_id`='" . $row_order['id'] . "' 
									AND 		`interested_interesteds_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`interested_interesteds_history`.`time` AS UNSIGNED) DESC");

	while($row_history = $result->fetch_array(MYSQLI_ASSOC)){

		if(isset($_POST['packing_form']) && intval($_POST['packing_form']) == $row_history['type']){
			$script_paste .= "function interesteds_paste_" . $row_history['id'] . "(){\n" . $row_history['script'] . "}\n";
		}

		$list_interessent_history .= 	"<tr" . ($row_history['status'] == 0 ? " class=\"bg-transparent text-black\"" : ($row_history['status'] == 1 ? " class=\"bg-danger text-white\"" : ($row_history['status'] == 2 ? " class=\"bg-success text-white\"" : ($row_history['status'] == 3 ? " class=\"bg-warning text-white\"" : "")))) . ">\n" . 
										"	<td>" . date("d.m.Y (H:i)", $row_history['time']) . "</td>\n" . 
										"	<td>" . $row_history['admin_name'] . "</td>\n" . 
										"	<td>" . str_replace("\r\n", " - ", $row_history['message']) . "</td>\n" . 
										"	<td align=\"center\">\n" . 
										"		<form action=\"" . $order_action . "\" method=\"post\" class=\"d-inline\">\n" . 
										"			<input type=\"hidden\" name=\"id\" value=\"" . $row_order['id'] . "\" />\n" . 
										"			<input type=\"hidden\" name=\"history_id\" value=\"" . $row_history['id'] . "\" />\n" . 
										"			<div class=\"btn-group\">\n" . 
										"				" . (isset($_POST['packing_form']) && intval($_POST['packing_form']) == $row_history['type'] ? "<button type=\"button\" name=\"paste_script\" value=\"paste\" class=\"btn btn-sm btn-warning text-light\" data-toggle=\"tooltip\" data-placement=\"left\" data-original-title=\"Daten übertragen\" title=\"\" onclick=\"interesteds_paste_" . $row_history['id'] . "()\"><i class=\"fa fa-chevron-up\" aria-hidden=\"true\"></i></button>\n" : "\n") . 
										"				<button type=\"submit\" name=\"history_status_interessent\" value=\"speichern_0\" class=\"btn btn-sm btn-primary text-light\" data-toggle=\"tooltip\" data-placement=\"left\" data-original-title=\"Neutral\" title=\"\"><i class=\"fa fa-comment\" aria-hidden=\"true\"></i></button>\n" . 
										"				<button type=\"submit\" name=\"history_status_interessent\" value=\"speichern_1\" class=\"btn btn-sm btn-danger\" data-toggle=\"tooltip\" data-placement=\"left\" data-original-title=\"Anweisung\" title=\"\"><i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\"></i></button>\n" . 
										"				<button type=\"submit\" name=\"history_status_interessent\" value=\"speichern_2\" class=\"btn btn-sm btn-success\" data-toggle=\"tooltip\" data-placement=\"left\" data-original-title=\"Erledigt\" title=\"\"><i class=\"fa fa-check-square\" aria-hidden=\"true\"></i></button>\n" . 
										"			</div>\n" . 
										"		</form>\n" . 
										"		<form action=\"" . $order_action . "\" method=\"post\" class=\"d-inline\">\n" . 
										"			<input type=\"hidden\" name=\"id\" value=\"" . $row_order['id'] . "\" />\n" . 
										"			<input type=\"hidden\" name=\"history_id\" value=\"" . $row_history['id'] . "\" />\n" . 
										"			<div class=\"btn-group\">\n" . 
										"				" . ($_SESSION["admin"]["roles"]["history_message_delete"] == 1 ? "<button type=\"submit\" name=\"history_delete_interessent\" value=\"X\" class=\"btn btn-sm btn-danger\" data-toggle=\"tooltip\" data-placement=\"left\" data-original-title=\"Entfernen\" title=\"\" onclick=\"return confirm('Sind Sie sicher, das Sie die Nachricht entfernen wollen?')\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></button>\n" : "\n") . 
										"				<button type=\"button\" name=\"show_details\" value=\"DETAILS\" class=\"btn btn-success btn-sm\" data-toggle=\"tooltip\" data-placement=\"left\" data-original-title=\"Details\" title=\"\" onclick=\"showStatussesDialog('" . str_replace("\"", "\\'", str_replace("\n", "", str_replace("\r\n", "<br />", $row_history['message']))) . "', '', '')\"><i class=\"fa fa-search-plus\" aria-hidden=\"true\"></i></button>\n" . 
										"			</div>\n" . 
										"		</form>\n" . 
										"	</td>\n" . 
										"</tr>\n";

	}

	$order_extended_items = "";

	$arr_order_extended_items = explode("\r\n", $maindata['order_extended_items']);

	if($maindata['order_extended_items'] != ""){

		for($item = 0;$item < count($arr_order_extended_items);$item++){

			$arr_item = explode("|", $arr_order_extended_items[$item]);

			$order_extended_items .=	"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
										"										<input type=\"checkbox\" id=\"" . $arr_item[0] . "\" name=\"" . $arr_item[0] . "\" value=\"1\" class=\"custom-control-input\"" . (isset($_POST[$arr_item[0]]) && intval($_POST[$arr_item[0]]) == 1 ? " checked=\"checked\"" : ($arr_item[2] == 1 ? " checked=\"checked\"" : "")) . ">\n" . 
										"										<label class=\"custom-control-label\" for=\"" . $arr_item[0] . "\">\n" . 
										"											" . $arr_item[1] . "\n" . 
										"										</label>\n" . 
										"									</div>\n";

		}

	}

	$tabs_contents .= 	"<script>\n" . 

						$script_paste . 

						"</script>\n" . 
						"				<h4>Packtisch</h4>\n" . 

						"				<form action=\"" . $order_action . "\" method=\"post\">\n" . 
						"					<div class=\"form-group row\">\n" . 
						"						<label class=\"col-sm-3 col-form-label\">Aktion</label>\n" . 
						"						<div class=\"col-sm-2\">\n" . 
						"							<select name=\"packing_form\" class=\"form-control\">\n" . 
						"								<option value=\"0\"" . (isset($_POST['packing_form']) && intval($_POST['packing_form']) == 0 ? " selected=\"selected\"" : "") . ">Bitte wählen</option>\n" . 
						"								<option value=\"1\"" . (isset($_POST['packing_form']) && intval($_POST['packing_form']) == 1 ? " selected=\"selected\"" : "") . ">Neuer Fotoauftrag</option>\n" . 
						"								<option value=\"2\"" . (isset($_POST['packing_form']) && intval($_POST['packing_form']) == 2 ? " selected=\"selected\"" : "") . ">Neuer Umlagerungsauftrag</option>\n" . 
						"								<option value=\"3\"" . (isset($_POST['packing_form']) && intval($_POST['packing_form']) == 3 ? " selected=\"selected\"" : "") . ">Neuer Versandauftrag - Kunde</option>\n" . 
						"								<option value=\"4\"" . (isset($_POST['packing_form']) && intval($_POST['packing_form']) == 4 ? " selected=\"selected\"" : "") . ">Neuer Versandauftrag - Techniker</option>\n" . 
					//	"								<option value=\"5\"" . (isset($_POST['packing_form']) && intval($_POST['packing_form']) == 5 ? " selected=\"selected\"" : "") . ">Umlagerung durchführen</option>\n" . 
						"							</select>\n" . 
						"						</div>\n" . 
						"						<div class=\"col-sm-7\">\n" . 
						"							<input type=\"hidden\" name=\"id\" value=\"" . $row_order['id'] . "\" />\n" . 
						($row_devices_count['count'] == 0 ? 
							"							<span class=\"text-danger\">Keine Geräte verfügbar!</span>\n"
						:
							"							<button type=\"submit\" name=\"new_packing_form\" value=\"auswaehlen\" class=\"btn btn-primary\">auswählen <i class=\"fa fa-check\" aria-hidden=\"true\"></i></button>\n"
						) . 
						"						</div>\n" . 
						"					</div>\n" . 
						"				</form>\n" . 

						"				<hr />\n" . 

						(isset($_POST['packing_form']) && intval($_POST['packing_form']) == 1 ? 
							($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

							"				<h5>Neuer Fotoauftrag</h5>\n" . 
							"				<form action=\"" . $order_action . "\" method=\"post\">\n" . 
							"					<div class=\"form-group row\">\n" . 
							"						<label class=\"col-sm-3 col-form-label\">Geräte fotografieren</label>\n" . 
							"						<div class=\"col-sm-2\">\n" . 

							$html_devices_photo . 

							"						</div>\n" . 
							"						<div class=\"col-sm-7\">\n" . 
							"						</div>\n" . 
							"					</div>\n" . 
							"					<div class=\"form-group row\">\n" . 
							"						<label for=\"message\" class=\"col-sm-3 col-form-label\">Wichtige Information<br />(an den Packtisch)</label>\n" . 
							"						<div class=\"col-sm-5\">\n" . 
							"							<textarea id=\"message\" name=\"message\" class=\"form-control\">" . (isset($_POST['message']) ? strip_tags($_POST['message']) : $message) . "</textarea>\n" . 
							"						</div>\n" . 
							"						<div class=\"col-sm-4\">\n" . 
							"						</div>\n" . 
							"					</div>\n" . 
							"					<div class=\"form-group row\">\n" . 
							"						<div class=\"col-sm-12 text-center\">\n" . 
							"							<input type=\"hidden\" name=\"id\" value=\"" . $row_order['id'] . "\" />\n" . 
							"							<input type=\"hidden\" name=\"packing_form\" value=\"" . intval(isset($_POST['packing_form']) ? $_POST['packing_form'] : 0) . "\" />\n" . 
							"							<button type=\"submit\" name=\"photo\" value=\"speichern\" class=\"btn btn-success\">Als Intern speichern <i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n" . 
							"							<button type=\"submit\" name=\"photo_order_history\" value=\"speichern\" class=\"btn btn-success\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n" . 
							"							<button type=\"submit\" name=\"packing_close\" value=\"schliessen\" class=\"btn btn-danger\">schliessen <i class=\"fa fa-times\" aria-hidden=\"true\"></i></button>\n" . 
							"						</div>\n" . 
							"					</div>\n" . 
							"				</form>\n" . 
							"				<hr />\n"
						:
							""
						) . 

						(isset($_POST['packing_form']) && intval($_POST['packing_form']) == 2 ? 
							($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

							"				<h5>Neuer Umlagerungsauftrag</h5>\n" . 
							"				<form action=\"" . $order_action . "\" method=\"post\">\n" . 
							"					<div class=\"form-group row\">\n" . 
							"						<label class=\"col-sm-3 col-form-label\">Umlagerungsauftrag</label>\n" . 
							"						<div class=\"col-sm-4\">\n" . 

							"							<div class=\"table-responsive overflow-auto border\" style=\"height: auto;width: 510px\">\n" . 
							"								<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
							"									<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
							"										<th width=\"150\" class=\"text-center\"><strong>Gerätenummer</strong></th>\n" . 
							"										<th width=\"120\" class=\"text-center\"><strong>Lagerplatz</strong></th>\n" . 
							"										<th class=\"text-center\"><strong>Zielplatz</strong></th>\n" . 
							"									</tr></thead>\n" . 

							$html_devices_relocate . 

							"								</table>\n" . 
							"							</div>\n" . 

							"						</div>\n" . 
							"					</div>\n" . 
							"					<div class=\"form-group row\">\n" . 
							"						<label for=\"message\" class=\"col-sm-3 col-form-label\">Wichtige Information<br />(an den Packtisch)</label>\n" . 
							"						<div class=\"col-sm-5\">\n" . 
							"							<textarea id=\"message\" name=\"message\" class=\"form-control\">" . (isset($_POST['message']) ? strip_tags($_POST['message']) : $message) . "</textarea>\n" . 
							"						</div>\n" . 
							"						<div class=\"col-sm-4\">\n" . 
							"						</div>\n" . 
							"					</div>\n" . 
							"					<div class=\"form-group row\">\n" . 
							"						<div class=\"col-sm-12 text-center\">\n" . 
							"							<input type=\"hidden\" name=\"id\" value=\"" . $row_order['id'] . "\" />\n" . 
							"							<input type=\"hidden\" name=\"packing_form\" value=\"" . intval(isset($_POST['packing_form']) ? $_POST['packing_form'] : 0) . "\" />\n" . 
							"							<button type=\"submit\" name=\"relocate\" value=\"speichern\" class=\"btn btn-success\">Als Intern speichern <i class=\"fa fa-refresh\" aria-hidden=\"true\"></i></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n" . 
							"							<button type=\"submit\" name=\"relocate_order_history\" value=\"speichern\" class=\"btn btn-success\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n" . 
							"							<button type=\"submit\" name=\"packing_close\" value=\"schliessen\" class=\"btn btn-danger\">schliessen <i class=\"fa fa-times\" aria-hidden=\"true\"></i></button>\n" . 
							"						</div>\n" . 
							"					</div>\n" . 
							"				</form>\n" . 
							"				<hr />\n"
						:
							""
						) . 

						(isset($_POST['packing_form']) && intval($_POST['packing_form']) == 3 ? 
							($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

							(isset($row_last_paying['id']) && $row_last_paying['id'] > 0 ? 
								"				<h5>Neuer Versandauftrag - Kunde</h5>\n" . 
								"				<form action=\"" . $order_action . "\" method=\"post\" enctype=\"multipart/form-data\" onsubmit=\"var sumsize=0;for(var i=0;i<document.getElementById('file_packing').files.length;i++){sumsize+=document.getElementById('file_packing').files[i].size;}if(sumsize>(32*1024*1024)){alert('Die upload Datengröße ist zu hoch. Es sind nur 32MB insgesammt erlaubt!');return false;}else{return true;}\">\n" . 
								"					<div class=\"form-group row\">\n" . 
								"						<div class=\"col-sm-6 border-right\">\n" . 
								"							<div class=\"form-group row\">\n" . 
								"								<label class=\"col-sm-6 col-form-label\">Versandartikel</label>\n" . 
								"								<div class=\"col-sm-6\">\n" . 
	
								$html_devices_shipping . 
	
								"								</div>\n" . 
								"							</div>\n" . 
								"							<div class=\"form-group row\">\n" . 
								"								<label class=\"col-sm-6 col-form-label\">Zusatzartikel</label>\n" . 
								"								<div class=\"col-sm-6\">\n" . 
	
								$order_extended_items . 
	
								"								</div>\n" . 
								"							</div>\n" . 
								"							<div class=\"form-group row\">\n" . 
								"								<label for=\"file_packing\" class=\"col-sm-6 col-form-label\">Beipackzettel</label>\n" . 
								"								<div class=\"col-sm-3\">\n" . 
								"									<select id=\"file1\" name=\"file1\" class=\"custom-select\">" . $options_file1 . "</select>\n" . 
								"								</div>\n" . 
								"								<div class=\"col-sm-3\">\n" . 
								"									<select id=\"file2\" name=\"file2\" class=\"custom-select\">" . $options_file2 . "</select>\n" . 
								"								</div>\n" . 
								"							</div>\n" . 
								"							<div class=\"form-group row\">\n" . 
								"								<label for=\"file_packing\" class=\"col-sm-6 col-form-label\">Zusatz / Dokumente</label>\n" . 
								"								<div class=\"col-sm-6\">\n" . 
								"									<input type=\"file\" id=\"file_packing\" name=\"file[]\" multiple=\"multiple\" accept=\"" . str_replace(", ", ",", $maindata['input_file_accept']) . "\" class=\"form-control\" onchange=\"var sumsize=0;for(var i=0;i<this.files.length;i++){sumsize+=this.files[i].size;}if(sumsize>(" . (int)ini_get("upload_max_filesize") . "*1024*1024)){alert('Die upload Datengröße ist zu hoch. Es sind nur " . (int)ini_get("upload_max_filesize") . "MB insgesammt erlaubt!');}\" />\n" . 
								"								</div>\n" . 
								"							</div>\n" . 
								"							<div class=\"form-group row\">\n" . 
								"								<label class=\"col-sm-6 col-form-label\">Wichtige Information<br />(an den Packtisch)</label>\n" . 
								"								<div class=\"col-sm-6\">\n" . 
								"									<textarea id=\"message\" name=\"message\" class=\"form-control\">" . (isset($_POST['message']) ? strip_tags($_POST['message']) : $message) . "</textarea>\n" . 
								"								</div>\n" . 
								"							</div>\n" . 
								"						</div>\n" . 
								"						<div class=\"col-sm-6\">\n" . 
								"							<div class=\"form-group row\">\n" . 
								"								<div class=\"col-sm-12\">\n" . 
								"									<strong>Empfänger</strong>\n" . 
								"								</div>\n" . 
								"							</div>\n" . 
								"							<div class=\"form-group row\">\n" . 
								"								<div class=\"col-sm-12\">\n" . 
								"									<input type=\"text\" id=\"packing_companyname\" name=\"companyname\" value=\"" . (isset($_POST['companyname']) ? $companyname : ($row_order['differing_shipping_address'] == 1 ? $row_order['differing_companyname'] : $row_order['companyname'])) . "\" class=\"form-control" . $inp_companyname . "\" placeholder=\"Firma\" />\n" . 
								"								</div>\n" . 
								"							</div>\n" . 
								"							<div class=\"form-group row\">\n" . 
								"								<div class=\"col-sm-4 mt-2\">\n" . 
								"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
								"										<input type=\"radio\" id=\"packing_gender_03\" name=\"gender\" value=\"0\"" . ((isset($_POST['gender']) ? intval($_POST['gender']) : ($row_order['differing_shipping_address'] == 1 ? $row_order["differing_gender"] : $row_order["gender"])) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
								"										<label class=\"custom-control-label\" for=\"packing_gender_03\">\n" . 
								"											Herr\n" . 
								"										</label>\n" . 
								"									</div>\n" . 
								"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
								"										<input type=\"radio\" id=\"packing_gender_13\" name=\"gender\" value=\"1\"" . ((isset($_POST['gender']) ? intval($_POST['gender']) : ($row_order['differing_shipping_address'] == 1 ? $row_order["differing_gender"] : $row_order["gender"])) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
								"										<label class=\"custom-control-label\" for=\"packing_gender_13\">\n" . 
								"											Frau\n" . 
								"										</label>\n" . 
								"									</div>\n" . 
								"								</div>\n" . 
								"								<div class=\"col-sm-4\">\n" . 
								"									<input type=\"text\" id=\"packing_firstname\" name=\"firstname\" value=\"" . (isset($_POST['firstname']) ? $firstname : ($row_order['differing_shipping_address'] == 1 ? ($row_order['differing_firstname'] == "" && $row_order['differing_lastname'] == "" ? $row_order['differing_companyname'] : $row_order['differing_firstname']) : ($row_order['firstname'] == "" && $row_order['lastname'] == "" ? $row_order['companyname'] : $row_order['firstname']))) . "\" class=\"form-control" . $inp_firstname . "\" placeholder=\"Vorname\" />\n" . 
								"								</div>\n" . 
								"								<div class=\"col-sm-4\">\n" . 
								"									<input type=\"text\" id=\"packing_lastname\" name=\"lastname\" value=\"" . (isset($_POST['lastname']) ? $lastname : ($row_order['differing_shipping_address'] == 1 ? $row_order['differing_lastname'] : $row_order['lastname'])) . "\" class=\"form-control" . $inp_lastname . "\" placeholder=\"Nachname\" />\n" . 
								"								</div>\n" . 
								"							</div>\n" . 
								"							<div class=\"form-group row\">\n" . 
								"								<div class=\"col-sm-9\">\n" . 
								"									<input type=\"text\" id=\"packing_route\" name=\"street\" value=\"" . (isset($_POST['street']) ? $street : ($row_order['differing_shipping_address'] == 1 ? $row_order['differing_street'] : $row_order['street'])) . "\" class=\"form-control" . $inp_street . "\" placeholder=\"Straße\" />\n" . 
								"								</div>\n" . 
								"								<div class=\"col-sm-3\">\n" . 
								"									<input type=\"text\" id=\"packing_street_number\" name=\"streetno\" value=\"" . (isset($_POST['streetno']) ? $streetno : ($row_order['differing_shipping_address'] == 1 ? $row_order['differing_streetno'] : $row_order['streetno'])) . "\" class=\"form-control" . $inp_streetno . "\" placeholder=\"Nr\" />\n" . 
								"								</div>\n" . 
								"							</div>\n" . 
								"							<div class=\"form-group row\">\n" . 
								"								<div class=\"col-sm-4\">\n" . 
								"									<input type=\"text\" id=\"packing_postal_code\" name=\"zipcode\" value=\"" . (isset($_POST['zipcode']) ? $zipcode : ($row_order['differing_shipping_address'] == 1 ? $row_order['differing_zipcode'] : $row_order['zipcode'])) . "\" class=\"form-control" . $inp_zipcode . "\" placeholder=\"Postleitzahl\" />\n" . 
								"								</div>\n" . 
								"								<div class=\"col-sm-4\">\n" . 
								"									<input type=\"text\" id=\"packing_locality\" name=\"city\" value=\"" . (isset($_POST['city']) ? $city : ($row_order['differing_shipping_address'] == 1 ? $row_order['differing_city'] : $row_order['city'])) . "\" class=\"form-control" . $inp_city . "\" placeholder=\"Ort\" />\n" . 
								"								</div>\n" . 
								"								<div class=\"col-sm-4\">\n" . 
								"									<select id=\"packing_country\" name=\"country\" class=\"custom-select\">" . $options_countries . "</select>\n" . 
								"								</div>\n" . 
								"							</div>\n" . 
								"							<div class=\"form-group row\">\n" . 
								"								<div class=\"col-sm-4\">\n" . 
								"									<input type=\"text\" id=\"packing_email\" name=\"email\" value=\"" . (isset($_POST['email']) ? $email : ($row_order['differing_shipping_address'] == 1 ? $row_order['email'] : $row_order['email'])) . "\" class=\"form-control" . $inp_email . "\" placeholder=\"Email\" />\n" . 
								"								</div>\n" . 
								"								<div class=\"col-sm-4\">\n" . 
								"									<input type=\"text\" id=\"packing_mobilnumber\" name=\"mobilnumber\" value=\"" . (isset($_POST['mobilnumber']) ? $mobilnumber : ($row_order['differing_shipping_address'] == 1 ? $row_order['mobilnumber'] : $row_order['mobilnumber'])) . "\" class=\"form-control" . $inp_mobilnumber . "\" placeholder=\"Mobil\" />\n" . 
								"								</div>\n" . 
								"								<div class=\"col-sm-4\">\n" . 
								"									<input type=\"text\" id=\"packing_phonenumber\" name=\"phonenumber\" value=\"" . (isset($_POST['phonenumber']) ? $phonenumber : ($row_order['differing_shipping_address'] == 1 ? $row_order['phonenumber'] : $row_order['phonenumber'])) . "\" class=\"form-control" . $inp_phonenumber . "\" placeholder=\"Festnetz\" />\n" . 
								"								</div>\n" . 
								"							</div>\n" . 

								"							<div class=\"form-group row\">\n" . 

								"								<label class=\"col-sm-4 col-form-label\">Nachnahme</label>\n" . 
								"								<div class=\"col-sm-2\">\n" . 
								"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
								"										<input type=\"checkbox\" id=\"radio_payment\" name=\"radio_payment\" value=\"1\"" . (isset($_POST['radio_payment']) && $_POST['radio_payment'] == 1 ? " checked=\"checked\"" : ($row_last_paying['radio_payment'] == 1 ? " checked=\"checked\"" : "")) . " class=\"custom-control-input bootstrap-switch\" onchange=\"if(\$(this).prop('checked') == false){\$('#amount_label_user').hide();\$('#amount_amount_user').hide();}else{\$('#amount_label_user').show();\$('#amount_amount_user').show();}\" />\n" . 
								"										<label class=\"custom-control-label\" for=\"radio_payment\">\n" . 
								"											Ja\n" . 
								"										</label>\n" . 
								"									</div>\n" . 
								"								</div>\n" . 
								"								<label id=\"amount_label_user\" class=\"col-sm-2 col-form-label\" style=\"display: none\" for=\"amount\">Betrag</label>\n" . 
								"								<div id=\"amount_amount_user\" class=\"col-sm-4\" style=\"display: none\">\n" . 
								"									<div class=\"input-group\">\n" . 
								"										<input type=\"text\" id=\"amount\" name=\"amount\" value=\"" . (isset($_POST['amount']) ? strip_tags($_POST['amount']) : number_format($payings->getSum(), 2, ',', '')) . "\" class=\"form-control\" />\n" . 
								"									    <span class=\"input-group-append\">\n" . 
								"											<span class=\"input-group-text\">&euro;</span>\n" . 
								"										</span>\n" . 
								"									</div>\n" . 
								"								</div>\n" . 
		
								"							</div>\n" . 

								"							<div class=\"form-group row\">\n" . 

								"								<label class=\"col-sm-4 col-form-label\">Samstagszustellung</label>\n" . 
								"								<div class=\"col-sm-2\">\n" . 
								"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
								"										<input type=\"checkbox\" id=\"radio_saturday\" name=\"radio_saturday\" value=\"1\"" . (isset($_POST['radio_saturday']) && $_POST['radio_saturday'] == 1 ? " checked=\"checked\"" : ($row_last_paying['radio_saturday'] == 1 ? " checked=\"checked\"" : "")) . " class=\"custom-control-input bootstrap-switch\" />\n" . 
								"										<label class=\"custom-control-label\" for=\"radio_saturday\">\n" . 
								"											Ja\n" . 
								"										</label>\n" . 
								"									</div>\n" . 
								"								</div>\n" . 
		
								"							</div>\n" . 

								"							<div class=\"form-group row\">\n" . 
								"								<label for=\"carriers_services\" class=\"col-sm-4 col-form-label\">Service</label>\n" . 
								"								<div class=\"col-sm-8\">\n" . 
								"									<select id=\"packing_carriers_service\" name=\"carriers_service\" class=\"custom-select\">\n" . 
		
								"										<option value=\"11\"" . (isset($_POST['packing_carriers_service']) && $_POST['packing_carriers_service'] == 11 ? " checked=\"checked\"" : "") . ">UPS Standard - 0,00 €</option>\n" . 
								"										<option value=\"65\"" . (isset($_POST['packing_carriers_service']) && $_POST['packing_carriers_service'] == 65 ? " checked=\"checked\"" : "") . ">UPS Saver - 0,00 €</option>\n" . 
		
								"									</select>\n" . 
								"								</div>\n" . 
								"								<div class=\"col-sm-1\">\n" . 
								"								</div>\n" . 
								"							</div>\n" . 
								/*"							<div class=\"form-group row\">\n" . 
								"								<label for=\"package_template\" class=\"col-sm-4 col-form-label\">Paketvorlage</label>\n" . 
								"								<div class=\"col-sm-8\">\n" . 
								"									<select id=\"package_template\" name=\"package_template\" class=\"custom-select\" onchange=\"\$('#update').click()\">\n" . 
		
								$carrier_package_templates_options . 
		
								"									</select>\n" . 
								"								</div>\n" . 
								"							</div>\n" . */
								"							<div class=\"form-group row\">\n" . 
								"								<label class=\"col-sm-4 col-form-label\">Maße / Gewicht</label>\n" . 
								"								<div class=\"col-sm-2\">\n" . 
								"									<input type=\"number\" id=\"packing_length\" name=\"length\" step=\"1\" value=\"" . $length . "\" class=\"form-control\" placeholder=\"Länge\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Länge\" />\n" . 
								"								</div>\n" . 
								"								<div class=\"col-sm-2\">\n" . 
								"									<input type=\"number\" id=\"packing_width\" name=\"width\" step=\"1\" value=\"" . $width . "\" class=\"form-control\" placeholder=\"Breite\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Breite\" />\n" . 
								"								</div>\n" . 
								"								<div class=\"col-sm-2\">\n" . 
								"									<input type=\"number\" id=\"packing_height\" name=\"height\" step=\"1\" value=\"" . $height . "\" class=\"form-control\" placeholder=\"Höhe\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Höhe\" />\n" . 
								"								</div>\n" . 
								"								<div class=\"col-sm-2\">\n" . 
								"									<input type=\"number\" id=\"packing_weight\" name=\"weight\" step=\"0.1\" value=\"" . $weight . "\" class=\"form-control\" placeholder=\"Gewicht\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Gewicht\" />\n" . 
								"								</div>\n" . 
								"							</div>\n" . 
								"						</div>\n" . 
								"					</div>\n" . 
								"					<div class=\"form-group row\">\n" . 
								"						<div class=\"col-sm-12 text-center\">\n" . 
								"							<input type=\"hidden\" name=\"id\" value=\"" . $row_order['id'] . "\" />\n" . 
								"							<input type=\"hidden\" name=\"packing_form\" value=\"" . intval(isset($_POST['packing_form']) ? $_POST['packing_form'] : 0) . "\" />\n" . 
								"							<button type=\"submit\" name=\"packing_user\" value=\"speichern\" class=\"btn btn-success\">Als Warenausgang speichern <i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n" . 
								"							<button type=\"submit\" name=\"packing_user_order_history\" value=\"speichern\" class=\"btn btn-success\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n" . 
								"							<button type=\"submit\" name=\"packing_close\" value=\"schliessen\" class=\"btn btn-danger\">schliessen <i class=\"fa fa-times\" aria-hidden=\"true\"></i></button>\n" . 
								"						</div>\n" . 
								"					</div>\n" . 
								"				</form>\n" . 
								"				<hr />\n" 
							: 
								"			<h5>Dieser Auftrag hat keine letzte Zahlung!</h5>\n"
							)
						:
							""
						) . 

						(isset($_POST['packing_form']) && intval($_POST['packing_form']) == 4 ? 
							($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

							"				<h5>Neuer Versandauftrag - Techniker</h5>\n" . 
							"				<form action=\"" . $order_action . "\" method=\"post\" enctype=\"multipart/form-data\" onsubmit=\"var sumsize=0;for(var i=0;i<document.getElementById('file_packing').files.length;i++){sumsize+=document.getElementById('file_packing').files[i].size;}if(sumsize>(32*1024*1024)){alert('Die upload Datengröße ist zu hoch. Es sind nur 32MB insgesammt erlaubt!');return false;}else{return true;}\">\n" . 
							"					<div class=\"form-group row\">\n" . 
							"						<div class=\"col-sm-6 border-right\">\n" . 
							"							<div class=\"form-group row\">\n" . 
							"								<label class=\"col-sm-6 col-form-label\">Versandartikel</label>\n" . 
							"								<div class=\"col-sm-6\">\n" . 

							$html_devices_shipping . 

							"								</div>\n" . 
							"							</div>\n" . 
							"							<div class=\"form-group row\">\n" . 
							"								<label for=\"file_packing\" class=\"col-sm-6 col-form-label\">Beipackzettel</label>\n" . 
							"								<div class=\"col-sm-3\">\n" . 
							"									<select id=\"file1\" name=\"file1\" class=\"custom-select\">" . $options_file1 . "</select>\n" . 
							"								</div>\n" . 
							"								<div class=\"col-sm-3\">\n" . 
							"									<select id=\"file2\" name=\"file2\" class=\"custom-select\">" . $options_file2 . "</select>\n" . 
							"								</div>\n" . 
							"							</div>\n" . 
							"							<div class=\"form-group row\">\n" . 
							"								<label for=\"file_packing\" class=\"col-sm-6 col-form-label\">Zusatz / Dokumente</label>\n" . 
							"								<div class=\"col-sm-6\">\n" . 
							"									<input type=\"file\" id=\"file_packing\" name=\"file[]\" multiple=\"multiple\" accept=\"" . str_replace(", ", ",", $maindata['input_file_accept']) . "\" class=\"form-control\" onchange=\"var sumsize=0;for(var i=0;i<this.files.length;i++){sumsize+=this.files[i].size;}if(sumsize>(" . (int)ini_get("upload_max_filesize") . "*1024*1024)){alert('Die upload Datengröße ist zu hoch. Es sind nur " . (int)ini_get("upload_max_filesize") . "MB insgesammt erlaubt!');}\" />\n" . 
							"								</div>\n" . 
							"							</div>\n" . 
							"							<div class=\"form-group row\">\n" . 
							"								<label class=\"col-sm-6 col-form-label\">Wichtige Information<br />(an den Packtisch)</label>\n" . 
							"								<div class=\"col-sm-6\">\n" . 
							"									<textarea id=\"message\" name=\"message\" class=\"form-control\">" . (isset($_POST['message']) ? strip_tags($_POST['message']) : $message) . "</textarea>\n" . 
							"								</div>\n" . 
							"							</div>\n" . 
							"							<div class=\"form-group row\">\n" . 
							"								<label class=\"col-sm-6 col-form-label\">Zusammenfassend versenden</label>\n" . 
							"								<div class=\"col-sm-6\">\n" . 
							"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
							"										<input type=\"checkbox\" id=\"adding\" name=\"adding\" value=\"1\" class=\"custom-control-input\" />\n" . 
							"										<label class=\"custom-control-label\" for=\"adding\">\n" . 
							"											Ja\n" . 
							"										</label>\n" . 
							"									</div>\n" . 
							"								</div>\n" . 
							"							</div>\n" . 
							"						</div>\n" . 
							"						<div class=\"col-sm-6\">\n" . 
							"							<div class=\"form-group row\">\n" . 
							"								<label for=\"technic_address\" class=\"col-sm-4 col-form-label\"><strong>Techniker wählen</strong></label>\n" . 
							"								<div class=\"col-sm-4\">\n" . 
							"									<select id=\"technic_address\" name=\"technic_address\" class=\"custom-select\" onchange=\"document.getElementById('packing_technic_address').click()\">\n" . 
	
							$technic_addresses_options . 
	
							"									</select>\n" . 
							"								</div>\n" . 
							"								<div class=\"col-sm-4\">\n" . 
							"									<button type=\"submit\" id=\"packing_technic_address\" name=\"packing_technic_address\" value=\"auswaehlen\" class=\"btn btn-primary d-none\">auswählen <i class=\"fa fa-check\" aria-hidden=\"true\"></i></button>\n" . 
							"								</div>\n" . 
							"							</div>\n" . 
							"							<div class=\"form-group row\">\n" . 
							"								<div class=\"col-sm-12\">\n" . 
							"									<strong>Empfänger</strong>\n" . 
							"								</div>\n" . 
							"							</div>\n" . 
							"							<div class=\"form-group row\">\n" . 
							"								<div class=\"col-sm-12\">\n" . 
							"									<input type=\"text\" id=\"packing_companyname\" name=\"companyname\" value=\"" . $companyname . "\" class=\"form-control" . $inp_companyname . "\" placeholder=\"Firma\" />\n" . 
							"								</div>\n" . 
							"							</div>\n" . 
							"							<div class=\"form-group row\">\n" . 
							"								<div class=\"col-sm-4 mt-2\">\n" . 
							"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
							"										<input type=\"radio\" id=\"packing_gender_03\" name=\"gender\" value=\"0\"" . ((isset($_POST['gender']) ? intval($_POST['gender']) : $_POST['gender']) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
							"										<label class=\"custom-control-label\" for=\"packing_gender_03\">\n" . 
							"											Herr\n" . 
							"										</label>\n" . 
							"									</div>\n" . 
							"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
							"										<input type=\"radio\" id=\"packing_gender_13\" name=\"gender\" value=\"1\"" . ((isset($_POST['gender']) ? intval($_POST['gender']) : $_POST['gender']) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
							"										<label class=\"custom-control-label\" for=\"packing_gender_13\">\n" . 
							"											Frau\n" . 
							"										</label>\n" . 
							"									</div>\n" . 
							"								</div>\n" . 
							"								<div class=\"col-sm-4\">\n" . 
							"									<input type=\"text\" id=\"packing_firstname\" name=\"firstname\" value=\"" . $firstname . "\" class=\"form-control" . $inp_firstname . "\" placeholder=\"Vorname\" />\n" . 
							"								</div>\n" . 
							"								<div class=\"col-sm-4\">\n" . 
							"									<input type=\"text\" id=\"packing_lastname\" name=\"lastname\" value=\"" . $lastname . "\" class=\"form-control" . $inp_lastname . "\" placeholder=\"Nachname\" />\n" . 
							"								</div>\n" . 
							"							</div>\n" . 
							"							<div class=\"form-group row\">\n" . 
							"								<div class=\"col-sm-9\">\n" . 
							"									<input type=\"text\" id=\"packing_route\" name=\"street\" value=\"" . $street . "\" class=\"form-control" . $inp_street . "\" placeholder=\"Straße\" />\n" . 
							"								</div>\n" . 
							"								<div class=\"col-sm-3\">\n" . 
							"									<input type=\"text\" id=\"packing_street_number\" name=\"streetno\" value=\"" . $streetno . "\" class=\"form-control" . $inp_streetno . "\" placeholder=\"Nr\" />\n" . 
							"								</div>\n" . 
							"							</div>\n" . 
							"							<div class=\"form-group row\">\n" . 
							"								<div class=\"col-sm-4\">\n" . 
							"									<input type=\"text\" id=\"packing_postal_code\" name=\"zipcode\" value=\"" . $zipcode . "\" class=\"form-control" . $inp_zipcode . "\" placeholder=\"Postleitzahl\" />\n" . 
							"								</div>\n" . 
							"								<div class=\"col-sm-4\">\n" . 
							"									<input type=\"text\" id=\"packing_locality\" name=\"city\" value=\"" . $city . "\" class=\"form-control" . $inp_city . "\" placeholder=\"Ort\" />\n" . 
							"								</div>\n" . 
							"								<div class=\"col-sm-4\">\n" . 
							"									<select id=\"packing_country\" name=\"country\" class=\"custom-select\">" . $countries_options_packing . "</select>\n" . 
							"								</div>\n" . 
							"							</div>\n" . 
							"							<div class=\"form-group row\">\n" . 
							"								<div class=\"col-sm-4\">\n" . 
							"									<input type=\"text\" id=\"packing_email\" name=\"email\" value=\"" . $email . "\" class=\"form-control" . $inp_email . "\" placeholder=\"Email\" />\n" . 
							"								</div>\n" . 
							"								<div class=\"col-sm-4\">\n" . 
							"									<input type=\"text\" id=\"packing_mobilnumber\" name=\"mobilnumber\" value=\"" . $mobilnumber . "\" class=\"form-control" . $inp_mobilnumber . "\" placeholder=\"Mobil\" />\n" . 
							"								</div>\n" . 
							"								<div class=\"col-sm-4\">\n" . 
							"									<input type=\"text\" id=\"packing_phonenumber\" name=\"phonenumber\" value=\"" . $phonenumber . "\" class=\"form-control" . $inp_phonenumber . "\" placeholder=\"Festnetz\" />\n" . 
							"								</div>\n" . 
							"							</div>\n" . 

							"							<div class=\"form-group row d-none\">\n" . 

							"								<label class=\"col-sm-4 col-form-label\">Nachnahme</label>\n" . 
							"								<div class=\"col-sm-2\">\n" . 
							"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
							"										<input type=\"checkbox\" id=\"radio_payment\" name=\"radio_payment\" value=\"1\"" . (isset($_POST['radio_payment']) && $_POST['radio_payment'] == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" onchange=\"if(\$(this).prop('checked') == false){\$('#amount_label_texhnic').hide();\$('#amount_amount_technic').hide();}else{\$('#amount_label_technic').show();\$('#amount_amount_technic').show();}\" />\n" . 
							"										<label class=\"custom-control-label\" for=\"radio_payment\">\n" . 
							"											Ja\n" . 
							"										</label>\n" . 
							"									</div>\n" . 
							"								</div>\n" . 
							"								<label id=\"amount_label_technic\" class=\"col-sm-2 col-form-label\" style=\"display: none\" for=\"amount\">Betrag</label>\n" . 
							"								<div id=\"amount_amount_technic\" class=\"col-sm-4\" style=\"display: none\">\n" . 
							"									<div class=\"input-group\">\n" . 
							"										<input type=\"text\" id=\"amount\" name=\"amount\" value=\"" . (isset($_POST['amount']) ? strip_tags($_POST['amount']) : number_format(0.00, 2, ',', '')) . "\" class=\"form-control\" />\n" . 
							"									    <span class=\"input-group-append\">\n" . 
							"											<span class=\"input-group-text\">&euro;</span>\n" . 
							"										</span>\n" . 
							"									</div>\n" . 
							"								</div>\n" . 
		
							"							</div>\n" . 

							"							<div class=\"form-group row\">\n" . 

							"								<label class=\"col-sm-4 col-form-label\">Samstagszustellung</label>\n" . 
							"								<div class=\"col-sm-2\">\n" . 
							"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
							"										<input type=\"checkbox\" id=\"radio_saturday\" name=\"radio_saturday\" value=\"1\"" . (isset($_POST['radio_saturday']) && $_POST['radio_saturday'] == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
							"										<label class=\"custom-control-label\" for=\"radio_saturday\">\n" . 
							"											Ja\n" . 
							"										</label>\n" . 
							"									</div>\n" . 
							"								</div>\n" . 
	
							"							</div>\n" . 

							/*"							<div class=\"form-group row\">\n" . 
							"								<label for=\"packing_carriers_services\" class=\"col-sm-4 col-form-label\">Service</label>\n" . 
							"								<div class=\"col-sm-8\">\n" . 
							"									<select id=\"packing_carriers_service\" name=\"carriers_service\" class=\"custom-select\">\n" . 
	
							$carrier_services_options . 
	
							"									</select>\n" . 
							"								</div>\n" . 
							"								<div class=\"col-sm-1\">\n" . 
							"								</div>\n" . 
							"							</div>\n" . */
							/*"							<div class=\"form-group row\">\n" . 
							"								<label for=\"package_template\" class=\"col-sm-4 col-form-label\">Paketvorlage</label>\n" . 
							"								<div class=\"col-sm-8\">\n" . 
							"									<select id=\"package_template\" name=\"package_template\" class=\"custom-select\" onchange=\"\$('#update').click()\">\n" . 
	
							$carrier_package_templates_options . 
	
							"									</select>\n" . 
							"								</div>\n" . 
							"							</div>\n" . */
							"							<div class=\"form-group row\">\n" . 
							"								<label class=\"col-sm-4 col-form-label\">Maße / Gewicht</label>\n" . 
							"								<div class=\"col-sm-2\">\n" . 
							"									<input type=\"number\" id=\"packing_length\" name=\"length\" step=\"1\" value=\"" . $length . "\" class=\"form-control\" placeholder=\"Länge\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Länge\" />\n" . 
							"								</div>\n" . 
							"								<div class=\"col-sm-2\">\n" . 
							"									<input type=\"number\" id=\"packing_width\" name=\"width\" step=\"1\" value=\"" . $width . "\" class=\"form-control\" placeholder=\"Breite\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Breite\" />\n" . 
							"								</div>\n" . 
							"								<div class=\"col-sm-2\">\n" . 
							"									<input type=\"number\" id=\"packing_height\" name=\"height\" step=\"1\" value=\"" . $height . "\" class=\"form-control\" placeholder=\"Höhe\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Höhe\" />\n" . 
							"								</div>\n" . 
							"								<div class=\"col-sm-2\">\n" . 
							"									<input type=\"number\" id=\"packing_weight\" name=\"weight\" step=\"0.1\" value=\"" . $weight . "\" class=\"form-control\" placeholder=\"Gewicht\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Gewicht\" />\n" . 
							"								</div>\n" . 
							"							</div>\n" . 
							"						</div>\n" . 
							"					</div>\n" . 
							"					<div class=\"form-group row\">\n" . 
							"						<div class=\"col-sm-12 text-center\">\n" . 
							"							<input type=\"hidden\" name=\"id\" value=\"" . $row_order['id'] . "\" />\n" . 
							"							<input type=\"hidden\" name=\"packing_form\" value=\"" . intval(isset($_POST['packing_form']) ? $_POST['packing_form'] : 0) . "\" />\n" . 
							"							<button type=\"submit\" name=\"packing_technic\" value=\"speichern\" class=\"btn btn-success\">Als Warenausgang speichern <i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n" . 
							"							<button type=\"submit\" name=\"packing_technic_order_history\" value=\"speichern\" class=\"btn btn-success\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n" . 
							"							<button type=\"submit\" name=\"packing_close\" value=\"schliessen\" class=\"btn btn-danger\">schliessen <i class=\"fa fa-times\" aria-hidden=\"true\"></i></button>\n" . 
							"						</div>\n" . 
							"					</div>\n" . 
							"				</form>\n" . 
							"				<hr />\n"
						:
							""
						) . 

						(isset($_POST['packing_form']) && intval($_POST['packing_form']) == 5 ? 
							($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

							"				<h5>Neuer Umlagerung durchführen</h5>\n" . 
							"				<form action=\"" . $order_action . "\" method=\"post\">\n" . 
							"					<div class=\"form-group row\">\n" . 
							"						<label class=\"col-sm-3 col-form-label\">Umlagerungsauftrag</label>\n" . 
							"						<div class=\"col-sm-4\">\n" . 

							"							<div class=\"table-responsive overflow-auto border\" style=\"height: auto;width: 510px\">\n" . 
							"								<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
							"									<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
							"										<th width=\"150\" class=\"text-center\"><strong>Gerätenummer</strong></th>\n" . 
							"										<th width=\"120\" class=\"text-center\"><strong>Lagerplatz</strong></th>\n" . 
							"										<th class=\"text-center\"><strong>Zielplatz</strong></th>\n" . 
							"									</tr></thead>\n" . 

							$html_devices_relocate . 

							"								</table>\n" . 
							"							</div>\n" . 

							"						</div>\n" . 
							"					</div>\n" . 
							"					<div class=\"form-group row\">\n" . 
							"						<div class=\"col-sm-3\">\n" . 
							"						</div>\n" . 
							"						<div class=\"col-sm-3 text-center\">\n" . 
							"							<input type=\"hidden\" name=\"id\" value=\"" . $row_order['id'] . "\" />\n" . 
							"							<input type=\"hidden\" name=\"packing_form\" value=\"" . intval(isset($_POST['packing_form']) ? $_POST['packing_form'] : 0) . "\" />\n" . 
							"							<button type=\"submit\" name=\"relocate\" value=\"durchfuehren\" class=\"btn btn-success\">durchführen <i class=\"fa fa-refresh\" aria-hidden=\"true\"></i></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n" . 
							"							<button type=\"submit\" name=\"relocate_run_order_history\" value=\"speichern\" class=\"btn btn-success\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n" . 
							"							<button type=\"submit\" name=\"packing_close\" value=\"schliessen\" class=\"btn btn-danger\">schliessen <i class=\"fa fa-times\" aria-hidden=\"true\"></i></button>\n" . 
							"						</div>\n" . 
							"					</div>\n" . 
							"				</form>\n" . 
							"				<hr />\n"
						:
							""
						) . 

						($emsg != "" && !isset($_POST['packing_form']) ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

						"				<h4>Aufträge</h4>\n" . 

						"				<form action=\"" . $order_action . "\" method=\"post\">\n" . 
						"					<div class=\"form-group row\">\n" . 
						"						<label for=\"message_orderhistory\" class=\"col-sm-3 col-form-label\">Nachricht</label>\n" . 
						"						<div class=\"col-sm-5\">\n" . 
						"							<textarea id=\"message_orderhistory\" name=\"message\" class=\"form-control\">" . $message . "</textarea>\n" . 
						"						</div>\n" . 
						"						<div class=\"col-sm-4\">\n" . 
						"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
						"							<button type=\"submit\" id=\"history_order\" name=\"history_order\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
						"						</div>\n" . 
						"					</div>\n" . 
						"					<div class=\"form-group row\">\n" . 
						"						<label class=\"col-sm-3 col-form-label\">" . ($buttons_orderhistory != "" ? "Einfügen" : "&nbsp;") . "</label>\n" . 
						"						<div class=\"col-sm-5\">\n" . 

						$buttons_orderhistory . 

						"						</div>\n" . 
						"					</div>\n" . 
						"				</form>\n" . 

						$list_order_history . 

						"					</table>\n" . 
						"				</div><br /><br /><br />\n" . 

						"				<h4>Interessenten</h4>\n" . 

						$list_interessent_history . 

						"					</table>\n" . 
						"				</div><br /><br /><br />\n" . 

						"				<div class=\"row px-0 card-footer\">\n" . 
						"					<div class=\"col-sm-6\">\n" . 
						"					</div>\n" . 
						"					<div class=\"col-sm-6 text-right\">\n" . 
						"						&nbsp;\n" . 
						"					</div>\n" . 
						"				</div>\n";



?>