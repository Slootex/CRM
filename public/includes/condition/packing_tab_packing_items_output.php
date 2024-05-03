<?php 

	$arr_devices = array();

	$html_devices_old = "";

	$result = mysqli_query($conn, "	SELECT 		`packing_packings_devices`.`id` AS id, 
												`packing_packings_devices`.`device_id` AS device_id, 
												`packing_packings_devices`.`device_number` AS device_number, 
												`order_orders_devices`.`atot_mode` AS atot_mode, 
												`order_orders_devices`.`at` AS at, 
												`order_orders_devices`.`ot` AS ot 
									FROM 		`packing_packings_devices` `packing_packings_devices` 
									LEFT JOIN	`order_orders_devices` 
									ON			`order_orders_devices`.`id`=`packing_packings_devices`.`device_id` 
									WHERE 		`packing_packings_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									AND 		`packing_packings_devices`.`packing_id`='" . mysqli_real_escape_string($conn, intval($row_packing['id'])) . "' 
									AND 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`packing_packings_devices`.`device_number` AS UNSIGNED) DESC");

	while($row_device = $result->fetch_array(MYSQLI_ASSOC)){
			$html_devices_old .= 	"<div class=\"row mb-4\">\n" . 
									"	<div class=\"col-sm-9\">\n" . 
									"		" . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . "\n" . 
									"	</div>\n" . 
									"	<div class=\"col-sm-2\">\n" . 
		
									"	</div>\n" . 
									"	<div class=\"col-sm-1\">\n" . 
									"		<form action=\"" . $packing_action . "\" method=\"post\">\n" . 
									"			<input type=\"hidden\" name=\"id\" value=\"" . $row_packing['id'] . "\" />\n" . 
									"			<input type=\"hidden\" name=\"device_id\" value=\"" . $row_device['id'] . "\" />\n" . 
									"			<button type=\"submit\" name=\"device_delete\" value=\"X\" class=\"btn btn-sm btn-danger\" onclick=\"return confirm('Sind Sie sicher, das Sie den Versandartikel entfernen wollen?')\"><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></button>\n" . 
									"		</form>\n" . 
									"	</div>\n" . 
									"</div>\n";
		$arr_devices[$row_device['device_id']] = 1;
	}

	$html_devices_new = "";

	$result = mysqli_query($conn, "	SELECT 		`order_orders_devices`.`id` AS id, 
												`order_orders_devices`.`device_number` AS device_number,  
												`order_orders_devices`.`atot_mode` AS atot_mode,  
												`order_orders_devices`.`at` AS at,  
												`order_orders_devices`.`ot` AS ot  
									FROM 		`order_orders_devices` `order_orders_devices` 
									WHERE 		`order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_packing['order_id'])) . "' 
									AND 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`order_orders_devices`.`reg_date` AS UNSIGNED) DESC");

	while($row_device = $result->fetch_array(MYSQLI_ASSOC)){
		if(!isset($arr_devices[$row_device['id']])){
			$html_devices_new .=	"<div class=\"custom-control custom-checkbox mt-2\">\n" . 
									"	<input type=\"checkbox\" id=\"device_" . $row_device['id'] . "\" name=\"device_" . $row_device['id'] . "\" value=\"1\" class=\"custom-control-input\">\n" . 
									"	<label class=\"custom-control-label\" for=\"device_" . $row_device['id'] . "\">\n" . 
									"		" . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . "\n" . 
									"	</label>\n" . 
									"</div>\n";
		}
	}

	$tabs_contents .= 	($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 
						"				<div class=\"row\">\n" . 
						"					<div class=\"col-sm-2 border-right\">\n" . 

						"						<form action=\"" . $packing_action . "\" method=\"post\">\n" . 
						"							<div class=\"form-group row\">\n" . 
						"								<label class=\"col-sm-12 col-form-label\">Versandartikel hinzufügen</label>\n" . 
						"								<div class=\"col-sm-12 px-3 pt-0 pb-3\">\n" . 

						($html_devices_new != "" ? $html_devices_new : "<i class=\"text-danger\">Keine weiteren vorhanden!</i>\n") . 

						"								</div>\n" . 
						"								<div class=\"col-sm-12\">\n" . 
						"									<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
						($html_devices_new != "" ? "									<button type=\"submit\" name=\"add_devices\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-sign-in\"></i></button>\n" : "") . 
						"								</div>\n" . 
						"							</div>\n" . 
						"						</form>\n" . 

						"					</div>\n" . 
						"					<div class=\"col-sm-5 border-right\">\n" . 
						"						<strong>Versandartikel:</strong>\n" . 

						$html_devices_old . 

						"					</div>\n" . 
						"					<div class=\"col-sm-5\">\n" . 

						"					</div>\n" . 
						"				</div>\n" . 

						"				<form action=\"" . $packing_action . "\" method=\"post\">\n" . 
						"					<div class=\"row px-0 card-footer\">\n" . 
						"						<div class=\"col-sm-12 text-right\">\n" . 
						"							<input type=\"hidden\" name=\"id\" value=\"" . $row_packing['id'] . "\" />\n" . 
						"							<button type=\"submit\" name=\"packing_delete\" value=\"entfernen\" class=\"btn btn-danger\" onclick=\"return confirm('Wollen Sie diesen Eintrag wirklich entfernen?')\">entfernen <i class=\"fa fa-ban\" aria-hidden=\"true\"></i></button>\n" . 
						"						</div>\n" . 
						"					</div>\n" . 
						"				</form>\n";

?>