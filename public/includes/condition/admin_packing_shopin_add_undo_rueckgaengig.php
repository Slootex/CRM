<?php 

	$time = time();

	$row_shopin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `shopin_shopins` WHERE `shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `shopin_shopins`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	$row_device = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($row_shopin['device_id'])) . "'"), MYSQLI_ASSOC);

	mysqli_query($conn, "	UPDATE 	`order_orders_devices` 
							SET 	`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
									`order_orders_devices`.`is_storage`='0', 
									`order_orders_devices`.`is_shopin_relocate`='0', 
									`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
							WHERE 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($row_shopin['device_id'])) . "' 
							AND 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	if($row_device['storage_space_id'] > 0){
		mysqli_query($conn, "UPDATE `storage_places` SET `storage_places`.`used`=`storage_places`.`used`-1 WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['storage_space_id'])) . "'");
	}

	mysqli_query($conn, "	DELETE FROM	`shopin_shopins` 
							WHERE 		`shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'
							AND 		`shopin_shopins`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`order_orders_devices` 
							WHERE 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'
							AND 		`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($row_shopin['device_id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`packing_packings_devices` 
							WHERE 		`packing_packings_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'
							AND 		`packing_packings_devices`.`device_id`='" . mysqli_real_escape_string($conn, intval($row_shopin['device_id'])) . "'");

	mysqli_query($conn, "	INSERT 	`order_orders_events` 
							SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
									`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
									`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_shopin['order_id'])) . "', 
									`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 2) . "', 
									`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag, Gerät " . $row_device['device_number'] . " entfernt, ID [#" . intval($row_shopin['device_id']) . "]") . "', 
									`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag, Gerät " . $row_device['device_number'] . " entfernt, ID [#" . intval($row_shopin['device_id']) . "]") . "', 
									`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
									`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

	mysqli_query($conn, "	INSERT 	`order_orders_devices_events` 
							SET 	`order_orders_devices_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
									`order_orders_devices_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
									`order_orders_devices_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_shopin['order_id'])) . "', 
									`order_orders_devices_events`.`type`='" . mysqli_real_escape_string($conn, 2) . "', 
									`order_orders_devices_events`.`message`='" . mysqli_real_escape_string($conn, "<span class=\"badge badge-danger\">Gerät " . $row_device['device_number'] . " entfernt</span> <span class=\"badge badge-danger\">Lagerplatz " . $row_device['storage_space'] . " entfernt, ID [#" . $row_device['id'] . "]</span>") . "', 
									`order_orders_devices_events`.`subject`='', 
									`order_orders_devices_events`.`body`='', 
									`order_orders_devices_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

	unset($_POST['id']);

?>