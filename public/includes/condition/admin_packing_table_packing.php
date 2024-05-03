<?php 

	$pageNumberlist_packing = new pageList();

	$list = "";
	
	$where = 	isset($_SESSION[$packing_session]["keyword"]) && $_SESSION[$packing_session]["keyword"] != "" ? 
				"WHERE 	(`packing_packings`.`id` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$packing_session]["keyword"]) . "%' 
				OR		`order_orders`.`order_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$packing_session]["keyword"]) . "%' 
				OR		(SELECT `address_addresses`.`shortcut` AS a_name FROM `address_addresses` WHERE `address_addresses`.`id`=`packing_packings`.`address_id`) LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$packing_session]["keyword"]) . "%' 
				OR		`packing_packings`.`packing_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$packing_session]["keyword"]) . "%' 
				OR		`packing_packings`.`companyname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$packing_session]["keyword"]) . "%' 
				OR		`packing_packings`.`firstname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$packing_session]["keyword"]) . "%' 
				OR		`packing_packings`.`lastname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$packing_session]["keyword"]) . "%' 
				OR		`packing_packings`.`street` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$packing_session]["keyword"]) . "%' 
				OR		`packing_packings`.`streetno` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$packing_session]["keyword"]) . "%' 
				OR		`packing_packings`.`zipcode` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$packing_session]["keyword"]) . "%' 
				OR		`packing_packings`.`city` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$packing_session]["keyword"]) . "%' 
				OR		`packing_packings`.`phonenumber` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$packing_session]["keyword"]) . "%' 
				OR		`packing_packings`.`mobilnumber` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$packing_session]["keyword"]) . "%' 
				OR		`packing_packings`.`email` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$packing_session]["keyword"]) . "%' 
				OR		`packing_packings`.`message` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$packing_session]["keyword"]) . "%') " : 
				"";

	$and = $where == "" ? "WHERE `packing_packings`.`mode`=" . $packing_mode . " " : " AND `packing_packings`.`mode`=" . $packing_mode . " ";

	switch($_SESSION["admin"]["roles"]["searchresult_rights"]){

		case 0:
			$and .= "AND `packing_packings`.`admin_id`=" . $_SESSION["admin"]["id"] . " ";
			break;

		case 1:
			$and .= "AND (`packing_packings`.`admin_id`=" . $_SESSION["admin"]["id"] . " OR `packing_packings`.`admin_id`=" . $maindata['admin_id'] . ") ";
			break;

	}

	$query = 	"	SELECT 		`packing_packings`.`id` AS id, 
								`packing_packings`.`mode` AS mode, 
								`packing_packings`.`type` AS type, 
								`packing_packings`.`is_send` AS is_send, 
								`packing_packings`.`creator_id` AS creator_id, 
								`packing_packings`.`packing_number` AS packing_number, 
								`packing_packings`.`order_number` AS order_number, 
								`packing_packings`.`order_id` AS order_id, 
								`packing_packings`.`message` AS message, 
								(SELECT `address_addresses`.`shortcut` AS a_name FROM `address_addresses` WHERE `address_addresses`.`id`=`packing_packings`.`address_id`) AS shortcut_name, 
								`packing_packings`.`companyname` AS companyname, 
								`packing_packings`.`firstname` AS firstname, 
								`packing_packings`.`lastname` AS lastname, 
								`packing_packings`.`street` AS street, 
								`packing_packings`.`streetno` AS streetno, 
								`packing_packings`.`zipcode` AS zipcode, 
								`packing_packings`.`city` AS city, 
								(SELECT `countries`.`name` AS c_name FROM `countries` WHERE `countries`.`id`=`packing_packings`.`country`) AS country_name, 
								`packing_packings`.`email` AS email, 
								`packing_packings`.`mobilnumber` AS mobilnumber, 
								`packing_packings`.`phonenumber` AS phonenumber, 
								`packing_packings`.`adding` AS adding, 
								`packing_packings`.`reg_date` AS reg_date, 
								`packing_packings`.`upd_date` AS time, 
	
								(SELECT `order_orders`.`mode` AS o_mode FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`id`=`packing_packings`.`order_id`) AS order_mode, 
	
								(SELECT `order_orders`.`order_number` AS o_order_number FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`id`=`packing_packings`.`order_id`) AS order_order_number, 
	
								(SELECT `admin`.`name` AS name FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`=`packing_packings`.`admin_id`) AS admin_name, 
	
								`packing_packings`.`admin_id` AS admin_id 
								
					FROM 		`packing_packings` 
					LEFT JOIN	`order_orders` 
					ON			`packing_packings`.`order_id`=`order_orders`.`id` 
					" . $where . $and . " 
					AND 		`packing_packings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
					ORDER BY 	CAST(`packing_packings`.`type` AS UNSIGNED) DESC, CAST(`packing_packings`.`upd_date` AS UNSIGNED) " . $sorting_direction_name;

	$result = mysqli_query($conn, $query);
	
	$rows_packing = $result->num_rows;
	
	$pageNumberlist_packing->setParam(	array(	"page" 		=> "Seite", 
												"of" 		=> "von", 
												"start" 	=> "|&lt;&lt;", 
												"next" 		=> "Weiter", 
												"back" 		=> "Zur&uuml;ck", 
												"end" 		=> "&gt;&gt;|", 
												"seperator" => "| "), 
												$rows_packing, 
												$pos_packing, 
												$amount_rows, 
												"/pos_shopin/" . $pos_shopin . "/pos_intern/" . $pos_intern . "/pos_packing", 
												$packing_action, 
												$getParam="", 
												10, 
												1);
	
	$query .= " limit " . $pos_packing . ", " . $amount_rows;

	$result = mysqli_query($conn, $query);

	while($row_packings = $result->fetch_array(MYSQLI_ASSOC)){

		$is_used = false;

		$r = mysqli_query($conn, "	SELECT 		`packing_packings_devices`.`id` AS id, 
												`packing_packings_devices`.`device_id` AS device_id, 
												`packing_packings_devices`.`device_number` AS device_number,  
												`order_orders_devices`.`atot_mode` AS atot_mode, 
												`order_orders_devices`.`at` AS at, 
												`order_orders_devices`.`ot` AS ot 
									FROM 		`packing_packings_devices` `packing_packings_devices` 
									LEFT JOIN	`order_orders_devices` 
									ON			`order_orders_devices`.`id`=`packing_packings_devices`.`device_id` 
									WHERE 		`packing_packings_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									AND 		`packing_packings_devices`.`packing_id`='" . mysqli_real_escape_string($conn, intval($row_packings['id'])) . "' 
									AND 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`packing_packings_devices`.`device_number` AS UNSIGNED) DESC");
	
		while($row_device = $r->fetch_array(MYSQLI_ASSOC)){

			$row_intern = mysqli_fetch_array(mysqli_query($conn, "	SELECT	* 
																	FROM	`intern_interns` 
																	WHERE	`intern_interns`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																	AND 	`intern_interns`.`mode`='0' 
																	AND 	`intern_interns`.`device_id`='" . mysqli_real_escape_string($conn, intval($row_device['device_id'])) . "'"), MYSQLI_ASSOC);

			if(isset($row_intern['id']) && $row_intern['id'] > 0){

				$is_used = true;

			}

		}

		$arr_order_url = array('neue-auftraege', 'auftrag-archiv', 'neue-interessenten', 'interessenten-archiv');

		if($is_used == false){

			$list .= 	"<form action=\"" . $packing_action . "\" method=\"post\">\n" . 
						"	<tr" . ($is_used == true ? " class=\"bg-light text-danger packings_menu\"" : (isset($_POST['id']) && $_POST['id'] == $row_packings['id'] ? " class=\"bg-primary text-white packings_menu\"" : " class=\"packings_menu\"")) . " onclick=\"if(\$(this).hasClass('active')){\$(this).removeClass('active');}else{\$(this).addClass('active');}$('#order_list_" . $row_packings['id'] . "').prop('checked', !$('#order_list_" . $row_packings['id'] . "').prop('checked'))\" data-id=\"" . $row_packings['id'] . "\" data-order_number=\"" . $row_packings['packing_number'] . "\">\n" . 
						"		<td class=\"text-nowrap\">\n" . 
						"			<small>" . date("d.m.Y", $row_packings['reg_date']) . "</small> <small class=\"text-muted\">" . date("(H:i)", $row_packings['reg_date']) . "</small>\n" . 
						"		</td>\n" . 
						"		<td scope=\"row\" align=\"center\">\n" . 
						"			<small>" . $row_packings['packing_number'] . "</small>\n" . 
						"		</td>\n" . 
						"		<td scope=\"row\" align=\"center\">\n" . 
						($row_packings['order_number'] != "" ? 
							"			<a href=\"/crm/" . $arr_order_url[$row_packings['order_mode']] . "/bearbeiten/" . $row_packings['order_id'] . "\">" . $row_packings['order_number'] . " <i class=\"fa fa-external-link\"></i></a>\n"
						: 
							""
						) . 
						"		</td>\n" . 
						"		<td>\n" . 
						"			<div style=\"width: 300px;white-space: nowrap;overflow-x: hidden\"><small>" . str_replace("\r\n", " ", $row_packings['message']) . "</small></div>\n" . 
						"		</td>\n" . 
						"		<td>\n" . 
						"			<div style=\"width: 100%;white-space: nowrap;overflow-x: hidden\"><small>" . str_replace("\r\n", " ", $row_packings['shortcut_name']) . "</small></div>\n" . 
						"		</td>\n" . 
						"		<td class=\"text-nowrap\">\n" . 
						"			<small>" . date("d.m.Y", $row_packings['time']) . "</small> <small class=\"text-muted\">" . date("(H:i)", $row_packings['time']) . "</small>\n" . 
						"		</td>\n" . 
						"		<td align=\"center\" width=\"110\">\n" . 
						"			<div style=\"white-space: nowrap\">\n" . 
						($row_packings['mode'] == 0 ? 
							($row_packings['type'] == 3 && $row_packings['adding'] == 0 ? "				<button type=\"submit\" name=\"pack_user\" value=\"packing\" class=\"btn btn-sm btn-warning w-100\"" . ($is_used == true ? " disabled=\"disabled\"" : "") . ">einzelnd <i class=\"fa fa-gift\" aria-hidden=\"true\"></i></button>\n" : "") . 
							($row_packings['type'] == 4 && $row_packings['adding'] == 0 ? "				<button type=\"submit\" name=\"pack_technic\" value=\"packing\" class=\"btn btn-sm btn-warning w-100\"" . ($is_used == true ? " disabled=\"disabled\"" : "") . ">einzelnd <i class=\"fa fa-gift\" aria-hidden=\"true\"></i></button>\n" : "") . 
							($row_packings['type'] == 5 && $row_packings['adding'] == 0 ? "				<button type=\"submit\" name=\"pack\" value=\"packing\" class=\"btn btn-sm btn-warning w-100\"" . ($is_used == true ? " disabled=\"disabled\"" : "") . ">einzelnd <i class=\"fa fa-gift\" aria-hidden=\"true\"></i></button>\n" : "") . 
							($row_packings['type'] == 6 && $row_packings['adding'] == 0 ? "				<button type=\"submit\" name=\"pack_blank\" value=\"packing\" class=\"btn btn-sm btn-warning w-100\">einzelnd <i class=\"fa fa-gift\" aria-hidden=\"true\"></i></button>\n" : "") . 

							($row_packings['type'] == 3 && $row_packings['adding'] == 1 ? "				" : "") . 
							($row_packings['type'] == 4 && $row_packings['adding'] == 1 ? "				<button type=\"submit\" name=\"pack_adding_technic_shipping\" value=\"bearbeiten\" class=\"btn btn-sm btn-warning w-100\">zusammen <i class=\"fa fa-gift\" aria-hidden=\"true\"></i></button>\n" : "") . 
							($row_packings['type'] == 5 && $row_packings['adding'] == 1 ? "				<button type=\"submit\" name=\"pack_adding_extern_shipping\" value=\"bearbeiten\" class=\"btn btn-sm btn-warning w-100\">zusammen <i class=\"fa fa-gift\" aria-hidden=\"true\"></i></button>\n" : "") . 
							($row_packings['type'] == 6 && $row_packings['adding'] == 1 ? "				<button type=\"submit\" name=\"pack_adding_extern_shipping_blank\" value=\"bearbeiten\" class=\"btn btn-sm btn-warning w-100\">zusammen <i class=\"fa fa-gift\" aria-hidden=\"true\"></i></button>\n" : "")
						: 
							"				<button type=\"button\" name=\"pack\" value=\"view\" class=\"btn btn-sm btn-success w-100\" onclick=\"alert('Admin: dbb - Ansehen müsste hier für jeden Typ weiter ausgearbeitet werden!')\">ansehen <i class=\"fa fa-eye\" aria-hidden=\"true\"></i></button>\n"
						) . 
						"			</div>\n" . 
						"		</td>\n" . 
						"		<td align=\"center\" width=\"110\">\n" . 
						"			<div style=\"white-space: nowrap\">\n" . 
						"				<input type=\"hidden\" name=\"id\" value=\"" . $row_packings['id'] . "\" />\n" . 
						($row_packings['mode'] == 0 ? 
							($row_packings['type'] == 3 ? "				<button type=\"submit\" name=\"pack\" value=\"user\" class=\"btn btn-sm btn-success w-100\">Kunde <i class=\"fa fa-user\" aria-hidden=\"true\"></i></button>\n" : "") . 
							($row_packings['type'] == 4 ? "				<button type=\"submit\" name=\"pack\" value=\"technic\" class=\"btn btn-sm btn-success w-100\">Techniker <i class=\"fa fa-wrench\" aria-hidden=\"true\"></i></button>\n" : "") . 
							($row_packings['type'] == 5 ? "				<button type=\"submit\" name=\"pack\" value=\"extern\" class=\"btn btn-sm btn-success w-100\">Extern <i class=\"fa fa-step-backward\" aria-hidden=\"true\"></i></button>\n" : "") . 
							($row_packings['type'] == 6 ? "				<button type=\"submit\" name=\"pack\" value=\"extern_blank\" class=\"btn btn-sm btn-success w-100\">Extern <i class=\"fa fa-step-backward\" aria-hidden=\"true\"></i></button>\n" : "")
						: 
							"				<button type=\"submit\" name=\"packing_delete\" value=\"entfernen\" class=\"btn btn-sm btn-danger w-100\" onclick=\"return confirm('Wollen Sie diesen Eintrag wirklich entfernen?')\">entfernen <i class=\"fa fa-ban\" aria-hidden=\"true\"></i></button>\n"
						) . 
						"			</div>\n" . 
						"		</td>\n" . 
						"	</tr>\n" . 
						"</form>\n";

		}

	}

	$html .= 	"<hr />\n" . 

				"<h3>Warenausgang</h3>\n" . 

				$pageNumberlist_packing->getInfo() . 

				//"<br />\n" . 

				//$pageNumberlist_packing->getNavi() . 

				"<div class=\"table-responsive bg-white border border-light mb-1\" style=\"max-height: 460px\">\n" . 
				"	<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
				"		<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<strong>Erstellt</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<strong>Paket</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<strong>Auftrag</strong>\n" . 
				"			</th>\n" . 
				"			<th scope=\"col\">\n" . 
				"				<strong>Beschreibung</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<strong>Shortcut</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<strong>Geändert</strong>\n" . 
				"			</th>\n" . 
				"			<th colspan=\"2\" width=\"260\" align=\"center\" scope=\"col\" class=\"text-center\">\n" . 
				"				<strong>Aktion</strong>\n" . 
				"			</th>\n" . 
				"		</tr></thead>\n" . 

				$list . 

				"	</table>\n" . 
				"</div>\n" . 
				"<form action=\"" . $packing_action . "\" method=\"post\">\n" . 
				"	<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm mb-0\">\n" . 
				"		<tr class=\"text-primary\">\n" . 
				"			<td align=\"right\">\n" . 
				"			</td>\n" . 
				"		</tr>\n" . 
				"	</table>\n" . 
				"</form>\n" . 

				$pageNumberlist_packing->getNavi();

?>