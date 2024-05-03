<?php 

	$result_statuses = mysqli_query($conn, "	SELECT 		* 
												FROM 		`statuses` 
												WHERE 		`statuses`.`type`='" . mysqli_real_escape_string($conn, intval($shopping_templates_type)) . "' 
												AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
												AND 		`statuses`.`status_status`='1' 
												ORDER BY 	CAST(`statuses`.`id` AS UNSIGNED) ASC");

	$new_status_options = "";

	while($row = $result_statuses->fetch_array(MYSQLI_ASSOC)){

		$new_status_options .= "				<option value=\"" . $row["id"] . "\"" . (isset($_POST["status_id"]) && $row["id"] == intval($_POST["status_id"]) ? " selected=\"selected\"" : "") . ">" . substr($row['name'], 0, 80) . "</option>\n";

	}

	$result_templates = mysqli_query($conn, "	SELECT 		* 
												FROM 		`templates` 
												WHERE 		`templates`.`type`=" . mysqli_real_escape_string($conn, intval($shopping_templates_type)) . " 
												AND 		`templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 

												AND 		`templates`.`id`!=(SELECT email_template FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`='" . mysqli_real_escape_string($conn, intval($maindata['shopping_status'])) . "') 
												AND 		`templates`.`id`!=(SELECT email_template FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`='" . mysqli_real_escape_string($conn, intval($maindata['shopping_to_archive_status'])) . "') 
												AND 		`templates`.`id`!=(SELECT email_template FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`='" . mysqli_real_escape_string($conn, intval($maindata['archive_to_shoppings_status'])) . "') 

												AND 		`templates`.`id`!=(SELECT email_template FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`=" . mysqli_real_escape_string($conn, intval($maindata['retoure_status'])) . ") 
												AND 		`templates`.`id`!=(SELECT email_template FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`=" . mysqli_real_escape_string($conn, intval($maindata['shopping_to_retoures_status'])) . ") 
												AND 		`templates`.`id`!=(SELECT email_template FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`=" . mysqli_real_escape_string($conn, intval($maindata['retoure_to_shoppings_status'])) . ") 

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

	$result_statuses = mysqli_query($conn, "	SELECT 		`" . $shopping_table . "_statuses`.`id` AS id, 
															`" . $shopping_table . "_statuses`.`status_number` AS status_number, 
															`" . $shopping_table . "_statuses`.`time` AS time, 
															(
																SELECT 	name
																FROM 	`admin` `admin`
																WHERE 	`admin`.`id`=`" . $shopping_table . "_statuses`.`admin_id` 
																AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
															) AS admin_name, 
															`" . $shopping_table . "_statuses`.`template` AS template, 
															`" . $shopping_table . "_statuses`.`subject` AS subject, 
															`" . $shopping_table . "_statuses`.`body` AS body, 
															`" . $shopping_table . "_statuses`.`email_reads` AS email_reads, 
															`statuses`.`name` AS status_name, 
															`statuses`.`color` AS status_color 
												FROM 		`" . $shopping_table . "_statuses` `" . $shopping_table . "_statuses`
												LEFT JOIN 	`statuses` `statuses` 
												ON 			`statuses`.`id`=`" . $shopping_table . "_statuses`.`status_id`
												WHERE 		`" . $shopping_table . "_statuses`.`shopping_id`='" . mysqli_real_escape_string($conn, intval($row_shopping['id'])) . "' 
												AND 		`" . $shopping_table . "_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
												AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
												ORDER BY 	CAST(`" . $shopping_table . "_statuses`.`time` AS UNSIGNED) DESC");

	while($row_shopping_status = $result_statuses->fetch_array(MYSQLI_ASSOC)){

		$list_shipments_status = "";


		$list_status_history .= 	"<tr>\n" . 
									"	<td width=\"140\">" . date("d.m.Y (H:i)", $row_shopping_status['time']) . "</td>\n" . 
									"	<td align=\"center\"><span class=\"badge badge-pill\" style=\"background-color: " . $row_shopping_status['status_color'] . "\">" . $row_shopping_status['status_name'] . "</span></td>\n" . 
									"	<td>" . $row_shopping_status['admin_name'] . "</td>\n" . 
									"	<td>" . $row_shopping_status['template'] . "</td>\n" . 
									"	<td>" . $row_shopping_status['subject'] . "</td>\n" . 
									"	<td class=\"text-center\">" . $row_shopping_status['email_reads'] . "</td>\n" . 
									"	<td width=\"50\" align=\"center\"><button type=\"button\" name=\"show_details\" value=\"DETAILS\" class=\"btn btn-success btn-sm\" onclick=\"showStatussesDialog('" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($row_shopping_status['subject'], ENT_QUOTES))))) . "<hr><br><br>', '" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($row_shopping_status['body'], ENT_QUOTES))))) . "<hr><br><br>', '" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($list_shipments_status, ENT_QUOTES))))) . "')\"><i class=\"fa fa-search-plus\" aria-hidden=\"true\"></i></button></td>\n" . 
									"</tr>\n";

	}

	$tabs_contents .= 	"				<div class=\"row\">\n" . 
						"					<div class=\"col-sm-6 border-right\">\n" . 

						"						<form action=\"" . $shopping_action . "\" method=\"post\">\n" . 
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

						"						<form action=\"" . $shopping_action . "\" method=\"post\">\n" . 
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