<?php 

	$array_intern_text_module = array();

	$array_intern_text_module[0] = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`text_modules` 
									WHERE 		`text_modules`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`text_modules`.`id` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$array_intern_text_module[$row['id']] = $row['name'];

	}

	$buttons_phonehistory = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`text_history` 
									WHERE 		`text_history`.`enable`='1' 
									AND 		`text_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`text_history`.`pos` AS UNSIGNED) ASC");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		if($row['area'] == 0){

			$buttons_phonehistory .= "								<button type=\"button\" class=\"btn btn-warning btn-sm mb-1\" onclick=\"var space = ($('#message_phonehistory').text() == '' ? '' : ' ');\$('#message_phonehistory').text(\$('#message_phonehistory').text() + space + '" . $row['text'] . "');/*window.setTimeout(function(){\$('#customer_message_order').click();}, 1000);*/\">" . $row['name'] . " <i class=\"fa fa-arrow-circle-o-up\"> </i></button> \n";

		}

	}

	$list_interessent_customer_history = 	"				<div class=\"table-responsive overflow-auto border\" style=\"height: auto\">\n" . 
											"					<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
											"						<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
											"							<th width=\"140\"><strong>Datum</strong></th>\n" . 
											"							<th width=\"180\"><strong>Mitarbeiter</strong></th>\n" . 
											"							<th><strong>Nachricht</strong></th>\n" . 
											"							<th width=\"80\" class=\"text-center\"><strong>Aktion</strong></th>\n" . 
											"						</tr></thead>\n";

	$result = mysqli_query($conn, "	SELECT 		`interested_interesteds_customer_messages`.`id` AS id, 
												(
													SELECT 	name 
													FROM 	`admin` `admin` 
													WHERE 	`admin`.`id`=`interested_interesteds_customer_messages`.`admin_id` 
													AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
												) AS admin_name, 
												`interested_interesteds_customer_messages`.`message` AS message, 
												`interested_interesteds_customer_messages`.`time` AS time 
									FROM 		`interested_interesteds_customer_messages` `interested_interesteds_customer_messages` 
									WHERE 		`interested_interesteds_customer_messages`.`interested_id`='" . $row_order['id'] . "' 
									AND 		`interested_interesteds_customer_messages`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`interested_interesteds_customer_messages`.`time` AS UNSIGNED) DESC");

	while($row_customer_history = $result->fetch_array(MYSQLI_ASSOC)){

		$list_interessent_customer_history .= 	"<tr" . ($order_mode == 0 ? " class=\"bg-secondary\"" : "") . ">\n" . 
												"	<td>" . date("d.m.Y (H:i)", $row_customer_history['time']) . "</td>\n" . 
												"	<td>" . $row_customer_history['admin_name'] . "</td>\n" . 
												"	<td>" . str_replace("\r\n", " - ", $row_customer_history['message']) . "</td>\n" . 
												"	<td align=\"center\">\n" . 
												"		<form action=\"" . $order_action . "\" method=\"post\">\n" . 
												"			<div class=\"btn-group\">\n" . 
												"				" . ($_SESSION["admin"]["roles"]["customer_message_delete"] == 1 ? "<button type=\"submit\" name=\"customer_history_delete_interessent\" value=\"X\" class=\"btn btn-sm btn-danger\" onclick=\"return confirm('Sind Sie sicher, das Sie die Nachricht entfernen wollen?')\" disabled=\"disabled\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></button>\n" : "\n") . 
												"				<button type=\"button\" name=\"show_details\" value=\"DETAILS\" class=\"btn btn-success btn-sm\" onclick=\"showStatussesDialog('" . str_replace("\"", "\\'", str_replace("\n", "", str_replace("\r\n", "<br />", $row_customer_history['message']))) . "', '', '')\"><i class=\"fa fa-search-plus\" aria-hidden=\"true\"></i></button>\n" . 
												"			</div>\n" . 
												"			<input type=\"hidden\" name=\"id\" value=\"" . $row_order['id'] . "\" />\n" . 
												"			<input type=\"hidden\" name=\"customer_history_id\" value=\"" . $row_customer_history['id'] . "\" />\n" . 
												"		</form>\n" . 
												"	</td>\n" . 
												"</tr>\n";

	}

	$list_order_customer_history = 	"				<div class=\"table-responsive overflow-auto border\" style=\"height: auto\">\n" . 
									"					<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
									"						<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
									"							<th width=\"140\"><strong>Datum</strong></th>\n" . 
									"							<th width=\"180\"><strong>Mitarbeiter</strong></th>\n" . 
									"							<th><strong>Nachricht</strong></th>\n" . 
									"							<th width=\"140\"><strong>Kundenname</strong></th>\n" . 
									"							<th width=\"140\"><strong>Zeit</strong></th>\n" . 
									"							<th width=\"140\"><strong>Stufe</strong></th>\n" . 
									"							<th width=\"80\" class=\"text-center\"><strong>Aktion</strong></th>\n" . 
									"						</tr></thead>\n";

	$level_entries = 0;

	$result = mysqli_query($conn, "	SELECT 		`order_orders_customer_messages`.`id` AS id, 
												`order_orders_customer_messages`.`is_level` AS is_level, 
												(
													SELECT 	name 
													FROM 	`admin` `admin` 
													WHERE 	`admin`.`id`=`order_orders_customer_messages`.`admin_id` 
													AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
												) AS admin_name, 
												`order_orders_customer_messages`.`message` AS message, 
												`order_orders_customer_messages`.`customer` AS customer, 
												`order_orders_customer_messages`.`status` AS status, 
												`order_orders_customer_messages`.`level_time` AS level_time, 
												`order_orders_customer_messages`.`level` AS level, 
												`order_orders_customer_messages`.`time` AS time 
									FROM 		`order_orders_customer_messages` `order_orders_customer_messages` 
									WHERE 		`order_orders_customer_messages`.`order_id`='" . $row_order['id'] . "' 
									AND 		`order_orders_customer_messages`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`order_orders_customer_messages`.`time` AS UNSIGNED) DESC");

	while($row_customer_history = $result->fetch_array(MYSQLI_ASSOC)){

		if($row_customer_history['is_level'] == 1){
			$level_entries++;
		}

		$list_order_customer_history .= 	"<tr class=\"" . ($row_customer_history['status'] == 1 ? "bg-warning" : "") . "\">\n" . 
											"	<td>" . date("d.m.Y (H:i)", $row_customer_history['time']) . "</td>\n" . 
											"	<td>" . $row_customer_history['admin_name'] . "</td>\n" . 
											"	<td>" . str_replace("\r\n", " - ", $row_customer_history['message']) . "</td>\n" . 
											"	<td>" . $row_customer_history['customer'] . "</td>\n" . 
											"	<td>" . $row_customer_history['level_time'] . "</td>\n" . 
											"	<td>" . $row_customer_history['level'] . "</td>\n" . 
											"	<td align=\"center\">\n" . 
											"		<form action=\"" . $order_action . "\" method=\"post\">\n" . 
											"			<div class=\"btn-group\">\n" . 
											"				" . ($_SESSION["admin"]["roles"]["customer_message_delete"] == 1 ? "<button type=\"submit\" name=\"customer_history_delete_order\" value=\"X\" class=\"btn btn-sm btn-danger\" onclick=\"return confirm('Sind Sie sicher, das Sie die Nachricht entfernen wollen?')\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></button>\n" : "\n") . 
											"				<button type=\"button\" name=\"show_details\" value=\"DETAILS\" class=\"btn btn-success btn-sm\" onclick=\"showStatussesDialog('" . str_replace("\"", "\\'", str_replace("\n", "", str_replace("\r\n", "<br />", $row_customer_history['message']))) . "', '', '')\"><i class=\"fa fa-search-plus\" aria-hidden=\"true\"></i></button>\n" . 
											"			</div>\n" . 
											"			<input type=\"hidden\" name=\"id\" value=\"" . $row_order['id'] . "\" />\n" . 
											"			<input type=\"hidden\" name=\"customer_history_id\" value=\"" . $row_customer_history['id'] . "\" />\n" . 
											"		</form>\n" . 
											"	</td>\n" . 
											"</tr>\n";

	}

	$weekdays = array("So.", "Mo.", "Di.", "Mi.", "Do.", "Fr.", "Sa.");


	$tabs_contents .= 	"				<h4>Aufträge</h4>\n" . 

						"				<form action=\"" . $order_action . "\" method=\"post\">\n" . 
						"					<div class=\"form-group row\">\n" . 
						"						<label class=\"col-sm-3 col-form-label\">Durchgeführte Arbeit / Zeit</label>\n" . 
						"						<div class=\"col-sm-4\">\n" . 
						"							<input type=\"text\" value=\"" . $array_intern_text_module[$row_order['intern_text_module_history']] . "\" class=\"form-control\" disabled=\"disabled\" />\n" . 
						"						</div>\n" . 
						"						<div class=\"col-sm-1\">\n" . 
						"							<input type=\"text\" value=\"" . $row_order['intern_time_history'] . "\" class=\"form-control\" disabled=\"disabled\" />\n" . 
						"						</div>\n" . 
						"					</div>\n" . 
						"					<div class=\"form-group row\">\n" . 
						"						<label for=\"message_phonehistory\" class=\"col-sm-3 col-form-label\">Nachricht</label>\n" . 
						"						<div class=\"col-sm-5\">\n" . 
						"							<textarea id=\"message_phonehistory\" name=\"message\" class=\"form-control\">" . $message . "</textarea>\n" . 
						"						</div>\n" . 
						"						<div class=\"col-sm-4\">\n" . 
						"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
						"							<input type=\"hidden\" name=\"status_id\" value=\"" . intval($row_order['last_status_id']) . "\" />\n" . 
						"							<button type=\"submit\" id=\"customer_message_order\" name=\"customer_message_order\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
						(time() > (intval($row_order['his_date']) + (intval($maindata['customer_history_delay_time']) * 60)) ? 
							($row_order['level_amount'] > 0 ? 
								($level_entries < $row_order['level_amount'] ? 
									"							<button type=\"submit\" id=\"customer_message_level\" name=\"customer_message_level\" value=\"stufe\" class=\"btn btn-primary\">Statusabfrage <i class=\"fa fa-clock-o\" aria-hidden=\"true\"></i></button>\n"
								: 
									"							<button type=\"button\" id=\"customer_message_level\" name=\"customer_message_level\" value=\"stufe\" class=\"btn btn-primary\" onclick=\"alert('Die maximale Anzahl an Stufeneinträgen ist erreicht!')\">Statusabfrage <i class=\"fa fa-clock-o\" aria-hidden=\"true\"></i></button>\n"
								)
							: 
								"							<button type=\"button\" id=\"customer_message_level\" name=\"customer_message_level\" value=\"stufe\" class=\"btn btn-primary\" onclick=\"alert('Der letzte Status hat keine Stufen!')\">Statusabfrage <i class=\"fa fa-clock-o\" aria-hidden=\"true\"></i></button>\n"
							)
						: 
							"							<button type=\"button\" id=\"customer_message_level\" name=\"customer_message_level\" value=\"stufe\" class=\"btn btn-primary\" onclick=\"alert('Bitte letzte Information lesen!\\nVersuchen Sie es am " . date("d.m.Y", (intval($row_order['his_date']) + (intval($maindata['customer_history_delay_time']) * 60))) . " um " . date("H:i", (intval($row_order['his_date']) + (intval($maindata['customer_history_delay_time']) * 60))) . " Uhr!')\">Statusabfrage <i class=\"fa fa-clock-o\" aria-hidden=\"true\"></i></button>\n"
						) . 
						"							<br /><br/>\n" . 
						(intval($row_order['mode']) == 0 || intval($row_order['mode']) == 1 ? 
							"							<button type=\"submit\" id=\"customer_message_claim\" name=\"customer_message_claim\" value=\"speichern\" class=\"btn btn-danger text-white\">Reklamation eingegangenen <i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\"></i></button>\n"
						: 
							""
						) . 
						"							<button type=\"submit\" id=\"customer_message_recall\" name=\"customer_message_recall\" value=\"speichern\" class=\"btn btn-danger text-white\">Rückruf vereinbart <i class=\"fa fa-phone\" aria-hidden=\"true\"></i></button>\n" . 
						"						</div>\n" . 
						"					</div>\n" . 
						"					<div class=\"form-group row\">\n" . 
						"						<label for=\"message_phonehistory\" class=\"col-sm-3 col-form-label\">Kundenname</label>\n" . 
						"						<div class=\"col-sm-5\">\n" . 
						"							<input type=\"text\" id=\"customer_phonehistory\" name=\"customer\" value=\"" . $customer . "\" class=\"form-control\" />\n" . 
						"						</div>\n" . 
						"						<div class=\"col-sm-4\">\n" . 
						"						</div>\n" . 
						"					</div>\n" . 
						"					<div class=\"form-group row\">\n" . 
						"						<label class=\"col-sm-3 col-form-label\">" . ($buttons_phonehistory != "" ? "Einfügen" : "&nbsp;") . "</label>\n" . 
						"						<div class=\"col-sm-5\">\n" . 

						$buttons_phonehistory . 

						"						</div>\n" . 
						"					</div>\n" . 
						(intval($row_order['mode']) == 2 || intval($row_order['mode']) == 3 ? 
							"					<div class=\"form-group row\">\n" . 
							"						<label class=\"col-sm-3 col-form-label\">Rückruf Datum / Zeit</label>\n" . 
							"						<div class=\"col-sm-3\">\n" . 
							"							<div class=\"input-group date\">\n" . 
							"								<input type=\"text\" id=\"recall_date\" name=\"recall_date\" value=\"" . (isset($_POST['recall']) && $_POST['recall'] == "speichern" ? date("d.m.Y H:i", strtotime($_POST['recall_date'])) : ($row_order['recall_date'] != "" ? date("d.m.Y H:i", intval($row_order["recall_date"])) : date("d.m.Y H:i", time()))) . "\" placeholder=\"00.00.0000\" class=\"form-control" . $inp_recall_date . "\" />\n" . 
							/*"								<div class=\"input-group-append\">\n" . 
							"									<span class=\"input-group-text\">Datum</span>\n" . 
							"								</div>\n" . */
							"							</div>\n" . 
							"						</div>\n" . 
							"						<div class=\"col-sm-2\">\n" . 
							"							<h2>" . 
								(isset($_POST['recall']) && $_POST['recall'] == "speichern" ? $weekdays[intval(date("w", strtotime($_POST['recall_date'])))] : ($row_order['recall_date'] != "" ? $weekdays[intval(date("w", intval($row_order["recall_date"])))] : $weekdays[intval(date("w", time()))])) . 
								", " . 
								(isset($_POST['recall']) && $_POST['recall'] == "speichern" ? date("d.m.Y", strtotime($_POST['recall_date'])) : ($row_order['recall_date'] != "" ? date("d.m.Y", intval($row_order["recall_date"])) : date("d.m.Y", time()))) . 
							"							</h2>\n" . 
							"							<div class=\"row\">\n" . 
							"								<div class=\"col w-25 alert alert-success p-3 text-center\">\n" . 
							"									<h1 class=\"my-1\">" . (isset($_POST['recall']) && $_POST['recall'] == "speichern" ? date("H", strtotime($_POST['recall_date'])) : ($row_order['recall_date'] != "" ? date("H", intval($row_order["recall_date"])) : date("H", time()))) . "</h1>\n" . 
							"								</div>\n" . 
							"								<div class=\"alert text-center\"><h1>:</h1></div>\n" . 
							"								<div class=\"col w-25 alert alert-secondary p-3 text-center\">\n" . 
							"									<h1 class=\"my-1\">" . (isset($_POST['recall']) && $_POST['recall'] == "speichern" ? date("i", strtotime($_POST['recall_date'])) : ($row_order['recall_date'] != "" ? date("i", intval($row_order["recall_date"])) : date("i", time()))) . "</h1>\n" . 
							"								</div>\n" . 
							"							</div>\n" . 
							"						</div>\n" . 
							"						<div class=\"col-sm-4\">\n" . 
							"							<br /><br /><br /><button type=\"submit\" name=\"recall\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-clock-o\" aria-hidden=\"true\"></i></button>\n" . 
							"							<button type=\"submit\" name=\"recall\" value=\"clear\" class=\"btn btn-success text-white\">Rückruf erledigt <i class=\"fa fa-phone\" aria-hidden=\"true\"></i></button>\n" . 
							"						</div>\n" . 
							"					</div>\n" 
						: 
							""
						) .
						"				</form>\n" . 

						$list_order_customer_history . 

						"					</table>\n" . 
						"				</div><br /><br /><br />\n" . 

						"				<h4>Interessenten</h4>\n" . 

						$list_interessent_customer_history . 

						"					</table>\n" . 
						"				</div><br /><br /><br />\n";

?>