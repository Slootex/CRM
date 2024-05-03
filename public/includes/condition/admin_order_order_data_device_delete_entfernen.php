<?php 

	$time = time();

	$row_device = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['device_id'])) . "'"), MYSQLI_ASSOC);

	mysqli_query($conn, "	UPDATE	`order_orders` 
							SET 	`order_orders`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
									`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
							WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	INSERT 	`" . $order_table . "_events` 
							SET 	`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
									`" . $order_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
									`" . $order_table . "_events`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, $_POST['id']) . "', 
									`" . $order_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 2) . "', 
									`" . $order_table . "_events`.`message`='" . mysqli_real_escape_string($conn, $order_name . ", Gerät " . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . " entfernt, ID [#" . intval($_POST['device_id']) . "]") . "', 
									`" . $order_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, $order_name . ", Gerät " . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . " entfernt, ID [#" . intval($_POST['device_id']) . "]") . "', 
									`" . $order_table . "_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
									`" . $order_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

	if($row_device['storage_space_id'] > 0){
		mysqli_query($conn, "UPDATE `storage_places` SET `storage_places`.`used`=`storage_places`.`used`-1 WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['storage_space_id'])) . "'");
	}

	mysqli_query($conn, "	DELETE FROM	`order_orders_devices` 
							WHERE 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'
							AND 		`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['device_id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`shopin_shopins` 
							WHERE 		`shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'
							AND 		`shopin_shopins`.`device_id`='" . mysqli_real_escape_string($conn, intval($_POST['device_id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`intern_interns` 
							WHERE 		`intern_interns`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'
							AND 		`intern_interns`.`device_id`='" . mysqli_real_escape_string($conn, intval($_POST['device_id'])) . "'");

	$row_packing_device = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `packing_packings_devices` WHERE `packing_packings_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `packing_packings_devices`.`device_id`='" . mysqli_real_escape_string($conn, intval($_POST['device_id'])) . "'"), MYSQLI_ASSOC);

	if($row_packing_device['id'] > 0){

		mysqli_query($conn, "	DELETE FROM	`packing_packings_devices` 
								WHERE 		`packing_packings_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'
								AND 		`packing_packings_devices`.`device_id`='" . mysqli_real_escape_string($conn, intval($_POST['device_id'])) . "'");

		mysqli_query($conn, "	DELETE FROM	`packing_packings` 
								WHERE 		`packing_packings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'
								AND 		`packing_packings`.`id`='" . mysqli_real_escape_string($conn, intval($row_packing_device['packing_id'])) . "'");

	}

	mysqli_query($conn, "	INSERT 	`order_orders_devices_events` 
							SET 	`order_orders_devices_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
									`order_orders_devices_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
									`order_orders_devices_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_device['order_id'])) . "', 
									`order_orders_devices_events`.`type`='" . mysqli_real_escape_string($conn, 2) . "', 
									`order_orders_devices_events`.`message`='" . mysqli_real_escape_string($conn, "<span class=\"badge badge-danger\">Gerät " . $row_device['device_number'] . ($row_device['atot_mode'] == 1 ? "-AT-" . $row_device['at'] : ($row_device['atot_mode'] == 2 ? "-ORG-" . $row_device['ot'] : "")) . " entfernt, ID [#" . $row_device['id'] . "]</span> <span class=\"badge badge-danger\">Lagerplatz " . $row_device['storage_space'] . " entfernt, ID [#" . $row_device['id'] . "]</span>") . "', 
									`order_orders_devices_events`.`subject`='', 
									`order_orders_devices_events`.`body`='', 
									`order_orders_devices_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

	$_POST['edit'] = "bearbeiten";

?>