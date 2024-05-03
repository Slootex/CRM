<?php 

	$pageNumberlist_shopin = new pageList();

	$list = "";
	
	$where = 	isset($_SESSION[$packing_session]["keyword"]) && $_SESSION[$packing_session]["keyword"] != "" ? 
				"WHERE 	(`shopin_shopins`.`id` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$packing_session]["keyword"]) . "%' 
				OR		`shopin_shopins`.`shopin_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$packing_session]["keyword"]) . "%' 
				OR		`shopin_shopins`.`order_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$packing_session]["keyword"]) . "%' 
				OR		`shopin_shopins`.`help_order_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$packing_session]["keyword"]) . "%' 
				OR		`shopin_shopins`.`help_device_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$packing_session]["keyword"]) . "%' 
				OR		`shopin_shopins`.`description` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$packing_session]["keyword"]) . "%') " : 
				"";

	$and = $where == "" ? "WHERE `shopin_shopins`.`mode`=" . $packing_mode . " " : " AND `shopin_shopins`.`mode`=" . $packing_mode . " ";
	
	switch($_SESSION["admin"]["roles"]["searchresult_rights"]){
	
		case 0:
			$and .= "AND `shopin_shopins`.`admin_id`=" . $_SESSION["admin"]["id"] . " ";
			break;
	
		case 1:
			$and .= "AND (`shopin_shopins`.`admin_id`=" . $_SESSION["admin"]["id"] . " OR `shopin_shopins`.`admin_id`=" . $maindata['admin_id'] . ") ";
			break;

	}

	$query = 	"	SELECT 		`shopin_shopins`.`id` AS id, 
								`shopin_shopins`.`mode` AS mode, 
								`shopin_shopins`.`type` AS type, 
								`shopin_shopins`.`creator_id` AS creator_id, 
								`shopin_shopins`.`shopin_number` AS shopin_number, 
								`shopin_shopins`.`order_number` AS order_number, 
								`shopin_shopins`.`help_order_number` AS help_order_number, 
								`shopin_shopins`.`order_id` AS order_id, 
								`shopin_shopins`.`help_device_number` AS help_device_number, 
								`shopin_shopins`.`description` AS description, 
								`shopin_shopins`.`reg_date` AS reg_date, 
								`shopin_shopins`.`upd_date` AS time, 
	
								(SELECT `order_orders`.`mode` AS o_mode FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`id`=`shopin_shopins`.`order_id`) AS order_mode, 
	
								(SELECT `order_orders_devices`.`device_number` AS d_number FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`id`=`shopin_shopins`.`device_id`) AS device_number, 
								(SELECT `order_orders_devices`.`atot_mode` AS d_mode FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`id`=`shopin_shopins`.`device_id`) AS atot_mode, 
								(SELECT `order_orders_devices`.`at` AS d_at FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`id`=`shopin_shopins`.`device_id`) AS at, 
								(SELECT `order_orders_devices`.`ot` AS d_ot FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`id`=`shopin_shopins`.`device_id`) AS ot, 
								(SELECT (SELECT `storage_places`.`name` AS s_p_name FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`=`order_orders_devices`.`storage_space_id`) AS d_s_s FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`id`=`shopin_shopins`.`device_id`) AS device_storage_space, 
	
								(SELECT `storage_places`.`name` AS s_p_name FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`=`shopin_shopins`.`storage_space_id`) AS storage_space, 
	
								(SELECT `admin`.`name` AS name FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`=`shopin_shopins`.`admin_id`) AS admin_name, 
	
								`shopin_shopins`.`admin_id` AS admin_id 
								
					FROM 		`shopin_shopins` 
					" . $where . $and . " 
					AND 		`shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
					ORDER BY 	CAST(`shopin_shopins`.`upd_date` AS UNSIGNED) " . $sorting_direction_name;

	$result = mysqli_query($conn, $query);
	
	$rows_shopin = $result->num_rows;
	
	$pageNumberlist_shopin->setParam(	array(	"page" 		=> "Seite", 
												"of" 		=> "von", 
												"start" 	=> "|&lt;&lt;", 
												"next" 		=> "Weiter", 
												"back" 		=> "Zur&uuml;ck", 
												"end" 		=> "&gt;&gt;|", 
												"seperator" => "| "), 
												$rows_shopin, 
												$pos_shopin, 
												$amount_rows, 
												"/pos_intern/" . $pos_intern . "/pos_packing/" . $pos_packing . "/pos_shopin", 
												$packing_action, 
												$getParam="", 
												10, 
												1);
	
	$query .= " limit " . $pos_shopin . ", " . $amount_rows;

	$result = mysqli_query($conn, $query);

	while($row_shopins = $result->fetch_array(MYSQLI_ASSOC)){

		$arr_order_url = array('neue-auftraege', 'auftrag-archiv', 'neue-interessenten', 'interessenten-archiv');

		$list .= 	"<form action=\"" . $packing_action . "\" method=\"post\">\n" . 
					"	<tr" . (isset($_POST['id']) && $_POST['id'] == $row_shopins['id'] ? " class=\"bg-primary text-white shoppings_menu\"" : " class=\"shoppings_menu\"") . ">\n" . 
					"		<td class=\"text-nowrap\">\n" . 
					"			<small>" . date("d.m.Y", $row_shopins['reg_date']) . "</small> <small class=\"text-muted\">" . date("(H:i)", $row_shopins['reg_date']) . "</small>\n" . 
					"		</td>\n" . 
					"		<td scope=\"row\" align=\"center\">\n" . 
					"			<small>" . $row_shopins['shopin_number'] . "</small>\n" . 
					"		</td>\n" . 
					"		<td scope=\"row\" align=\"center\">\n" . 
					"			" . ($row_shopins['type'] == 0 || $row_shopins['type'] == 4 || $row_shopins['type'] == 7 || $row_shopins['type'] == 8 ? "<a href=\"/crm/" . $arr_order_url[$row_shopins['order_mode']] . "/bearbeiten/" . $row_shopins['order_id'] . "\" class=\"text-success\">" . $row_shopins['order_number'] . " <i class=\"fa fa-external-link\"></i></a>" : "<span class=\"text-warning\">" . $row_shopins['order_number'] . "</span>") . "\n" . 
					"		</td>\n" . 
					"		<td scope=\"row\" align=\"center\">\n" . 
					"			<small>" . 
					($row_shopins['type'] == 0 || $row_shopins['type'] == 4 || $row_shopins['type'] == 5 || $row_shopins['type'] == 6 || $row_shopins['type'] == 7 || $row_shopins['type'] == 8 ? 
						"<span class=\"text-success\">" . $row_shopins['device_number'] . ($row_shopins['atot_mode'] == 1 ? "-AT-" . $row_shopins['at'] : ($row_shopins['atot_mode'] == 2 ? "-ORG-" . $row_shopins['ot'] : "")) . "</span>" 
					: 
						"<span class=\"text-warning\">" . $row_shopins['help_device_number'] . "</span>"
					) . "</small>\n" . 
					"		</td>\n" . 
					"		<td scope=\"row\" align=\"center\">\n" . 
					"			<small>" . 
					($row_shopins['type'] == 0 || $row_shopins['type'] == 4 || $row_shopins['type'] == 5 || $row_shopins['type'] == 6 || $row_shopins['type'] == 7 || $row_shopins['type'] == 8 ? 
						"<span class=\"text-success\">" . ($row_shopins['atot_mode'] == 1 ? "AT " . $row_shopins['at'] : ($row_shopins['atot_mode'] == 2 ? "ORG " . $row_shopins['ot'] : "")) . "</span>" 
					: 
						"<span class=\"text-warning\">&nbsp;</span>"
					) . "</small>\n" . 
					"		</td>\n" . 
					"		<td scope=\"row\" align=\"center\">\n" . 
					($row_shopins['mode'] == 0 ? 
						($row_shopins['type'] == 0 ? "			<small>" . $row_shopins['storage_space'] . "</small>" : "") . 
						($row_shopins['type'] == 1 ? "			<small>" . $row_shopins['storage_space'] . "</small>" : "") . 
						($row_shopins['type'] == 2 ? "			<small>" . $row_shopins['storage_space'] . "</small>" : "") . 
						($row_shopins['type'] == 3 ? "			<small>" . $row_shopins['storage_space'] . "</small>" : "") . 
						($row_shopins['type'] == 4 ? "			<small>" . $row_shopins['storage_space'] . "</small>" : "") . 
						($row_shopins['type'] == 5 ? "			<small>" . $row_shopins['storage_space'] . "</small>" : "") . 
						($row_shopins['type'] == 6 ? "			<small>" . $row_shopins['storage_space'] . "</small>" : "") . 
						($row_shopins['type'] == 7 ? "			<small>" . $row_shopins['storage_space'] . "</small>" : "") . 
						($row_shopins['type'] == 8 ? "			<small>" . $row_shopins['storage_space'] . "</small>" : "") . 
						"\n"
					:
						($row_shopins['type'] == 0 ? "			<small>" . $row_shopins['device_storage_space'] . "</small>" : "") . 
						($row_shopins['type'] == 1 ? "			<small>" . $row_shopins['device_storage_space'] . "</small>" : "") . 
						($row_shopins['type'] == 2 ? "			<small>" . $row_shopins['device_storage_space'] . "</small>" : "") . 
						($row_shopins['type'] == 3 ? "			<small>" . $row_shopins['device_storage_space'] . "</small>" : "") . 
						($row_shopins['type'] == 4 ? "			<small>" . $row_shopins['device_storage_space'] . "</small>" : "") . 
						($row_shopins['type'] == 5 ? "			<small>" . $row_shopins['device_storage_space'] . "</small>" : "") . 
						($row_shopins['type'] == 6 ? "			<small>" . $row_shopins['device_storage_space'] . "</small>" : "") . 
						($row_shopins['type'] == 7 ? "			<small>" . $row_shopins['device_storage_space'] . "</small>" : "") . 
						($row_shopins['type'] == 8 ? "			<small>" . $row_shopins['device_storage_space'] . "</small>" : "") . 
						"\n"
					) . 
//					"			<small>" . $row_shopins['storage_space'] . "</small>\n" . 
					"		</td>\n" . 
					"		<td>\n" . 
					"			<div style=\"width: 240px;white-space: nowrap;overflow-x: hidden\"><small>" . $row_shopins['description'] . "</small></div>\n" . 
					"		</td>\n" . 
					"		<td class=\"text-nowrap\">\n" . 
					"			<small>" . date("d.m.Y", $row_shopins['time']) . "</small> <small class=\"text-muted\">" . date("(H:i)", $row_shopins['time']) . "</small>\n" . 
					"		</td>\n" . 
					/*"		<td" . ($row_shopins['creator_id'] == $maindata['admin_id'] ? " class=\"text-danger\"" : "") . ">\n" . 
					"			<div style=\"width: 120px;white-space: nowrap;overflow-x: hidden\"><small>" . $row_shopins['admin_name'] . "</small></div>\n" . 
					"		</td>\n" . */
					"		<td align=\"center\" width=\"130\">\n" . 
					"			<div style=\"white-space: nowrap\">\n" . 
					"				<input type=\"hidden\" name=\"id\" value=\"" . $row_shopins['id'] . "\" />\n" . 
					($row_shopins['mode'] == 0 ? 
						($row_shopins['type'] == 0 ? "				<button type=\"submit\" name=\"shopin_add_device\" value=\"hinzufügen\" class=\"btn btn-sm btn-success w-100\">einlagern <i class=\"fa fa-tasks\" aria-hidden=\"true\"></i></button>" : "") . 
						($row_shopins['type'] == 1 ? "				<button type=\"submit\" name=\"shopin_order\" value=\"none\" class=\"btn btn-sm btn-warning w-100\">einlagern <i class=\"fa fa-tasks\" aria-hidden=\"true\"></i></button>" : "") . 
						($row_shopins['type'] == 2 ? "				<button type=\"submit\" name=\"shopin_none\" value=\"complete\" class=\"btn btn-sm btn-warning w-100\">abschliessen <i class=\"fa fa-check\" aria-hidden=\"true\"></i></button>" : "") . 
						($row_shopins['type'] == 3 ? "				<button type=\"submit\" name=\"shopin_edit\" value=\"bearbeiten\" class=\"btn btn-sm btn-warning w-100\">zuweisen <i class=\"fa fa-exchange\" aria-hidden=\"true\"></i></button>" : "") . 
						($row_shopins['type'] == 4 ? "				<button type=\"submit\" name=\"shopin_add_device\" value=\"complete\" class=\"btn btn-sm btn-success w-100\">abschliessen <i class=\"fa fa-check\" aria-hidden=\"true\"></i></button>" : "") . 
						($row_shopins['type'] == 5 ? "				<button type=\"submit\" name=\"shopin_relocate\" value=\"hinzufügen\" class=\"btn btn-sm btn-warning w-100\">umlagern <i class=\"fa fa-angle-double-right\" aria-hidden=\"true\"></i></button>" : "") . 
						($row_shopins['type'] == 6 ? "				<button type=\"submit\" name=\"shopin_relocate\" value=\"complete\" class=\"btn btn-sm btn-success w-100\">abschliessen <i class=\"fa fa-check\" aria-hidden=\"true\"></i></button>" : "") . 
						($row_shopins['type'] == 7 ? "				<button type=\"submit\" name=\"shopin_next_storage\" value=\"hinzufügen\" class=\"btn btn-sm btn-success w-100\">einlagern <i class=\"fa fa-tasks\" aria-hidden=\"true\"></i></button>" : "") . 
						($row_shopins['type'] == 8 ? "				<button type=\"submit\" name=\"shopin_next_storage\" value=\"complete\" class=\"btn btn-sm btn-success w-100\">abschliessen <i class=\"fa fa-check\" aria-hidden=\"true\"></i></button>" : "") . 
						"\n"
					:
						($row_shopins['type'] == 0 ? "				<button type=\"submit\" name=\"shopin_add_device\" value=\"ansehen\" class=\"btn btn-sm btn-success w-100\">ansehen <i class=\"fa fa-eye\" aria-hidden=\"true\"></i></button>" : "") . 
						($row_shopins['type'] == 1 ? "				<button type=\"submit\" name=\"shopin_none\" value=\"ansehen\" class=\"btn btn-sm btn-success w-100\">ansehen <i class=\"fa fa-eye\" aria-hidden=\"true\"></i></button>" : "") . 
						($row_shopins['type'] == 2 ? "				<button type=\"submit\" name=\"shopin_none\" value=\"ansehen\" class=\"btn btn-sm btn-success w-100\">ansehen <i class=\"fa fa-eye\" aria-hidden=\"true\"></i></button>" : "") . 
						($row_shopins['type'] == 3 ? "				<button type=\"submit\" name=\"shopin_none\" value=\"ansehen\" class=\"btn btn-sm btn-success w-100\">ansehen <i class=\"fa fa-eye\" aria-hidden=\"true\"></i></button>" : "") . 
						($row_shopins['type'] == 4 ? "				<button type=\"submit\" name=\"shopin_add_device\" value=\"ansehen\" class=\"btn btn-sm btn-success w-100\">ansehen <i class=\"fa fa-eye\" aria-hidden=\"true\"></i></button>" : "") . 
						($row_shopins['type'] == 5 ? "				<button type=\"submit\" name=\"shopin_relocate\" value=\"ansehen\" class=\"btn btn-sm btn-success w-100\">ansehen <i class=\"fa fa-eye\" aria-hidden=\"true\"></i></button>" : "") . 
						($row_shopins['type'] == 6 ? "				<button type=\"submit\" name=\"shopin_relocate\" value=\"ansehen\" class=\"btn btn-sm btn-success w-100\">ansehen <i class=\"fa fa-eye\" aria-hidden=\"true\"></i></button>" : "") . 
						($row_shopins['type'] == 7 ? "				<button type=\"submit\" name=\"shopin_next_storage\" value=\"ansehen\" class=\"btn btn-sm btn-success w-100\">ansehen <i class=\"fa fa-eye\" aria-hidden=\"true\"></i></button>" : "") . 
						($row_shopins['type'] == 8 ? "				<button type=\"submit\" name=\"shopin_next_storage\" value=\"ansehen\" class=\"btn btn-sm btn-success w-100\">ansehen <i class=\"fa fa-eye\" aria-hidden=\"true\"></i></button>" : "") . 
						"\n"
					) . 
					"			</div>\n" . 
					"		</td>\n" . 
					"		<td align=\"center\" width=\"130\">\n" . 
					"			<div style=\"white-space: nowrap\">\n" . 
					($row_shopins['mode'] == 0 ? 
						($row_shopins['type'] == 0 || $row_shopins['type'] == 4 ? "				<button type=\"submit\" name=\"shopin_add_undo\" value=\"rueckgaengig\" class=\"btn btn-sm btn-danger w-100\" onclick=\"return confirm('Wollen Sie den Eintrag wircklich rückgängig machen?')\">rückgängig <i class=\"fa fa-undo\" aria-hidden=\"true\"></i></button>" : "") . "\n" . 
						($row_shopins['type'] == 1 || $row_shopins['type'] == 2 || $row_shopins['type'] == 3 ? "				<button type=\"submit\" name=\"shopin_none_undo\" value=\"rueckgaengig\" class=\"btn btn-sm btn-danger w-100\" onclick=\"return confirm('Wollen Sie den Eintrag wircklich rückgängig machen?')\">rückgängig <i class=\"fa fa-undo\" aria-hidden=\"true\"></i></button>" : "") . "\n" . 
						($row_shopins['type'] == 5 || $row_shopins['type'] == 6 ? "				<button type=\"submit\" name=\"shopin_relocate_undo\" value=\"rueckgaengig\" class=\"btn btn-sm btn-danger w-100\" onclick=\"return confirm('Wollen Sie den Eintrag wircklich rückgängig machen?')\">rückgängig <i class=\"fa fa-undo\" aria-hidden=\"true\"></i></button>" : "") . "\n" . 
						($row_shopins['type'] == 7 || $row_shopins['type'] == 8 ? "				<button type=\"submit\" name=\"shopin_next_storage_undo\" value=\"rueckgaengig\" class=\"btn btn-sm btn-danger w-100\" onclick=\"return confirm('Wollen Sie den Eintrag wircklich rückgängig machen?')\">rückgängig <i class=\"fa fa-undo\" aria-hidden=\"true\"></i></button>" : "") . "\n"
					: 
						($row_shopins['type'] == 0 || $row_shopins['type'] == 4 ? "				<button type=\"submit\" name=\"shopin_delete\" value=\"entfernen\" class=\"btn btn-sm btn-danger w-100\" onclick=\"return confirm('Wollen Sie den Eintrag wircklich entfernen?')\">entfernen <i class=\"fa fa-ban\" aria-hidden=\"true\"></i></button>" : "				<button type=\"submit\" name=\"shopin_delete\" value=\"entfernen\" class=\"btn btn-sm btn-danger w-100\" onclick=\"return confirm('Wollen Sie den Eintrag wircklich entfernen?')\">entfernen <i class=\"fa fa-ban\" aria-hidden=\"true\"></i></button>") . "\n"
					) . 
					"			</div>\n" . 
					"		</td>\n" . 
					"	</tr>\n" . 
					"</form>\n";

	}

	$html .= 	$pageNumberlist_shopin->getInfo() . 

				//"<br />\n" . 

				//$pageNumberlist_shopin->getNavi() . 

				"<div class=\"table-responsive bg-white border border-light mb-1\" style=\"max-height: 460px\">\n" . 
				"	<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
				"		<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<strong>Erstellt</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<strong>Nummer</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<strong>Auftrag</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<strong>Gerät</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<strong>Bauteilspez.</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<strong>Lagerplatz</strong>\n" . 
				"			</th>\n" . 
				"			<th scope=\"col\">\n" . 
				"				<strong>Beschreibung</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<strong>Geändert</strong>\n" . 
				"			</th>\n" . 
				/*"			<th width=\"140\" scope=\"col\">\n" . 
				"				<strong>Mitarbeiter</strong>\n" . 
				"			</th>\n" . */
				"			<th colspan=\"2\" width=\"220\" align=\"center\" scope=\"col\" class=\"text-center\">\n" . 
				"				<strong>Aktion</strong>\n" . 
				"			</th>\n" . 
				"		</tr></thead>\n" . 

				$list . 

				"	</table>\n" . 
				"</div>\n" . 

				$pageNumberlist_shopin->getNavi();

?>