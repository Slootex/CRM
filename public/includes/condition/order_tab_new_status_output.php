<?php 

	$carriers_services = array(
		11 =>  'UPS Standard', 
		65 =>  'UPS Saver'
	);

	$carriers_services_costs = array(
		11 =>  5.95, // UPS Standard
		65 =>  8.95  // UPS Saver
	);

	$result_statuses = mysqli_query($conn, "	SELECT 		* 
												FROM 		`statuses` 
												WHERE 		`statuses`.`type`='" . mysqli_real_escape_string($conn, intval($order_templates_type)) . "' 
												AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
												AND 		`statuses`.`status_status`='1' 
												ORDER BY 	CAST(`statuses`.`id` AS UNSIGNED) ASC");

	$new_status_options = "";

	while($row = $result_statuses->fetch_array(MYSQLI_ASSOC)){

		$new_status_options .= "				<option value=\"" . $row["id"] . "\"" . (isset($_POST["status_id"]) && $row["id"] == intval($_POST["status_id"]) ? " selected=\"selected\"" : "") . ">" . substr($row['name'], 0, 80) . "</option>\n";

	}

	$result_templates = mysqli_query($conn, "	SELECT 		* 
												FROM 		`templates` 
												WHERE 		`templates`.`type`=" . mysqli_real_escape_string($conn, intval($order_templates_type)) . " 
												AND 		`templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 

												AND 		`templates`.`id`!=(SELECT email_template FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`='" . mysqli_real_escape_string($conn, intval($maindata['order_status_intern'])) . "') 
												AND 		`templates`.`id`!=(SELECT email_template FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`='" . mysqli_real_escape_string($conn, intval($maindata['order_status'])) . "') 
												AND 		`templates`.`id`!=(SELECT email_template FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`='" . mysqli_real_escape_string($conn, intval($maindata['shipping_status'])) . "') 
												AND 		`templates`.`id`!=(SELECT email_template FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`='" . mysqli_real_escape_string($conn, intval($maindata['shipping_cancel_status'])) . "') 
												AND 		`templates`.`id`!=(SELECT email_template FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`='" . mysqli_real_escape_string($conn, intval($maindata['interested_to_order_status'])) . "') 
												AND 		`templates`.`id`!=(SELECT email_template FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`='" . mysqli_real_escape_string($conn, intval($maindata['order_to_archive_status'])) . "') 
												AND 		`templates`.`id`!=(SELECT email_template FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`='" . mysqli_real_escape_string($conn, intval($maindata['archive_to_order_status'])) . "') 

												AND 		`templates`.`id`!=(SELECT email_template FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`=" . mysqli_real_escape_string($conn, intval($maindata['interested_status_intern'])) . ") 
												AND 		`templates`.`id`!=(SELECT email_template FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`=" . mysqli_real_escape_string($conn, intval($maindata['interested_status_intern_orderform_per_mail'])) . ") 
												AND 		`templates`.`id`!=(SELECT email_template FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`=" . mysqli_real_escape_string($conn, intval($maindata['interested_status'])) . ") 
												AND 		`templates`.`id`!=(SELECT email_template FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`=" . mysqli_real_escape_string($conn, intval($maindata['interested_to_archive_status'])) . ") 
												AND 		`templates`.`id`!=(SELECT email_template FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`=" . mysqli_real_escape_string($conn, intval($maindata['archive_to_interested_status'])) . ") 

												ORDER BY 	CAST(`templates`.`id` AS UNSIGNED) ASC");

	$new_email_options = "";

	while($row = $result_templates->fetch_array(MYSQLI_ASSOC)){

		$new_email_options .= "				<option value=\"" . $row["id"] . "\"" . (isset($_SESSION["email_template"]["id"]) && $row["id"] == $_SESSION["email_template"]["id"] ? " selected=\"selected\"" : "") . ">" . substr($row['name'], 0, 80) . "</option>\n";

	}

	$list_status_history = 	"				<br />\n" . 
							"				<div class=\"row\">\n" . 
							"					<div class=\"col-sm-3\">\n" . 
							"						<p><strong>Aktueller Status</strong>: " . $row_order['status_name'] . "</p>\n" . 
							"					</div>\n" . 
							"					<div class=\"col-sm-6 text-center\">\n" . 
							"						<form action=\"" . $order_action . "\" method=\"post\">\n" . 
							"							<input type=\"hidden\" name=\"id\" value=\"" . $row_order['id'] . "\" />\n" . 
							"							<div class=\"btn-group btn-toggle\" style=\"white-space: nowrap;\">\n" . 
							"								<button type=\"submit\" name=\"public\" value=\"1\" class=\"btn" . ($row_order['public'] == 1 ? " active btn-success" : " btn-default") . " btn-sm\" style=\"float: none; display: inline-block; margin-right: 0px;\">Online Status</button>\n" . 
							"								<button type=\"submit\" name=\"public\" value=\"0\" class=\"btn" . ($row_order['public'] == 1 ? " btn-default" : " active btn-danger") . " btn-sm\" style=\"float: none; display: inline-block; margin-left: 0px;\">Offline Status</button>\n" . 
							"							</div>\n" . 
							"						</form>\n" . 
							"					</div>\n" . 
							"				</div>\n" . 
							"				<div class=\"table-responsive overflow-auto border\" style=\"height: 750px\">\n" . 
							"					<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
							"						<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
							"							<th><strong>Datum</strong></th>\n" . 
							"							<th><strong>Status</strong></th>\n" . 
							"							<th><strong>Mitarbeiter</strong></th>\n" . 
							"							<th><strong>Email-Vorlage</strong></th>\n" . 
							"							<th><strong>Nachricht</strong></th>\n" . 
							"							<th><strong>Gelesen</strong></th>\n" . 
							"							<th><strong>&nbsp;</strong></th>\n" . 
							"						</tr></thead>\n";

	$result_statuses = mysqli_query($conn, "	SELECT 		`" . $order_table . "_statuses`.`id` AS id, 
															`" . $order_table . "_statuses`.`status_number` AS status_number, 
															`" . $order_table . "_statuses`.`time` AS time, 
															(
																SELECT 	name
																FROM 	`admin` `admin`
																WHERE 	`admin`.`id`=`" . $order_table . "_statuses`.`admin_id` 
																AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
															) AS admin_name, 
															`" . $order_table . "_statuses`.`template` AS template, 
															`" . $order_table . "_statuses`.`subject` AS subject, 
															`" . $order_table . "_statuses`.`body` AS body, 
															`" . $order_table . "_statuses`.`email_reads` AS email_reads, 
															`statuses`.`name` AS status_name, 
															`statuses`.`color` AS status_color 
												FROM 		`" . $order_table . "_statuses` `" . $order_table . "_statuses`
												LEFT JOIN 	`statuses` `statuses` 
												ON 			`statuses`.`id`=`" . $order_table . "_statuses`.`status_id`
												WHERE 		`" . $order_table . "_statuses`.`" . $order_id_field . "`='" . $row_order['id'] . "' 
												AND 		`" . $order_table . "_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
												AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
												ORDER BY 	CAST(`" . $order_table . "_statuses`.`time` AS UNSIGNED) DESC");

	while($row_order_status = $result_statuses->fetch_array(MYSQLI_ASSOC)){

		$list_shipments_status = "";

		$result_shipments = mysqli_query($conn, "	SELECT 		`order_orders_shipments`.`id` AS id, 
																(
																	SELECT 	name 
																	FROM 	`admin` `admin` 
																	WHERE 	`admin`.`id`=`order_orders_shipments`.`admin_id` 
																	AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																) AS admin_name, 
																`order_orders_shipments`.`devices` AS devices, 
																`order_orders_shipments`.`file1` AS file1_id, 
																(SELECT `file_attachments`.`name` AS f1n FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`order_orders_shipments`.`file1`) AS file1_name, 
																(SELECT `file_attachments`.`file` AS f1f FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`order_orders_shipments`.`file1`) AS file1_file, 
																`order_orders_shipments`.`file2` AS file2_id, 
																(SELECT `file_attachments`.`name` AS f2n FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`order_orders_shipments`.`file2`) AS file2_name, 
																(SELECT `file_attachments`.`file` AS f2f FROM `file_attachments` WHERE `file_attachments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `file_attachments`.`id`=`order_orders_shipments`.`file2`) AS file2_file, 
																`order_orders_shipments`.`items` AS items, 
																`order_orders_shipments`.`shipments_id` AS shipments_id, 
																`order_orders_shipments`.`carrier_tracking_no` AS carrier_tracking_no, 
																`order_orders_shipments`.`label_url` AS label_url, 
																`order_orders_shipments`.`graphic_image_jpeg` AS graphic_image_jpeg, 
																`order_orders_shipments`.`graphic_image_gif` AS graphic_image_gif, 
																`order_orders_shipments`.`price` AS price, 
																`order_orders_shipments`.`total_charges_with_taxes` AS total_charges_with_taxes, 
																`order_orders_shipments`.`carrier` AS carrier, 
																`order_orders_shipments`.`service` AS service, 
																`order_orders_shipments`.`reference_number` AS reference_number, 
																`order_orders_shipments`.`notification_email` AS notification_email, 
																`order_orders_shipments`.`component` AS component, 
																`order_orders_shipments`.`companyname` AS companyname, 
																`order_orders_shipments`.`firstname` AS firstname, 
																`order_orders_shipments`.`lastname` AS lastname, 
																`order_orders_shipments`.`street` AS street, 
																`order_orders_shipments`.`streetno` AS streetno, 
																`order_orders_shipments`.`zipcode` AS zipcode, 
																`order_orders_shipments`.`city` AS city, 
																`order_orders_shipments`.`country` AS country, 
																`order_orders_shipments`.`weight` AS weight, 
																`order_orders_shipments`.`length` AS length, 
																`order_orders_shipments`.`width` AS width, 
																`order_orders_shipments`.`height` AS height, 
																`order_orders_shipments`.`status` AS status, 
																`order_orders_shipments`.`time` AS time 
													FROM 		`order_orders_shipments` `order_orders_shipments` 
													WHERE 		`order_orders_shipments`.`order_id`='" . $row_order['id'] . "' 
													AND 		`order_orders_shipments`.`status_id`='" . $row_order_status['id'] . "' 
													AND 		`order_orders_shipments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
													ORDER BY 	CAST(`order_orders_shipments`.`time` AS UNSIGNED) DESC");

		while($row = $result_shipments->fetch_array(MYSQLI_ASSOC)){

			$str_status = "";

			if($row['shipments_id'] != ""){

				$response = getUpsStatus($maindata, $row['shipments_id']);

				$arr_status = $response->trackResponse->shipment[0]->package[0]->activity;

				if(isset($arr_status)){

					for($i = 0; $i < count($arr_status);$i++){

						$year = substr($arr_status[$i]->date, 0, 4);
						$month = substr($arr_status[$i]->date, 4, 2);
						$day = substr($arr_status[$i]->date, 6, 2);

						$clock_date = $day . "." . $month . "." . $year;

						$hour = substr($arr_status[$i]->time, 0, 2);
						$minute = substr($arr_status[$i]->time, 2, 2);

						$clock_time = $hour . ":" . $minute . " Uhr";

						$index = (count($arr_status) - $i);

						$str_status .= ($index <= 9 ? "0" : "") . $index . ") " . $clock_date . " " . $clock_time . " - " . $arr_status[$i]->status->description . "<br />\n";

					}

				}

			}

			$devices = "";

			if($row['devices'] != ""){

				$arr_devices = explode(",", $row['devices']);

				for($i = 0;$i < count($arr_devices);$i++){

					$arr_devices_data = explode(":", $arr_devices[$i]);

					$devices .= "	<div class=\"d-inline-block pr-2 pb-1\"><h4><span class=\"badge badge-success rounded-pill font-weight-bold\" style=\"width: 190px\">" . $arr_devices_data[1] . "</span></h4></div>\n";

				}

			}

			$items = "";

			if($row['items'] != ""){

				$arr_items = explode(",", $row['items']);

				for($i = 0;$i < count($arr_items);$i++){

					$arr_items_data = explode(":", $arr_items[$i]);

					$items .= "	<div class=\"d-inline-block pr-2 pb-1\"><h4><span class=\"badge badge-success rounded-pill font-weight-bold\" style=\"width: 200px\">" . $arr_items_data[1] . "</span></h4></div>\n";

				}

			}

			$list_shipments_status .= 	"<form action=\"" . $order_action . "\" method=\"post\">\n" . 
										"	<div class=\"card\">\n" . 
										"		<div class=\"card-header\">\n" . 
										"			<div class=\"row\">\n" . 
										"				<div class=\"col-12 col-md-6\">\n" . 
										"					[" . $row['id'] . "] <a href=\"#shipments_" . $row['id'] . "\" class=\"alert-link collapsed\" data-toggle=\"collapse\" role=\"link\" aria-expanded=\"true\" aria-controls=\"collapseExample\"><small>Mehr zeigen</small></a>\n" . 
										"				</div>\n" . 
										"				<div class=\"col-12 col-md-6 text-right\">\n" . 
										"					<small class=\"text-muted\">" . date("d.m.Y (H:i)", $row['time']) . "</small>\n" . 
										"				</div>\n" . 
										"			</div>\n" . 
										"		</div>\n" . 
										"		<div id=\"shipments_" . $row['id'] . "\" class=\"card-body collapse show active\">\n" . 
										"			<div class=\"row\">\n" . 
										"				<label class=\"col-3\">Durchgeführt von</label>\n" . 
										"				<div class=\"col-9\">\n" . 
										"					<span>" . $row['admin_name'] . "</span>\n" . 
										"				</div>\n" . 
										"			</div>\n" . 
										"			<div class=\"row\">\n" . 
										"				<label class=\"col-3\">Label URL</label>\n" . 
										"				<div class=\"col-9\">\n" . 
										($row['carrier_tracking_no'] != "" ? 
											"					<a href=\"" . $row['label_url'] . "\" target=\"_blank\">öffnen <i class=\"fa fa-external-link\"> </i></a>\n"
										: 
											""
										) . 
										"				</div>\n" . 
										"			</div>\n" . 
										"			<div class=\"row\">\n" . 
										"				<label class=\"col-3\">Tracking Nummer</label>\n" . 
										"				<div class=\"col-9\">\n" . 
										"					" . $row['carrier_tracking_no'] . "\n" . 
										"				</div>\n" . 
										"			</div>\n" . 
										"			<div class=\"row\">\n" . 
										"				<label class=\"col-3\">Tracking URL</label>\n" . 
										"				<div class=\"col-9\">\n" . 
										($row['carrier_tracking_no'] != "" ? 
											"					<a href=\"https://www.ups.com/WebTracking/processInputRequest?tracknum=" . $row['carrier_tracking_no'] . "&loc=de_DE\" target=\"_blank\">öffnen <i class=\"fa fa-external-link\"> </i></a>\n"
										: 
											""
										) . 
										"				</div>\n" . 
										"			</div>\n" . 
										"			<div class=\"row\">\n" . 
										"				<label class=\"col-3\">Print Label</label>\n" . 
										"				<div class=\"col-9\">\n" . 
										($row['carrier_tracking_no'] != "" ? 
											"					<a href=\"/sendung/label/" . intval($_SESSION["admin"]["company_id"]) . "/" . $row['carrier_tracking_no'] . "\" target=\"_blank\">öffnen <i class=\"fa fa-external-link\"> </i></a>\n"
										: 
											""
										) . 
										"				</div>\n" . 
										"			</div>\n" . 
										"			<div class=\"row\">\n" . 
										"				<label class=\"col-3\">Label drucken</label>\n" . 
										"				<div class=\"col-9\">\n" . 
										($row['carrier_tracking_no'] != "" ? 
											"					<button type=\"button\" class=\"btn btn-success btn-sm\" onclick=\"if(navigator.appName == 'Microsoft Internet Explorer'){document.getElementById('label_frame_" . $row['id'] . "').print();}else{document.getElementById('label_frame_" . $row['id'] . "').contentWindow.print();}\">drucken <i class=\"fa fa-print\"> </i></button><br />\n" . 
											"					<iframe src=\"/sendung/label/" . intval($_SESSION["admin"]["company_id"]) . "/" . $row['carrier_tracking_no'] . "\" id=\"label_frame_" . $row['id'] . "\" width=\"30\" height=\"40\" style=\"visibility: hidden\"></iframe>\n"
										: 
											""
										) . 
										"				</div>\n" . 
										"			</div>\n" . 
										"			<div class=\"row\">\n" . 
										"				<label class=\"col-3\">Geräte</label>\n" . 
										"				<div class=\"col-9\">\n" . 

										($devices != "" ? "<div>" . $devices . "</div>" : "keine") . 

										"				</div>\n" . 
										"			</div>\n" . 
										"			<div class=\"row\">\n" . 
										"				<label class=\"col-3\">Beipackzettel</label>\n" . 
										"				<div class=\"col-9\">\n" . 
										"					" . ($row['file1_id'] > 0 ? "<a href=\"/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/attachments/" . $row['file1_file'] . "\" target=\"_blank\">" . $row['file1_name'] . " <i class=\"fa fa-external-link\"> </i></a>" : "kein") . "<br />" . ($row['file2_id'] > 0 ? "<a href=\"/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/attachments/" . $row['file2_file'] . "\" target=\"_blank\">" . $row['file2_name'] . " <i class=\"fa fa-external-link\"> </i></a>" : "kein") . "\n" . 
										"				</div>\n" . 
										"			</div>\n" . 
										"			<div class=\"row mb-5\">\n" . 
										"				<label class=\"col-3\">Zusatzartikel</label>\n" . 
										"				<div class=\"col-9\">\n" . 

										($items != "" ? "<div>" . $items . "</div>" : "keine") . 

										"				</div>\n" . 
										"			</div>\n" . 
										"			<div class=\"row\">\n" . 
										"				<label class=\"col-3\">Preis</label>\n" . 
										"				<div class=\"col-9\">\n" . 
										"					<span>" . number_format($row['price'], 2, ',', '') . " &euro;</span>\n" . 
										"				</div>\n" . 
										"			</div>\n" . 
										"			<div class=\"row\">\n" . 
										"				<label class=\"col-3\">Versandkosten</label>\n" . 
										"				<div class=\"col-9\">\n" . 
										"					<span>" . number_format($row['total_charges_with_taxes'], 2, ',', '') . " &euro;</span>\n" . 
										"				</div>\n" . 
										"			</div>\n" . 
										"			<div class=\"row\">\n" . 
										"				<label class=\"col-3\">Referenznummer</label>\n" . 
										"				<div class=\"col-9\">\n" . 
										"					<span>" . $row['reference_number'] . "</span>\n" . 
										"				</div>\n" . 
										"			</div>\n" . 
										"			<div class=\"row\">\n" . 
										"				<label class=\"col-3\">Versanddienstleister</label>\n" . 
										"				<div class=\"col-9\">\n" . 
										"					<span>UPS</span>\n" . 
										"				</div>\n" . 
										"			</div>\n" . 
										"			<div class=\"row\">\n" . 
										"				<label class=\"col-3\">Service</label>\n" . 
										"				<div class=\"col-9\">\n" . 
										($row['carrier_tracking_no'] != "" ? 
											"					<span>" . $carriers_services[$row['service']] . " - " . $carriers_services_costs[$row['service']] . " &euro;</span>\n"
										: 
											""
										) . 
										"				</div>\n" . 
										"			</div>\n" . 
										"			<div class=\"row\">\n" . 
										"				<label class=\"col-3\">Benachrichtigung</label>\n" . 
										"				<div class=\"col-9\">\n" . 
										"					<a href=\"mailto: " . $row['notification_email'] . "\">" . $row['notification_email'] . "</a>\n" . 
										"				</div>\n" . 
										"			</div>\n" . 
										"			<div class=\"row\">\n" . 
										"				<label class=\"col-3\">Auftraggeber</label>\n" . 
										"				<div class=\"col-9\">\n" . 
										"					<span>" . ($maindata['company'] != "" ? $maindata['company'] . ", " : "") . $maindata['firstname'] . " " . $maindata['lastname'] . "</span>\n" . 
										"				</div>\n" . 
										"			</div>\n" . 
										"			<div class=\"row\">\n" . 
										"				<label class=\"col-3\">Paket</label>\n" . 
										"				<div class=\"col-9\">\n" . 
										"					<span>Gewicht: " . number_format($row['weight'], 2, ',', '') . " KG, Länge: " . $row['length'] . " cm, Breite: " . $row['width'] . " cm, Höhe: " . $row['height'] . " cm</span>\n" . 
										"				</div>\n" . 
										"			</div>\n" . 
										"			<div class=\"row\">\n" . 
										"				<label class=\"col-3\">Status</label>\n" . 
										"				<div class=\"col-9\">\n" . 
										"					<span class=\"badge badge-pill badge-" . $shipping_statusses[$row['status']]['background'] . "\">" . $shipping_statusses[$row['status']]['description'] . "</span>\n" . 
										"				</div>\n" . 
										"			</div>\n" . 
										"			<div class=\"row\">\n" . 
										"				<label class=\"col-3\">UPS-Status</label>\n" . 
										"				<div class=\"col-9\">\n" . 
										"					<span>" . $str_status . "</span>\n" . 
										"				</div>\n" . 
										"			</div>\n" . 

										/*"			<div class=\"row\">\n" . 
										"				<label class=\"col-3\">Kunden Email</label>\n" . 
										"				<div class=\"col-9\">\n" . 
										"					<div class=\"custom-control custom-checkbox\">\n" . 
										"						<input type=\"checkbox\" id=\"usermail\" name=\"usermail\" value=\"1\"" . ((isset($_POST['usermail']) && intval($_POST['usermail']) >= 0 ? intval($_POST['usermail']) : 1) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
										"						<label class=\"custom-control-label\" for=\"usermail\">\n" . 
										"							Ja\n" . 
										"						</label>\n" . 
										"					</div>\n" . 
										"				</div>\n" . 
										"			</div>\n" . 

										"			<div class=\"row\">\n" . 
										"				<label class=\"col-3\">Admin Email</label>\n" . 
										"				<div class=\"col-9\">\n" . 
										"					<div class=\"custom-control custom-checkbox\">\n" . 
										"						<input type=\"checkbox\" id=\"adminmail\" name=\"adminmail\" value=\"1\"" . ((isset($_POST['adminmail']) && intval($_POST['adminmail']) >= 0 ? intval($_POST['adminmail']) : 1) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
										"						<label class=\"custom-control-label\" for=\"adminmail\">\n" . 
										"							Ja\n" . 
										"						</label>\n" . 
										"					</div>\n" . 
										"				</div>\n" . 
										"			</div>\n" . 

										"			<div class=\"row\">\n" . 
										"				<label class=\"col-3\">Begleitschein beifügen</label>\n" . 
										"				<div class=\"col-9\">\n" . 
										"					<div class=\"custom-control custom-checkbox\">\n" . 
										"						<input type=\"checkbox\" id=\"shippinng_storno_mail_with_pdf\" name=\"shippinng_storno_mail_with_pdf\" value=\"1\"" . ((isset($_POST['shippinng_storno_mail_with_pdf']) && intval($_POST['shippinng_storno_mail_with_pdf']) >= 0 ? intval($_POST['shippinng_storno_mail_with_pdf']) : 1) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
										"						<label class=\"custom-control-label\" for=\"shippinng_storno_mail_with_pdf\">\n" . 
										"							Ja\n" . 
										"						</label>\n" . 
										"					</div>\n" . 
										"				</div>\n" . 
										"			</div>\n" . */

										"		</div>\n" . 
										"		<div class=\"card-footer\">\n" . 

										"			<div class=\"row\">\n" . 
										"				<div class=\"col-sm-6\">\n" . 
										"				</div>\n" . 
										"				<div class=\"col-sm-6 text-right\">\n" . 
										"					<input type=\"hidden\" name=\"shipments_id\" value=\"" . $row['shipments_id'] . "\" />\n" . 
										"					<input type=\"hidden\" name=\"shipping_id\" value=\"" . $row['id'] . "\" />\n" . 
										"					<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
										($row['carrier_tracking_no'] != "" ? 
											"					<button type=\"submit\" name=\"shipping_status\" value=\"stornieren\" class=\"btn btn-danger\" onclick=\"return confirm('Wollen Sie diese Sendung wirklich stornieren?')\">stornieren</button>\n"
										: 
											""
										) . 
										"				</div>\n" . 
										"			</div>\n" . 

										"		</div>\n" . 
										"	</div>\n" . 
										"</form>\n" . 
										"<br />\n";

		}

		$list_shipments_status = $list_shipments_status != "" ? "<h4><u>Sendungen</u>:</h4><br />\n" . $list_shipments_status : "";

		$list_status_history .= 	"<tr>\n" . 
									"	<td width=\"140\">" . date("d.m.Y (H:i)", $row_order_status['time']) . "</td>\n" . 
									"	<td align=\"center\"><span class=\"badge badge-pill\" style=\"background-color: " . $row_order_status['status_color'] . "\">" . $row_order_status['status_name'] . "</span></td>\n" . 
									"	<td>" . $row_order_status['admin_name'] . "</td>\n" . 
									"	<td>" . $row_order_status['template'] . "</td>\n" . 
									"	<td>" . $row_order_status['subject'] . "</td>\n" . 
									"	<td class=\"text-center\">" . $row_order_status['email_reads'] . "</td>\n" . 
									"	<td width=\"50\" align=\"center\"><button type=\"button\" name=\"show_details\" value=\"DETAILS\" class=\"btn btn-success btn-sm\" onclick=\"showStatussesDialog('" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($row_order_status['subject'], ENT_QUOTES))))) . "<hr><br><br>', '" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($row_order_status['body'], ENT_QUOTES))))) . "<hr><br><br>', '" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($list_shipments_status, ENT_QUOTES))))) . "')\"><i class=\"fa fa-search-plus\" aria-hidden=\"true\"></i></button></td>\n" . 
									"</tr>\n";

	}

	$tabs_contents .= 	"				<div class=\"row\">\n" . 
						"					<div class=\"col-sm-6 border-right\">\n" . 

						"						<form action=\"" . $order_action . "\" method=\"post\">\n" . 
						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"status_id\" class=\"col-sm-2 col-form-label\">Status</label>\n" . 
						"								<div class=\"col-sm-3\">\n" . 
						"									<select id=\"status_id\" name=\"status_id\" class=\"custom-select\">\n" . 

						$new_status_options . 

						"									</select>\n" . 
						"								</div>\n" . 
						"								<div class=\"col-sm-4\">\n" . 
						"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
						"										<input type=\"checkbox\" id=\"no_email\" name=\"no_email\" value=\"1\" class=\"custom-control-input\" />\n" . 
						"										<label class=\"custom-control-label\" for=\"no_email\">\n" . 
						"											Keine E-Mail senden\n" . 
						"										</label>\n" . 
						"									</div>\n" . 
						"									<div class=\"custom-control custom-checkbox mt-2\">\n" . 
						"										<input type=\"checkbox\" id=\"public\" name=\"public\" value=\"1\" checked=\"checked\" class=\"custom-control-input\" />\n" . 
						"										<label class=\"custom-control-label\" for=\"public\">\n" . 
						"											öffentlich\n" . 
						"										</label>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
						"								<div class=\"col-sm-3\">\n" . 
						"									<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
						"									<button type=\"submit\" name=\"new_status\" value=\"durchführen\" class=\"btn btn-primary\">durchführen <i class=\"fa fa-level-up\" aria-hidden=\"true\"></i></button>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 
						"						</form>\n" . 

						$html_new_status . 

						"					</div>\n" . 
						"					<div class=\"col-sm-6\">\n" . 

						"						<form action=\"" . $order_action . "\" method=\"post\">\n" . 
						"							<div class=\"form-group row\">\n" . 
						"								<label for=\"email_template\" class=\"col-sm-3 col-form-label\">Email-Vorlage</label>\n" . 
						"								<div class=\"col-sm-4\">\n" . 
						"									<select id=\"email_template\" name=\"email_template\" class=\"custom-select\">\n" . 

						$new_email_options . 

						"									</select>\n" . 
						"								</div>\n" . 
						"								<div class=\"col-sm-5\">\n" . 
						"									<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
						"									<button type=\"submit\" name=\"new_email\" value=\"öffnen\" class=\"btn btn-success\">bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n" . 
						"									<button type=\"submit\" name=\"new_email\" value=\"sofort senden\" class=\"btn btn-primary\">senden <i class=\"fa fa-envelope-o\" aria-hidden=\"true\"></i></button>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 
						"						</form>\n" . 

						$html_new_email . 

						"					</div>\n" . 
						"				</div>\n" . 

						$emsg_shipping_cancel . 

						$list_status_history . 

						"					</table>\n" . 
						"				</div>\n";

?>