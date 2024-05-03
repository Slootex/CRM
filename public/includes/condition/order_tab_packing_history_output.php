<?php 

	$list_order_history = 	"				<div class=\"table-responsive overflow-auto border\" style=\"height: auto\">\n" . 
							"					<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
							"						<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
							"							<th width=\"140\"><strong>Datum</strong></th>\n" . 
							"							<th width=\"180\"><strong>Mitarbeiter</strong></th>\n" . 
							"							<th><strong>Nachricht</strong></th>\n" . 
							"							<th width=\"170\" class=\"text-center\"><strong>Aktion</strong></th>\n" . 
							"						</tr></thead>\n";

	$result = mysqli_query($conn, "	SELECT 		`order_orders_packing_history`.`id` AS id, 
												(
													SELECT 	name 
													FROM 	`admin` `admin` 
													WHERE 	`admin`.`id`=`order_orders_packing_history`.`admin_id` 
													AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
												) AS admin_name, 
												`order_orders_packing_history`.`message` AS message, 
												`order_orders_packing_history`.`status` AS status, 
												`order_orders_packing_history`.`time` AS time 
									FROM 		`order_orders_packing_history` `order_orders_packing_history` 
									WHERE 		`order_orders_packing_history`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
									AND 		`order_orders_packing_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`order_orders_packing_history`.`time` AS UNSIGNED) DESC");

	while($row_history = $result->fetch_array(MYSQLI_ASSOC)){

		$list_order_history .= 	"<tr" . ($row_history['status'] == 0 ? " class=\"bg-transparent text-black\"" : ($row_history['status'] == 1 ? " class=\"bg-danger text-white\"" : ($row_history['status'] == 2 ? " class=\"bg-success text-white\"" : ($row_history['status'] == 3 ? " class=\"bg-warning text-white\"" : "")))) . ">\n" . 
								"	<td>" . date("d.m.Y (H:i)", $row_history['time']) . "</td>\n" . 
								"	<td>" . $row_history['admin_name'] . "</td>\n" . 
								"	<td>" . str_replace("\r\n", " - ", $row_history['message']) . "</td>\n" . 
								"	<td align=\"center\">\n" . 
								"		<form action=\"" . $order_action . "\" method=\"post\" class=\"d-inline\">\n" . 
								"			<input type=\"hidden\" name=\"id\" value=\"" . $row_order['id'] . "\" />\n" . 
								"			<input type=\"hidden\" name=\"history_id\" value=\"" . $row_history['id'] . "\" />\n" . 
								"			<div class=\"btn-group\">\n" . 
								"				<button type=\"submit\" name=\"packing_history_status_order\" value=\"speichern_0\" class=\"btn btn-sm btn-primary text-light\" data-toggle=\"tooltip\" data-placement=\"left\" data-original-title=\"Neutral\" title=\"\"><i class=\"fa fa-comment\" aria-hidden=\"true\"></i></button>\n" . 
								"				<button type=\"submit\" name=\"packing_history_status_order\" value=\"speichern_1\" class=\"btn btn-sm btn-danger\" data-toggle=\"tooltip\" data-placement=\"left\" data-original-title=\"Anweisung\" title=\"\"><i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\"></i></button>\n" . 
								"				<button type=\"submit\" name=\"packing_history_status_order\" value=\"speichern_2\" class=\"btn btn-sm btn-success\" data-toggle=\"tooltip\" data-placement=\"left\" data-original-title=\"Erledigt\" title=\"\"><i class=\"fa fa-check-square\" aria-hidden=\"true\"></i></button>\n" . 
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
									"							<th width=\"140\"><strong>Datum</strong></th>\n" . 
									"							<th width=\"180\"><strong>Mitarbeiter</strong></th>\n" . 
									"							<th><strong>Nachricht</strong></th>\n" . 
									"							<th width=\"170\" class=\"text-center\"><strong>Aktion</strong></th>\n" . 
									"						</tr></thead>\n";

	$result = mysqli_query($conn, "	SELECT 		`interested_interesteds_packing_history`.`id` AS id, 
												(
													SELECT 	name 
													FROM 	`admin` `admin` 
													WHERE 	`admin`.`id`=`interested_interesteds_packing_history`.`admin_id` 
													AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
												) AS admin_name, 
												`interested_interesteds_packing_history`.`message` AS message, 
												`interested_interesteds_packing_history`.`status` AS status, 
												`interested_interesteds_packing_history`.`time` AS time 
									FROM 		`interested_interesteds_packing_history` `interested_interesteds_packing_history` 
									WHERE 		`interested_interesteds_packing_history`.`interested_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
									AND 		`interested_interesteds_packing_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`interested_interesteds_packing_history`.`time` AS UNSIGNED) DESC");

	while($row_history = $result->fetch_array(MYSQLI_ASSOC)){

		$list_interessent_history .= 	"<tr" . ($row_history['status'] == 0 ? " class=\"bg-transparent text-black\"" : ($row_history['status'] == 1 ? " class=\"bg-danger text-white\"" : ($row_history['status'] == 2 ? " class=\"bg-success text-white\"" : ($row_history['status'] == 3 ? " class=\"bg-warning text-white\"" : "")))) . ">\n" . 
										"	<td>" . date("d.m.Y (H:i)", $row_history['time']) . "</td>\n" . 
										"	<td>" . $row_history['admin_name'] . "</td>\n" . 
										"	<td>" . str_replace("\r\n", " - ", $row_history['message']) . "</td>\n" . 
										"	<td align=\"center\">\n" . 
										"		<form action=\"" . $order_action . "\" method=\"post\" class=\"d-inline\">\n" . 
										"			<input type=\"hidden\" name=\"id\" value=\"" . $row_order['id'] . "\" />\n" . 
										"			<input type=\"hidden\" name=\"history_id\" value=\"" . $row_history['id'] . "\" />\n" . 
										"			<div class=\"btn-group\">\n" . 
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
					
	$tabs_contents .= 	($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

						"				<h4>Aufträge</h4>\n" . 

						$list_order_history . 

						"					</table>\n" . 
						"				</div><br /><br /><br />\n" . 

						"				<h4>Interessenten</h4>\n" . 

						$list_interessent_history . 

						"					</table>\n" . 
						"				</div><br /><br /><br />\n";

?>