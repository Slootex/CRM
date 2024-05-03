<?php 

	$time = time();

	mysqli_query($conn, "	DELETE FROM	`packing_packings` 
							WHERE 		`packing_packings`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 		`packing_packings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

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
									AND 		`packing_packings_devices`.`packing_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
									AND 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									ORDER BY 	CAST(`packing_packings_devices`.`device_number` AS UNSIGNED) DESC");

	while($row_device = $result->fetch_array(MYSQLI_ASSOC)){

		mysqli_query($conn, "	UPDATE 	`order_orders_devices` 
								SET 	`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`order_orders_devices`.`is_shipping_user`='0', 
										`order_orders_devices`.`is_shipping_technic`='0', 
										`order_orders_devices`.`is_shipping_extern`='0', 
										`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
								WHERE 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['device_id'])) . "' 
								AND 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	}

	mysqli_query($conn, "	DELETE FROM	`packing_packings_devices` 
							WHERE 		`packing_packings_devices`.`packing_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 		`packing_packings_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`packing_packings_events` 
							WHERE 		`packing_packings_events`.`packing_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 		`packing_packings_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`packing_packings_statuses` 
							WHERE 		`packing_packings_statuses`.`packing_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 		`packing_packings_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	unset($_POST['id']);

?>