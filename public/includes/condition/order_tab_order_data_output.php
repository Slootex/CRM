<?php 

	$options_component = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`reasons` 
									WHERE 		`reasons`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`reasons`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$options_component .= "								<option value=\"" . $row['id'] . "\">" . $row['name'] . "</option>\n";

	}

	$row_devices_count = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS count FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "'"), MYSQLI_ASSOC);

	$list_devices = "";

	$html_device_details = "";

	$preview_src = "";

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
												`order_orders_devices`.`other_components` AS other_components, 
												`order_orders_devices`.`info` AS info, 
												(SELECT `storage_places`.`name` AS s_s_name FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`=`order_orders_devices`.`storage_space_id`) AS storage_space, 
												`order_orders_devices`.`atot_mode` AS atot_mode, 
												`order_orders_devices`.`at` AS at, 
												`order_orders_devices`.`ot` AS ot, 
												`order_orders_devices`.`star` AS star, 
												`order_orders_devices`.`is_send` AS is_send, 
												`order_orders_devices`.`is_storage` AS is_storage, 
												`order_orders_devices`.`is_next_storage` AS is_next_storage, 
												`order_orders_devices`.`is_shopin_relocate` AS is_shopin_relocate, 
												`order_orders_devices`.`is_labeling` AS is_labeling, 
												`order_orders_devices`.`is_photo` AS is_photo, 
												`order_orders_devices`.`is_shipping_user` AS is_shipping_user, 
												`order_orders_devices`.`is_shipping_technic` AS is_shipping_technic, 
												`order_orders_devices`.`is_shipping_extern` AS is_shipping_extern, 
												`order_orders_devices`.`is_send` AS is_send, 
												`order_orders_devices`.`is_relocate` AS is_relocate, 
												`order_orders_devices`.`reg_date` AS reg_date, 
												`order_orders_devices`.`upd_date` AS upd_date, 
												(SELECT `reasons`.`name` AS r_name FROM `reasons` WHERE `reasons`.`id`=`order_orders_devices`.`component`) AS reason_name 
									FROM 		`order_orders_devices` 
									WHERE 		`order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
									AND 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`order_orders_devices`.`reg_date` AS UNSIGNED) ASC");

	while($row_devices = $result->fetch_array(MYSQLI_ASSOC)){

		$device_maindoc = "";

		$device_docs = "";

		$result_files = mysqli_query($conn, "	SELECT 		*, 
															(SELECT `admin`.`name` AS name FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`=`order_orders_files`.`admin_id`) AS admin_name 
												FROM 		`order_orders_files` 
												WHERE 		`order_orders_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
												AND 		`order_orders_files`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
												AND 		`order_orders_files`.`device_id`='" . mysqli_real_escape_string($conn, intval($row_devices['id'])) . "' 
												ORDER BY 	CAST(`order_orders_files`.`type` AS UNSIGNED) ASC, CAST(`order_orders_files`.`upd_date` AS UNSIGNED) ASC");

		while($row_files = $result_files->fetch_array(MYSQLI_ASSOC)){
			if($row_files['type'] == 5){
				$device_maindoc .= "	<li><a href=\\'Javascript: void 0\\' onclick=\\'document.getElementById(\"preview\").src=\"/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/document/" . $row_files['file'] . "\"\\'>" . substr($row_files['file'], strpos($row_files['file'], "_") + 1) . "</a></li>";
				$preview_src = $preview_src == "" ? "/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/document/" . $row_files['file'] : $preview_src;
			}
			if($row_files['type'] == 6){
				$device_docs .= "	<li><a href=\\'Javascript: void 0\\' onclick=\\'document.getElementById(\"preview\").src=\"/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/document/" . $row_files['file'] . "\"\\'>" . substr($row_files['file'], strpos($row_files['file'], "_") + 1) . "</a></li>";
				$preview_src = $preview_src == "" ? "/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/document/" . $row_files['file'] : $preview_src;
			}
		}

		if($device_maindoc != ""){
			$device_maindoc =	"<h2>Hauptdokument</h2>" . 
								"<ul>" . 
								$device_maindoc . 
								"</ul>";
		}

		if($device_docs != ""){
			$device_docs =	"<h2>Dokumente</h2>" . 
							"<ul>" . 
							$device_docs . 
							"</ul>";
		}

		$device_details =	($device_maindoc != "" || $device_docs != "" ? 
								"<div class=\\'row\\'>" . 
								"	<div class=\\'col-sm-12\\'>" . 
								$device_maindoc . 
								$device_docs . 
								"	</div>" . 
								"</div>" . 
								"<div class=\\'row\\'>" . 
								"	<div class=\\'col-sm-12\\'>" . 
								"		<iframe id=\\'preview\\' src=\\'" . ($preview_src != "" ? $preview_src : "/crm/blank") . "\\' width=\\'100%\\' height=\\'800\\' class=\\'border\\'></iframe>" . 
								"	</div>" . 
								"</div>"
							: 
								""
							);

		$list_devices .= 	"	<tr" . ($row_devices['star'] == 1 ? " class=\"bg-warning text-white\"" : "") . ">\n" . 
							"		<td class=\"text-center\"><small>" . date("d.m.Y", intval($row_devices['reg_date'])) . "</small> <small class=\"text-muted\">" . date("(H:i)", $row_devices['reg_date']) . "</small></td>\n" . 
							"		<td class=\"text-left\"><small class=\"text-secondary\">" . $row_devices['device_number'] . ($row_devices['atot_mode'] == 1 ? "<span class=\"text-primary\">-AT-" . $row_devices['at'] . "</span>" : ($row_devices['atot_mode'] == 2 ? "<span class=\"text-primary\">-ORG-" . $row_devices['ot'] . "</span>" : "")) . "</small></td>\n" . 
							"		<td class=\"text-center\">" . ($row_devices['atot_mode'] == 0 ? "" : ($row_devices['atot_mode'] == 1 ? "<small class=\"text-secondary\">AT " . $row_devices['at'] . "</small>" : "<small class=\"text-primary\">ORG " . $row_devices['ot'] . "</small>")) . "</small></td>\n" . 
							"		<td><div style=\"width: 100%;white-space: nowrap;overflow-x: hidden\"><small>" . $row_devices['reason_name'] . "</small></div></td>\n" . 
							"		<td><div style=\"width: 100%;white-space: nowrap;overflow-x: hidden\"><small>" . $row_devices['manufacturer'] . "</small></div></td>\n" . 
							"		<td><div style=\"width: 100%;white-space: nowrap;overflow-x: hidden\"><small>" . $row_devices['serial'] . "</small></div></td>\n" . 
							"		<td><div style=\"width: 100%;white-space: nowrap;overflow-x: hidden\"><small>" . $row_devices['additional_numbers'] . "</small></div></td>\n" . 
							"		<td><div style=\"width: 100%;white-space: nowrap;overflow-x: hidden\"><small>" . $row_devices['info'] . "</small></div></td>\n" . 
							"		<td class=\"text-center\"><small>" . $row_devices['storage_space'] . "</small></td>\n" . 
							"		<td class=\"text-center\"><small>" . ($row_devices['fromthiscar'] == 1 ? "Ja" : "Nein") . "</small></td>\n" . 
							"		<td class=\"text-center\">" . ($row_devices['open_by_user'] == 1 ? "<small class=\"text-danger\">Ja</small>" : "<small>Nein</small>") . "</td>\n" . 
							"		<td class=\"text-center\"><small>" . ($row_devices['other_components'] == 1 ? "Ja" : "Nein") . "</small></td>\n" . 
							"		<td class=\"text-center\">" . ($row_devices['is_storage'] == 1 || $row_devices['is_next_storage'] == 1 || $row_devices['is_shopin_relocate'] == 1 || $row_devices['is_labeling'] == 1 || $row_devices['is_photo'] == 1 || $row_devices['is_shipping_user'] == 1 || $row_devices['is_shipping_technic'] == 1 || $row_devices['is_shipping_extern'] == 1 || $row_devices['is_send'] == 1 || $row_devices['is_relocate'] == 1 ? "<span class=\"badge badge-danger\" data-toggle=\"tooltip\" data-placement=\"left\" data-original-title=\"Datum: <small>" . date("d.m.Y", intval($row_devices['upd_date'])) . "</small> <small>" . date("(H:i)", $row_devices['upd_date']) . "</small><hr class='bg-white' />WE-Einlagern: " . ($row_devices['is_storage'] == 1 ? "Ja" : "") . "<br />WE-Neu-Einlagern: " . ($row_devices['is_next_storage'] == 1 ? "Ja" : "") . "<br />WE-Umlagern: " . ($row_devices['is_shopin_relocate'] == 1 ? "Ja" : "") . "<hr class='bg-white' />Beschriften: " . ($row_devices['is_labeling'] == 1 ? "Ja" : "") . "<br />Umlagern: " . ($row_devices['is_relocate'] == 1 ? "Ja" : "") . "<br />Fotoauftrag: " . ($row_devices['is_photo'] == 1 ? "Ja" : "") . "<hr class='bg-white' />Versenden Kunde: " . ($row_devices['is_shipping_user'] == 1 ? "Ja" : "") . "<br />Versenden Techniker: " . ($row_devices['is_shipping_technic'] == 1 ? "Ja" : "") . "<br />Versenden Extern: " . ($row_devices['is_shipping_extern'] == 1 ? "Ja" : "") . "<hr class='bg-white' />Versendet: " . ($row_devices['is_send'] == 1 ? "Ja" : "") . "<br />\" title=\"\"><i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i></span>" : "<small>-</small>") . "</td>\n" . 
							"		<td class=\"text-center\">\n" . 
							"			<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
							"				<input type=\"hidden\" name=\"id\" value=\"" . $row_order['id'] . "\" />\n" . 
							"				<input type=\"hidden\" name=\"device_id\" value=\"" . $row_devices['id'] . "\" />\n" . 
							"				<div class=\"btn-group\">\n" . 
							"					<button type=\"button\" name=\"device_details\" value=\"ansehen\" class=\"btn btn-sm btn-success\" onclick=\"showStatussesDialog('" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($device_details, ENT_QUOTES))))) . "', '', '')\"><i class=\"fa fa-search-plus\" aria-hidden=\"true\"></i></button>\n" . 
							"					<button type=\"submit\" name=\"device_star\" value=\"setzen\" class=\"btn btn-sm btn-primary" . ($row_devices['star'] == 1 ? " text-warning" : "") . "\"><i class=\"fa fa-star\" aria-hidden=\"true\"></i></button>\n" . 
							"					<button type=\"submit\" name=\"device_delete\" value=\"entfernen\" class=\"btn btn-sm btn-danger\" onclick=\"return confirm('Wollen Sie das Gerät wircklich entfernen?')\"" . ($row_devices['is_storage'] == 1 || $row_devices['is_next_storage'] == 1 || $row_devices['is_shopin_relocate'] == 1 || $row_devices['is_labeling'] == 1 || $row_devices['is_photo'] == 1 || $row_devices['is_shipping_user'] == 1 || $row_devices['is_shipping_technic'] == 1 || $row_devices['is_shipping_extern'] == 1 || $row_devices['is_send'] == 1 || $row_devices['is_relocate'] == 1 ? " disabled=\"disabled\"" : "") . "><i class=\"fa fa-ban\" aria-hidden=\"true\"></i></button>\n" . 
							"					<button type=\"button\" name=\"device_edit\" value=\"bearbeiten\" class=\"btn btn-sm btn-success\" onclick=\"\$('#iframeModal_xl > .modal-dialog');\$('#iframeModal_xl div div div .modal-title').text('Gerät: " . $row_devices['device_number'] . ($row_devices['atot_mode'] == 1 ? "-AT-" . $row_devices['at'] : ($row_devices['atot_mode'] == 2 ? "-ORG-" . $row_devices['ot'] : "")) . "');\$('#iframeModal_xl div div div iframe').attr('src', '/crm/auftraege/" . $row_order["id"] . "/geraete/" . $row_devices["id"] . "');\$('#iframeModal_xl').modal();\"" . ($row_devices['is_storage'] == 1 || $row_devices['is_next_storage'] == 1 || $row_devices['is_shopin_relocate'] == 1 || $row_devices['is_labeling'] == 1 || $row_devices['is_photo'] == 1 || $row_devices['is_shipping_user'] == 1 || $row_devices['is_shipping_technic'] == 1 || $row_devices['is_relocate'] == 1 ? " disabled=\"disabled\"" : "") . "><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>\n" . 
							"				</div>\n" . 
							"			</form>\n" . 
							"		</td>\n" . 
							"	</tr>\n";

	}

	$tabs_contents .= 	($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

						"				<div class=\"row mb-3\">\n" . 
						"					<div class=\"col-6\">\n" . 
						"						<strong>Geräte:</strong> <span>" . $row_devices_count['count'] . " Stück!</span>\n" . 
						"					</div>\n" . 
						"					<div class=\"col-6 text-right\">\n" . 
						"						<form action=\"" . $order_action . "\" method=\"post\">\n" . 
						"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
						"							<div class=\"btn-group\">\n" . 
						"								<button type=\"button\" name=\"device_new\" value=\"neu\" class=\"btn btn-sm btn-primary\" onclick=\"\$('#iframeModal_xl > .modal-dialog');\$('#iframeModal_xl div div div .modal-title').text('Neues Gerät zum Auftrag: " . $row_order['order_number'] . "');\$('#iframeModal_xl div div div iframe').attr('src', '/crm/auftraege-neues-geraet/" . $row_order["id"] . "');\$('#iframeModal_xl').modal();\"><i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i></button>\n" . 
						"								<button type=\"submit\" name=\"refresh\" value=\"aktualisieren\" class=\"btn btn-sm btn-secondary\"><i class=\"fa fa-refresh\" aria-hidden=\"true\"></i></button>\n" . 
						"							</div>\n" . 
						"						</form>\n" . 
						"					</div>\n" . 
						"				</div>\n" . 

						"				<div class=\"row\">\n" . 
						"					<div class=\"col-12\">\n" . 
						"<div class=\"table-responsive\" style=\"max-height: 360px\">\n" . 
						"<table class=\"table table-white table-sm table-bordered table-hover mb-0\">\n" . 
						"	<tr class=\"bg-light text-primary\">\n" . 
						"		<th width=\"120\"><small><b>Datum</b></small></th>\n" . 
						"		<th width=\"120\"><small><b>Gerät</b></small></th>\n" . 
						"		<th width=\"60\"><small><b>Bauteilspez.</b></small></th>\n" . 
						"		<th width=\"170\"><small><b>Bauteil</b></small></th>\n" . 
						"		<th width=\"170\"><small><b>Hersteller</b></small></th>\n" . 
						"		<th width=\"170\"><small><b>Teile.-/Herstellernummer</b></small></th>\n" . 
						"		<th><small><b>Zusätzliche Nummern</b></small></th>\n" . 
						"		<th width=\"170\"><small><b>Info</b></small></th>\n" . 
						"		<th width=\"75\"><small><b>Lagerplatz</b></small></th>\n" . 
						"		<th width=\"100\"><small><b>Aus Fahrzeug</b></small></th>\n" . 
						"		<th width=\"110\"><small><b>Wurde geöffnet</b></small></th>\n" . 
						"		<th width=\"110\"><small><b>Andere Bauteile</b></small></th>\n" . 
						"		<th width=\"60\"><small><b>Vorgänge</b></small></th>\n" . 
						"		<th width=\"100\" class=\"text-center\"><small><b>Aktion</b></small></th>\n" . 
						"	</tr>\n" . 
	
						$list_devices . 
		
						"</table>\n" . 
						"</div>\n" . 
						"					</div>\n" . 
						"				</div>\n" . 

						/*"				<form action=\"" . $order_action . "\" method=\"post\">\n" . 

						"					<div class=\"row\">\n" . 
						"						<div class=\"col-6\">\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<div class=\"col-sm-12\">\n" . 
						"									<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
						"									<button type=\"button\" name=\"device_new\" value=\"neu\" class=\"btn btn-sm btn-primary\" onclick=\"\$('#iframeModal_xl > .modal-dialog');\$('#iframeModal_xl div div div .modal-title').text('Neues Gerät zum Auftrag: " . $row_order['order_number'] . "');\$('#iframeModal_xl div div div iframe').attr('src', '/crm/auftraege-neues-geraet/" . $row_order["id"] . "');\$('#iframeModal_xl').modal();\">Neues Gerät <i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i></button>&nbsp;&nbsp;&nbsp;\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"						</div>\n" . 
						"						<div class=\"col-6\">\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<div class=\"col-sm-12 text-right\">\n" . 
						"									<button type=\"submit\" name=\"edit\" value=\"bearbeiten\" class=\"btn btn-sm btn-secondary\">Aktualisieren <i class=\"fa fa-refresh\" aria-hidden=\"true\"></i></button>&nbsp;&nbsp;&nbsp;\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"						</div>\n" . 
						"					</div>\n" . 

						"				</form>\n" . */

						"				<hr />\n" . 

						"				<form action=\"" . $order_action . "\" method=\"post\">\n" . 

						"					<div class=\"row\">\n" . 
						"						<div class=\"col-6 border-right\">\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<div class=\"col-sm-12\">\n" . 
						"									<strong>Fahrzeugdaten</strong>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"machine\" class=\"col-sm-6 col-form-label\">Automarke</label>\n" . 
						"								<div class=\"col-sm-6\">\n" . 
						"									<input type=\"text\" id=\"machine\" name=\"machine\" value=\"" . (isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? $machine : $row_order["machine"]) . "\" class=\"form-control" . $inp_machine . "\" />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 
						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"model\" class=\"col-sm-6 col-form-label\">Automodell</label>\n" . 
						"								<div class=\"col-sm-6\">\n" . 
						"									<input type=\"text\" id=\"model\" name=\"model\" value=\"" . (isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? $model : $row_order["model"]) . "\" class=\"form-control" . $inp_model . "\" />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 
						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"constructionyear\" class=\"col-sm-6 col-form-label\">Baujahr</label>\n" . 
						"								<div class=\"col-sm-6\">\n" . 
						"									<input type=\"text\" id=\"constructionyear\" name=\"constructionyear\" value=\"" . (isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? $constructionyear : $row_order["constructionyear"]) . "\" class=\"form-control" . $inp_constructionyear . "\" />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 
						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"carid\" class=\"col-sm-6 col-form-label\">FIN / VIN</label>\n" . 
						"								<div class=\"col-sm-3\">\n" . 
						"									<input type=\"text\" id=\"carid\" name=\"carid\" value=\"" . (isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? strtoupper($carid) : strtoupper($row_order["carid"])) . "\" class=\"form-control" . $inp_carid . "\" />\n" . 
						"								</div>\n" . 
						"								<div class=\"col-sm-3 text-right\">\n" . 
						"									<button type=\"button\" name=\"show_data\" value=\"DETAILS\" class=\"btn btn-success\" onclick=\"if(confirm('\\u26A0 Warnung:\\nDiese Funktion verursacht Kosten in Höhe von 0,20&euro;.\\nWollen Sie dies durchführen?')){\$('#iframeModal > .modal-dialog').addClass('modal-lg');\$('#iframeModal div div div .modal-title').text('VIN-Decoder: " . strtoupper($row_order["carid"]) . "');\$('#iframeModal div div div iframe').attr('src', '/crm/auftraege/vindecoder/" . $row_order["id"] . "/" . strtoupper($row_order["carid"]) . "');\$('#iframeModal').modal();}\">Daten <i class=\"fa fa-search-plus\" aria-hidden=\"true\"></i></button>\n" . 
						"									<button type=\"button\" name=\"show_details\" value=\"DETAILS\" class=\"btn btn-success\" onclick=\"\$('#iframeModal > .modal-dialog').addClass('modal-lg');\$('#iframeModal div div div .modal-title').text('VIN-Decoder: " . strtoupper($row_order["carid"]) . "');\$('#iframeModal div div div iframe').attr('src', '/crm/auftraege/vinansicht/" . $row_order["id"] . "');\$('#iframeModal').modal();\">ansicht <i class=\"fa fa-search-plus\" aria-hidden=\"true\"></i></button>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 
						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"kw\" class=\"col-sm-6 col-form-label\">Fahrleistung (PS)</label>\n" . 
						"								<div class=\"col-sm-6\">\n" . 
						"									<input type=\"text\" id=\"kw\" name=\"kw\" value=\"" . (isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? $kw : $row_order["kw"]) . "\" class=\"form-control" . $inp_kw . "\" />\n" . 
						"								</div>\n" . 
						"							</div>\n" . 
						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"mileage\" class=\"col-sm-6 col-form-label\">Kilometerstand</label>\n" . 
						"								<div class=\"col-sm-6\">\n" . 
						"									<div class=\"input-group date\">\n" . 
						"										<input type=\"text\" id=\"mileage\" name=\"mileage\" value=\"" . (isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? number_format($mileage, 0, '', '.') : number_format(intval($row_order["mileage"]), 0, '', '.')) . "\" class=\"form-control" . $inp_mileage . "\" />\n" . 
						"									    <span class=\"input-group-append\">\n" . 
						"											<span class=\"input-group-text\">KM</span>\n" . 
						"										</span>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 
						"							<div class=\"form-group row\">\n" . 
						"								<label class=\"col-sm-6 col-form-label\">Getriebe</label>\n" . 
						"								<div class=\"col-sm-6 mt-2\">\n" . 
						"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"										<input type=\"radio\" id=\"mechanism_0\" name=\"mechanism\" value=\"0\"" . ((isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? $mechanism : $row_order["mechanism"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
						"										<label class=\"custom-control-label\" for=\"mechanism_0\">\n" . 
						"											Schaltung\n" . 
						"										</label>\n" . 
						"									</div>\n" . 
						"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"										<input type=\"radio\" id=\"mechanism_1\" name=\"mechanism\" value=\"1\"" . ((isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? $mechanism : $row_order["mechanism"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
						"										<label class=\"custom-control-label\" for=\"mechanism_1\">\n" . 
						"											Automatik\n" . 
						"										</label>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 
						"							<div class=\"form-group row\">\n" . 
						"								<label class=\"col-sm-6 col-form-label\">Kraftstoffart</label>\n" . 
						"								<div class=\"col-sm-6 mt-2\">\n" . 
						"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"										<input type=\"radio\" id=\"fuel_0\" name=\"fuel\" value=\"0\"" . ((isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? $fuel : $row_order["fuel"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
						"										<label class=\"custom-control-label\" for=\"fuel_0\">\n" . 
						"											Benzin\n" . 
						"										</label>\n" . 
						"									</div>\n" . 
						"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
						"										<input type=\"radio\" id=\"fuel_1\" name=\"fuel\" value=\"1\"" . ((isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? $fuel : $row_order["fuel"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
						"										<label class=\"custom-control-label\" for=\"fuel_1\">\n" . 
						"											Diesel\n" . 
						"										</label>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"						</div>\n" . 
						"						<div class=\"col-6\">\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<div class=\"col-sm-12\">\n" . 
						"									<strong>Fehlerbeschreibung</strong>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"reason\" class=\"col-sm-3 col-form-label\">Fehlerursache</label>\n" . 
						"								<div class=\"col-sm-9 text-right\">\n" . 
						"									<textarea id=\"reason\" name=\"reason\" style=\"height: 160px\" class=\"form-control" . $inp_reason . "\" onkeyup=\"if(this.value.length >= 700){this.value = this.value.substr(0, 700);alert('Die maximale Anzahl an erlaubten Zeichen wurde erreicht!');}$('#reason_length').html(this.value.length);\">" . (isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? $reason : $row_order["reason"]) . "</textarea>\n" . 
						"									<small>(<span id=\"reason_length\">" . strlen(isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? $reason : $row_order["reason"]) . "</span> von 700 Zeichen)</small>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 
						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"description\" class=\"col-sm-3 col-form-label\">Fehlerspeicher</label>\n" . 
						"								<div class=\"col-sm-9 text-right\">\n" . 
						"									<textarea id=\"description\" name=\"description\" style=\"height: 160px\" class=\"form-control" . $inp_description . "\" onkeyup=\"if(this.value.length >= 700){this.value = this.value.substr(0, 700);alert('Die maximale Anzahl an erlaubten Zeichen wurde erreicht!');}$('#description_length').html(this.value.length);\">" . (isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? $description : $row_order["description"]) . "</textarea>\n" . 
						"									<small>(<span id=\"description_length\">" . strlen(isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? $description : $row_order["description"]) . "</span> von 700 Zeichen)</small>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 
						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"note_to_the_technician\" class=\"col-sm-3 col-form-label\">Hinweis an den Techniker</label>\n" . 
						"								<div class=\"col-sm-9 text-right\">\n" . 
						"									<textarea id=\"note_to_the_technician\" name=\"note_to_the_technician\" style=\"height: 160px\" class=\"form-control" . $inp_note_to_the_technician . "\" onkeyup=\"if(this.value.length >= 700){this.value = this.value.substr(0, 700);alert('Die maximale Anzahl an erlaubten Zeichen wurde erreicht!');}$('#note_to_the_technician_length').html(this.value.length);\">" . (isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? $note_to_the_technician : $row_order["note_to_the_technician"]) . "</textarea>\n" . 
						"									<small>(<span id=\"note_to_the_technician_length\">" . strlen(isset($_POST['order_data']) && $_POST['order_data'] == "speichern" ? $note_to_the_technician : $row_order["note_to_the_technician"]) . "</span> von 700 Zeichen)</small>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 

						"						</div>\n" . 
						"					</div>\n" . 

						"					<br />\n" . 

						"					<div class=\"row px-0 card-footer\">\n" . 
						"						<div class=\"col-sm-6\">\n" . 
						"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
						"							<button type=\"submit\" name=\"order_data\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
						"							<a href=\"/crm/tech-info-pdf/" . $row_order['id'] . "\" target=\"_blank\" class=\"btn btn-success\">Label <i class=\"fa fa-file-text-o\" aria-hidden=\"true\"></i></a>\n"  . 
						"						</div>\n" . 
						"						<div class=\"col-sm-6 text-right\">\n" . 
						"						</div>\n" . 
						"					</div>\n" . 

						"				</form>\n";

?>