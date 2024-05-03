<?php 

	$list_customer_history = 	"				<hr />\n" . 
								"				<div class=\"table-responsive overflow-auto border\" style=\"height: 750px\">\n" . 
								"					<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
								"						<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
								"							<th width=\"140\"><strong>Datum</strong></th>\n" . 
								"							<th width=\"180\"><strong>Mitarbeiter</strong></th>\n" . 
								"							<th><strong>Nachricht</strong></th>\n" . 
								"							<th width=\"80\" class=\"text-center\"><strong>Aktion</strong></th>\n" . 
								"						</tr></thead>\n";

	$result = mysqli_query($conn, "	SELECT 		`" . $users_table . "_customer_messages`.`id` AS id, 
												(
													SELECT 	name 
													FROM 	`admin` `admin` 
													WHERE 	`admin`.`id`=`" . $users_table . "_customer_messages`.`admin_id` 
													AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
												) AS admin_name, 
												`" . $users_table . "_customer_messages`.`message` AS message, 
												`" . $users_table . "_customer_messages`.`time` AS time 
									FROM 		`" . $users_table . "_customer_messages` `user_users_customer_messages` 
									WHERE 		`" . $users_table . "_customer_messages`.`" . $users_id_field . "`='" . $row_user['id'] . "' 
									AND 		`" . $users_table . "_customer_messages`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`" . $users_table . "_customer_messages`.`time` AS UNSIGNED) DESC");

	while($row_customer_history = $result->fetch_array(MYSQLI_ASSOC)){

		$list_customer_history .= 	"<tr>\n" . 
									"	<td>" . date("d.m.Y (H:i)", $row_customer_history['time']) . "</td>\n" . 
									"	<td>" . $row_customer_history['admin_name'] . "</td>\n" . 
									"	<td>" . str_replace("\r\n", " - ", $row_customer_history['message']) . "</td>\n" . 
									"	<td align=\"center\">\n" . 
									"		<form action=\"" . $users_action . "\" method=\"post\">\n" . 
									"			<div class=\"btn-group\">\n" . 
									"				" . ($_SESSION["admin"]["roles"]["customer_message_delete"] == 1 ? "<button type=\"submit\" name=\"customer_history_delete\" value=\"X\" class=\"btn btn-sm btn-danger\" onclick=\"return confirm('Sind Sie sicher, das Sie die Nachricht entfernen wollen?')\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></button>\n" : "\n") . 
									"				<button type=\"button\" name=\"show_details\" value=\"DETAILS\" class=\"btn btn-success btn-sm\" onclick=\"showStatussesDialog('" . str_replace("\"", "\\'", str_replace("\n", "", str_replace("\r\n", "<br />", $row_customer_history['message']))) . "', '', '')\"><i class=\"fa fa-search-plus\" aria-hidden=\"true\"></i></button>\n" . 
									"			</div>\n" . 
									"			<input type=\"hidden\" name=\"id\" value=\"" . $row_user['id'] . "\" />\n" . 
									"			<input type=\"hidden\" name=\"customer_history_id\" value=\"" . $row_customer_history['id'] . "\" />\n" . 
									"		</form>\n" . 
									"	</td>\n" . 
									"</tr>\n";

	}

	$tabs_contents .= 	"				<form action=\"" . $users_action . "\" method=\"post\">\n" . 
						"					<div class=\"form-group row\">\n" . 
						"						<label for=\"message\" class=\"col-sm-3 col-form-label\">Nachricht</label>\n" . 
						"						<div class=\"col-sm-5\">\n" . 
						"							<textarea id=\"message\" name=\"message\" class=\"form-control\">" . $message . "</textarea>\n" . 
						"						</div>\n" . 
						"						<div class=\"col-sm-4\">\n" . 
						"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
						"							<button type=\"submit\" name=\"customer_message\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
						"						</div>\n" . 
						"					</div>\n" . 
						"				</form>\n" . 

						$list_customer_history . 

						"					</table>\n" . 
						"				</div>\n";

?>