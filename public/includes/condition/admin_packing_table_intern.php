<?php 

	$pageNumberlist_intern = new pageList();

	$list = "";
	
	$where = 	isset($_SESSION[$packing_session]["keyword"]) && $_SESSION[$packing_session]["keyword"] != "" ? 
				"WHERE 	(`intern_interns`.`id` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$packing_session]["keyword"]) . "%' 
				OR		`order_orders_devices`.`device_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$packing_session]["keyword"]) . "%' 
				OR		`order_orders`.`order_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$packing_session]["keyword"]) . "%' 
				OR		`intern_interns`.`intern_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$packing_session]["keyword"]) . "%' 
				OR		`intern_interns`.`help_device_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$packing_session]["keyword"]) . "%' 
				OR		`intern_interns`.`message` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$packing_session]["keyword"]) . "%') " : 
				"";

	$and = $where == "" ? "WHERE `intern_interns`.`mode`=" . $packing_mode . " " : " AND `intern_interns`.`mode`=" . $packing_mode . " ";
	
	switch($_SESSION["admin"]["roles"]["searchresult_rights"]){
	
		case 0:
			$and .= "AND `intern_interns`.`admin_id`=" . $_SESSION["admin"]["id"] . " ";
			break;
	
		case 1:
			$and .= "AND (`intern_interns`.`admin_id`=" . $_SESSION["admin"]["id"] . " OR `intern_interns`.`admin_id`=" . $maindata['admin_id'] . ") ";
			break;
		
	}
	
	$query = 	"	SELECT 		`intern_interns`.`id` AS id, 
								`intern_interns`.`mode` AS mode, 
								`intern_interns`.`type` AS type, 
								`intern_interns`.`creator_id` AS creator_id, 
								`intern_interns`.`intern_number` AS intern_number, 
								`intern_interns`.`order_id` AS order_id, 
								`intern_interns`.`message` AS message, 
								`intern_interns`.`reg_date` AS reg_date, 
								`intern_interns`.`upd_date` AS time, 
	
								(SELECT `order_orders`.`mode` AS o_mode FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`id`=`intern_interns`.`order_id`) AS order_mode, 
	
								(SELECT `order_orders`.`order_number` AS o_order_number FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`id`=`intern_interns`.`order_id`) AS order_number, 
	
								(SELECT `order_orders_devices`.`device_number` AS o_o_device_number FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`id`=`intern_interns`.`device_id`) AS device_number, 
								(SELECT `order_orders_devices`.`atot_mode` AS d_mode FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`id`=`intern_interns`.`device_id`) AS atot_mode, 
								(SELECT `order_orders_devices`.`at` AS d_at FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`id`=`intern_interns`.`device_id`) AS at, 
								(SELECT `order_orders_devices`.`ot` AS d_ot FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`id`=`intern_interns`.`device_id`) AS ot, 
	
								(SELECT `storage_places`.`name` AS s_s_name FROM `storage_places` WHERE `storage_places`.`id`=`order_orders_devices`.`storage_space_id`) AS storage_space, 

								(SELECT `admin`.`name` AS name FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`=`intern_interns`.`admin_id`) AS admin_name, 
	
								`intern_interns`.`admin_id` AS admin_id 
								
					FROM 		`intern_interns` 
					LEFT JOIN	`order_orders_devices` 
					ON			`intern_interns`.`device_id`=`order_orders_devices`.`id` 
					LEFT JOIN	`order_orders` 
					ON			`intern_interns`.`order_id`=`order_orders`.`id` 
					" . $where . $and . " 
					AND 		`intern_interns`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
					ORDER BY 	CAST(`intern_interns`.`upd_date` AS UNSIGNED) " . $sorting_direction_name;
	
	$result = mysqli_query($conn, $query);
	
	$rows_intern = $result->num_rows;
	
	$pageNumberlist_intern->setParam(	array(	"page" 		=> "Seite", 
												"of" 		=> "von", 
												"start" 	=> "|&lt;&lt;", 
												"next" 		=> "Weiter", 
												"back" 		=> "Zur&uuml;ck", 
												"end" 		=> "&gt;&gt;|", 
												"seperator" => "| "), 
												$rows_intern, 
												$pos_intern, 
												$amount_rows, 
												"/pos_shopin/" . $pos_shopin . "/pos_packing/" . $pos_packing . "/pos_intern", 
												$packing_action, 
												$getParam="", 
												10, 
												1);
	
	$query .= " limit " . $pos_intern . ", " . $amount_rows;

	$result = mysqli_query($conn, $query);

	while($row_interns = $result->fetch_array(MYSQLI_ASSOC)){

		$arr_order_url = array('neue-auftraege', 'auftrag-archiv', 'neue-interessenten', 'interessenten-archiv');

		$list .= 	"<form action=\"" . $packing_action . "\" method=\"post\">\n" . 
					"	<tr" . (isset($_POST['id']) && $_POST['id'] == $row_interns['id'] ? " class=\"bg-primary text-white packings_menu\"" : " class=\"packings_menu\"") . ">\n" . 
					"		<td class=\"text-nowrap\">\n" . 
					"			<small>" . date("d.m.Y", $row_interns['reg_date']) . "</small> <small class=\"text-muted\">" . date("(H:i)", $row_interns['reg_date']) . "</small>\n" . 
					"		</td>\n" . 
					"		<td scope=\"row\" align=\"center\">\n" . 
					"			<small>" . $row_interns['intern_number'] . "</small>\n" . 
					"		</td>\n" . 
					"		<td scope=\"row\" align=\"center\">\n" . 
					"			<a href=\"/crm/" . $arr_order_url[$row_interns['order_mode']] . "/bearbeiten/" . $row_interns['order_id'] . "\">" . $row_interns['order_number'] . " <i class=\"fa fa-external-link\"></i></a>\n" . 
					"		</td>\n" . 
					"		<td scope=\"row\" align=\"center\">\n" . 
					"			<small>" . $row_interns['device_number'] . ($row_interns['atot_mode'] == 1 ? "-AT-" . $row_interns['at'] : ($row_interns['atot_mode'] == 2 ? "-ORG-" . $row_interns['ot'] : "")) . "</small>\n" . 
					"		</td>\n" . 
					"		<td scope=\"row\" align=\"center\">\n" . 
					"			<small>" . ($row_interns['atot_mode'] == 1 ? "AT " . $row_interns['at'] : ($row_interns['atot_mode'] == 2 ? "ORG " . $row_interns['ot'] : "")) . "</small>\n" . 
					"		</td>\n" . 
					"		<td scope=\"row\" align=\"center\">\n" . 
					"			<small>" . $row_interns['storage_space'] . "</small>\n" . 
					"		</td>\n" . 
					"		<td>\n" . 
					"			<div style=\"width: 240px;white-space: nowrap;overflow-x: hidden\"><small>" . str_replace("\r\n", " ", $row_interns['message']) . "</small></div>\n" . 
					"		</td>\n" . 
					"		<td class=\"text-nowrap\">\n" . 
					"			<small>" . date("d.m.Y", $row_interns['time']) . "</small> <small class=\"text-muted\">" . date("(H:i)", $row_interns['time']) . "</small>\n" . 
					"		</td>\n" . 
					/*"		<td" . ($row_interns['creator_id'] == $maindata['admin_id'] ? " class=\"text-danger\"" : "") . ">\n" . 
					"			<div style=\"width: 120px;white-space: nowrap;overflow-x: hidden\"><small>" . $row_interns['admin_name'] . "</small></div>\n" . 
					"		</td>\n" . */
					"		<td align=\"center\" width=\"130\">\n" . 
					"			<div style=\"white-space: nowrap\">\n" . 
					($row_interns['mode'] == 0 ? 
						($row_interns['type'] == 1 ? "				<button type=\"submit\" name=\"intern\" value=\"photo\" class=\"btn btn-sm btn-warning w-100\">fotografieren <i class=\"fa fa-camera\" aria-hidden=\"true\"></i></button>\n" : "") . 
						($row_interns['type'] == 2 ? "				<button type=\"submit\" name=\"intern\" value=\"relocate\" class=\"btn btn-sm btn-warning w-100\">umlagern <i class=\"fa fa-angle-double-right\" aria-hidden=\"true\"></i></button>\n" : "") . 
						($row_interns['type'] == 3 ? "				<button type=\"submit\" name=\"intern\" value=\"labeling\" class=\"btn btn-sm btn-warning w-100\">beschriften <i class=\"fa fa-tag\" aria-hidden=\"true\"></i></button>\n" : "")
					: 
						"				<button type=\"submit\" name=\"intern_view\" value=\"ansehen\" class=\"btn btn-sm btn-success w-100\">ansehen <i class=\"fa fa-eye\" aria-hidden=\"true\"></i></button>\n"
					) . 
					"			</div>\n" . 
					"		</td>\n" . 
					"		<td align=\"center\" width=\"130\">\n" . 
					"			<div style=\"white-space: nowrap\">\n" . 
					"				<input type=\"hidden\" name=\"id\" value=\"" . $row_interns['id'] . "\" />\n" . 
					"				<input type=\"hidden\" name=\"order_id\" value=\"" . $row_interns['order_id'] . "\" />\n" . 
					($row_interns['mode'] == 0 ? 
						($row_interns['type'] == 1 ? "				<button type=\"submit\" name=\"intern_photo_edit\" value=\"bearbeiten\" class=\"btn btn-sm btn-success w-100\">bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>\n" : "") . 
						($row_interns['type'] == 2 ? "				<button type=\"submit\" name=\"intern_relocate_edit\" value=\"bearbeiten\" class=\"btn btn-sm btn-success w-100\">bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>\n" : "") . 
						($row_interns['type'] == 3 ? "				<button type=\"submit\" name=\"intern_labeling_edit\" value=\"bearbeiten\" class=\"btn btn-sm btn-success w-100\">bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>\n" : "")
					: 
						"				<button type=\"submit\" name=\"intern_delete\" value=\"entfernen\" class=\"btn btn-sm btn-danger w-100\" onclick=\"return confirm('Wollen Sie diesen Eintrag wirklich entfernen?')\">entfernen <i class=\"fa fa-ban\" aria-hidden=\"true\"></i></button>\n"
					) . 
					"			</div>\n" . 
					"		</td>\n" . 
					"	</tr>\n" . 
					"</form>\n";

	}

	$html .= 	"<hr />\n" . 

				"<h3>Intern</h3>\n" . 

				$pageNumberlist_intern->getInfo() . 

				//"<br />\n" . 

				//$pageNumberlist_intern->getNavi() . 

				"<div class=\"table-responsive bg-white border border-light mb-1\" style=\"max-height: 460px\">\n" . 
				"	<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
				"		<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<strong>Erstellt</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<strong>Aufgabe</strong>\n" . 
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

				$pageNumberlist_intern->getNavi();

?>