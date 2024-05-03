<?php 

	$list_history = "				<hr />\n" . 
					"				<div class=\"table-responsive overflow-auto border\" style=\"height: 750px\">\n" . 
					"					<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
					"						<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
					"							<th width=\"140\"><strong>Datum</strong></th>\n" . 
					"							<th width=\"180\"><strong>Mitarbeiter</strong></th>\n" . 
					"							<th><strong>Nachricht</strong></th>\n" . 
					"							<th width=\"210\" class=\"text-center\"><strong>Aktion</strong></th>\n" . 
					"						</tr></thead>\n";

	$result = mysqli_query($conn, "	SELECT 		`" . $users_table . "_history`.`id` AS id, 
												(
													SELECT 	name 
													FROM 	`admin` `admin` 
													WHERE 	`admin`.`id`=`" . $users_table . "_history`.`admin_id` 
													AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
												) AS admin_name, 
												`" . $users_table . "_history`.`message` AS message, 
												`" . $users_table . "_history`.`status` AS status, 
												`" . $users_table . "_history`.`time` AS time 
									FROM 		`" . $users_table . "_history` `" . $users_table . "_history` 
									WHERE 		`" . $users_table . "_history`.`" . $users_id_field . "`='" . $row_user['id'] . "' 
									AND 		`" . $users_table . "_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`" . $users_table . "_history`.`time` AS UNSIGNED) DESC");

	while($row_history = $result->fetch_array(MYSQLI_ASSOC)){

		$list_history .= 	"<tr" . ($row_history['status'] == 1 ? " class=\"bg-danger text-white\"" : ($row_history['status'] == 2 ? " class=\"bg-success text-white\"" : ($row_history['status'] == 3 ? " class=\"bg-warning text-white\"" : ""))) . ">\n" . 
							"	<td>" . date("d.m.Y (H:i)", $row_history['time']) . "</td>\n" . 
							"	<td>" . $row_history['admin_name'] . "</td>\n" . 
							"	<td>" . str_replace("\r\n", " - ", $row_history['message']) . "</td>\n" . 
							"	<td width=\"160\" align=\"center\">\n" . 
							"		<form action=\"" . $users_action . "\" method=\"post\">\n" . 
							"			<div class=\"btn-group\">\n" . 
							"				<select name=\"status\" class=\"custom-select custom-select-sm\" style=\"width: 110px;border-radius: .25rem 0 0 .25rem\">\n" . 
							"					<option value=\"0\"" . ($row_history['status'] == 0 ? " selected=\"selected\"" : "") . ">Neutral</option>\n" . 
							"					<option value=\"1\"" . ($row_history['status'] == 1 ? " selected=\"selected\"" : "") . " class=\"bg-danger text-white\">Anweisung</option>\n" . 
							"					<option value=\"2\"" . ($row_history['status'] == 2 ? " selected=\"selected\"" : "") . " class=\"bg-success text-white\">Erledigt</option>\n" . 
							"					<option value=\"3\"" . ($row_history['status'] == 3 ? " selected=\"selected\"" : "") . " class=\"bg-warning text-white\">Extern</option>\n" . 
							"				</select>\n" . 
							"				<input type=\"hidden\" name=\"id\" value=\"" . $row_user['id'] . "\" />\n" . 
							"				<input type=\"hidden\" name=\"history_id\" value=\"" . $row_history['id'] . "\" />\n" . 
							"				<button type=\"submit\" name=\"history_status\" value=\"speichern\" class=\"btn btn-sm btn-primary\"><i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
							"				" . ($_SESSION["admin"]["roles"]["history_message_delete"] == 1 ? "<button type=\"submit\" name=\"history_delete\" value=\"X\" class=\"btn btn-sm btn-danger\" onclick=\"return confirm('Sind Sie sicher, das Sie die Nachricht entfernen wollen?')\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></button>\n" : "\n") . 
							"				<button type=\"button\" name=\"show_details\" value=\"DETAILS\" class=\"btn btn-success btn-sm\" onclick=\"showStatussesDialog('" . str_replace("\"", "\\'", str_replace("\n", "", str_replace("\r\n", "<br />", $row_history['message']))) . "', '', '')\"><i class=\"fa fa-search-plus\" aria-hidden=\"true\"></i></button>\n" . 
							"			</div>\n" . 
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
						"							<button type=\"submit\" name=\"history\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
						"						</div>\n" . 
						"					</div>\n" . 
						"				</form>\n" . 

						$list_history . 

						"					</table>\n" . 
						"				</div>\n";

?>