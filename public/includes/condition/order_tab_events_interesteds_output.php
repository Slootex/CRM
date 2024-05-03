<?php 

	$tab_events = "events_all";

	$events_all = "";
	$events_insert = "";
	$events_update = "";
	$events_delete = "";

	$result = mysqli_query($conn, "	SELECT 		`" . $order_table . "_events`.`id` AS id, 
												(
													SELECT 	name 
													FROM 	`admin` `admin` 
													WHERE 	`admin`.`id`=`" . $order_table . "_events`.`admin_id` 
													AND 	`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
												) AS admin_name, 
												`" . $order_table . "_events`.`type` AS type, 
												`" . $order_table . "_events`.`message` AS message, 
												`" . $order_table . "_events`.`subject` AS subject, 
												`" . $order_table . "_events`.`body` AS body, 
												`" . $order_table . "_events`.`time` AS time 
									FROM 		`" . $order_table . "_events` `" . $order_table . "_events` 
									WHERE 		`" . $order_table . "_events`.`" . $order_id_field . "`='" . $row_order['id'] . "' 
									AND 		`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`" . $order_table . "_events`.`time` AS UNSIGNED) DESC");

	while($row_events = $result->fetch_array(MYSQLI_ASSOC)){

		$events_all .= "											<tr><td width=\"140\">" . date("d.m.Y (H:i)", intval($row_events['time'])) . "</td><td>" . $row_events['admin_name'] . ", " . str_replace("\r\n", "", $row_events['message']) . "</td><td width=\"50\" align=\"center\"><button type=\"button\" name=\"show_details\" value=\"DETAILS\" class=\"btn btn-success btn-sm\"" . ($row_events['body'] == "" ? " disabled=\"disabled\"" : "") . " onclick=\"showStatussesDialog('" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($row_events['message'], ENT_QUOTES))))) . "<hr><br><br>', '" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($row_events['subject'], ENT_QUOTES))))) . "<hr><br><br>', '" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($row_events['body'], ENT_QUOTES))))) . "')\"><i class=\"fa fa-search-plus\" aria-hidden=\"true\"></i></button></td></tr>\n";

		if($row_events['type'] == 0){
			$events_insert .= "											<tr><td width=\"140\">" . date("d.m.Y (H:i)", intval($row_events['time'])) . "</td><td>" . $row_events['admin_name'] . ", " . str_replace("\r\n", "", $row_events['message']) . "</td><td width=\"50\" align=\"center\"><button type=\"button\" name=\"show_details\" value=\"DETAILS\" class=\"btn btn-success btn-sm\"" . ($row_events['body'] == "" ? " disabled=\"disabled\"" : "") . " onclick=\"showStatussesDialog('" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($row_events['message'], ENT_QUOTES))))) . "<hr><br><br>', '" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($row_events['subject'], ENT_QUOTES))))) . "<hr><br><br>', '" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($row_events['body'], ENT_QUOTES))))) . "')\"><i class=\"fa fa-search-plus\" aria-hidden=\"true\"></i></button></td></tr>\n";
		}

		if($row_events['type'] == 1){
			$events_update .= "											<tr><td width=\"140\">" . date("d.m.Y (H:i)", intval($row_events['time'])) . "</td><td>" . $row_events['admin_name'] . ", " . str_replace("\r\n", "", $row_events['message']) . "</td><td width=\"50\" align=\"center\"><button type=\"button\" name=\"show_details\" value=\"DETAILS\" class=\"btn btn-success btn-sm\"" . ($row_events['body'] == "" ? " disabled=\"disabled\"" : "") . " onclick=\"showStatussesDialog('" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($row_events['message'], ENT_QUOTES))))) . "<hr><br><br>', '" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($row_events['subject'], ENT_QUOTES))))) . "<hr><br><br>', '" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($row_events['body'], ENT_QUOTES))))) . "')\"><i class=\"fa fa-search-plus\" aria-hidden=\"true\"></i></button></td></tr>\n";
		}

		if($row_events['type'] == 2){
			$events_delete .= "											<tr><td width=\"140\">" . date("d.m.Y (H:i)", intval($row_events['time'])) . "</td><td>" . $row_events['admin_name'] . ", " . str_replace("\r\n", "", $row_events['message']) . "</td><td width=\"50\" align=\"center\"><button type=\"button\" name=\"show_details\" value=\"DETAILS\" class=\"btn btn-success btn-sm\"" . ($row_events['body'] == "" ? " disabled=\"disabled\"" : "") . " onclick=\"showStatussesDialog('" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($row_events['message'], ENT_QUOTES))))) . "<hr><br><br>', '" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($row_events['subject'], ENT_QUOTES))))) . "<hr><br><br>', '" . str_replace("\n", "", str_replace("\r\n", "", str_replace("/", "\\/", str_replace("&#039;", "*#039;", htmlentities($row_events['body'], ENT_QUOTES))))) . "')\"><i class=\"fa fa-search-plus\" aria-hidden=\"true\"></i></button></td></tr>\n";
		}

	}

	$tabs_contents .= 	"				<div class=\"row\">\n" . 
						"					<div class=\"col\">\n" . 
						"						<div class=\"card bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
						"							<div class=\"card-header\">\n" . 
						"								<div class=\"row\">\n" . 
						"									<div class=\"col-sm-8\">\n" . 
						"										<p class=\"text-primary\">Ereignishistorie</p>\n" . 
						"										<ul class=\"nav nav-tabs card-header-tabs\" id=\"eventsTab\" role=\"tablist\" style=\"float: left\">\n" . 
						"											<li class=\"nav-item\">\n" . 
						"												<a class=\"nav-link text-" . $_SESSION["admin"]["color_link"] . ($tab_events == "events_all" ? " active" : "") . "\" id=\"events_all-tab\" data-toggle=\"tab\" href=\"#events_all\" role=\"tab\" aria-controls=\"events_all\" aria-selected=\"" . ($tab_events == "events_all" ? "true" : "false") . "\">Alle</a>\n" . 
						"											</li>\n" . 
						"											<li class=\"nav-item\">\n" . 
						"												<a class=\"nav-link text-" . $_SESSION["admin"]["color_link"] . ($tab_events == "events_insert" ? " active" : "") . "\" id=\"events_insert-tab\" data-toggle=\"tab\" href=\"#events_insert\" role=\"tab\" aria-controls=\"events_insert\" aria-selected=\"" . ($tab_events == "events_insert" ? "true" : "false") . "\">Insert</a>\n" . 
						"											</li>\n" . 
						"											<li class=\"nav-item\">\n" . 
						"												<a class=\"nav-link text-" . $_SESSION["admin"]["color_link"] . ($tab_events == "events_update" ? " active" : "") . "\" id=\"events_update-tab\" data-toggle=\"tab\" href=\"#events_update\" role=\"tab\" aria-controls=\"events_update\" aria-selected=\"" . ($tab_events == "events_update" ? "true" : "false") . "\">Update</a>\n" . 
						"											</li>\n" . 
						"											<li class=\"nav-item\">\n" . 
						"												<a class=\"nav-link text-" . $_SESSION["admin"]["color_link"] . ($tab_events == "events_delete" ? " active" : "") . "\" id=\"events_delete-tab\" data-toggle=\"tab\" href=\"#events_delete\" role=\"tab\" aria-controls=\"events_delete\" aria-selected=\"" . ($tab_events == "events_delete" ? "true" : "false") . "\">Delete</a>\n" . 
						"											</li>\n" . 
						"										</ul>\n" . 
						"									</div>\n" . 
						"									<div class=\"col-sm-4 align-self-center\">\n" . 
						"										<form action=\"" . $order_action . "\" method=\"post\" style=\"float: right\" class=\"\">\n" . 
						"											<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
						"											<button type=\"submit\" name=\"delete\" value=\"Interessent unwiederuflich löschen\" onclick=\"return confirm('Wollen Sie den Eintrag wircklich entfernen?')\" class=\"btn btn-danger\">Interessent unwiederuflich löschen <i class=\"fa fa-ban\" aria-hidden=\"true\"></i></button>\n" . 
						"										</form>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
						"							</div>\n" . 
						"							<div class=\"tab-content\" id=\"eventsTabContent\">\n" . 

						// TAB Ereignisse - Alle
						"								<div class=\"card-body tab-pane fade" . ($tab_events == "events_all" ? " show active" : "") . " p-2\" id=\"events_all\" role=\"tabpanel\" aria-labelledby=\"events_all-tab\">\n" . 
						"									<div class=\"table-responsive overflow-auto border\" style=\"height: 750px\">\n" . 
						"										<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
						"											<thead>\n" . 
						"												<tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
						"													<th><strong>Datum</strong></th>\n" . 
						"													<th><strong>Information</strong></th>\n" . 
						"													<th><strong>&nbsp;</strong></th>\n" . 
						"												</tr>\n" . 
						"											</thead>\n" . 

						$events_all . 

						"										</table>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
						// TAB Ereignisse - Alle Ende

						// TAB Ereignisse - Insert's
						"								<div class=\"card-body tab-pane fade" . ($tab_events == "events_insert" ? " show active" : "") . " p-2\" id=\"events_insert\" role=\"tabpanel\" aria-labelledby=\"events_insert-tab\">\n" . 
						"									<div class=\"table-responsive overflow-auto border\" style=\"height: 750px\">\n" . 
						"										<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
						"											<thead>\n" . 
						"												<tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
						"													<th><strong>Datum</strong></th>\n" . 
						"													<th><strong>Information</strong></th>\n" . 
						"													<th><strong>&nbsp;</strong></th>\n" . 
						"												</tr>\n" . 
						"											</thead>\n" . 

						$events_insert . 

						"										</table>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
						// TAB Ereignisse - Insert's Ende

						// TAB Ereignisse - Update's
						"								<div class=\"card-body tab-pane fade" . ($tab_events == "events_update" ? " show active" : "") . " p-2\" id=\"events_update\" role=\"tabpanel\" aria-labelledby=\"events_update-tab\">\n" . 
						"									<div class=\"table-responsive overflow-auto border\" style=\"height: 750px\">\n" . 
						"										<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
						"											<thead>\n" . 
						"												<tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
						"													<th><strong>Datum</strong></th>\n" . 
						"													<th><strong>Information</strong></th>\n" . 
						"													<th><strong>&nbsp;</strong></th>\n" . 
						"												</tr>\n" . 
						"											</thead>\n" . 

						$events_update . 

						"										</table>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
						// TAB Ereignisse - Update's Ende

						// TAB Ereignisse - Delete's
						"								<div class=\"card-body tab-pane fade" . ($tab_events == "events_delete" ? " show active" : "") . " p-2\" id=\"events_delete\" role=\"tabpanel\" aria-labelledby=\"events_delete-tab\">\n" . 
						"									<div class=\"table-responsive overflow-auto border\" style=\"height: 750px\">\n" . 
						"										<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
						"											<thead>\n" . 
						"												<tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
						"													<th><strong>Datum</strong></th>\n" . 
						"													<th><strong>Information</strong></th>\n" . 
						"													<th><strong>&nbsp;</strong></th>\n" . 
						"												</tr>\n" . 
						"											</thead>\n" . 

						$events_delete . 

						"										</table>\n" . 
						"									</div>\n" . 
						"								</div>\n" . 
						// TAB Ereignisse - Delete's Ende

						"							</div>\n" . 
						"						</div>\n" . 
						"					</div>\n" . 
						"				</div>\n";

?>