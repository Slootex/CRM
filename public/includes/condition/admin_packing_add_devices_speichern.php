<?php 

	$time = time();

	if($emsg == ""){

		$result = mysqli_query($conn, "	SELECT 		`order_orders_devices`.`id` AS id, 
													`order_orders_devices`.`device_number` AS device_number 
										FROM 		`order_orders_devices` `order_orders_devices` 
										WHERE 		`order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_packing['order_id'])) . "' 
										AND 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
										ORDER BY 	CAST(`order_orders_devices`.`reg_date` AS UNSIGNED) DESC");

		while($row_device = $result->fetch_array(MYSQLI_ASSOC)){
			if(isset($_POST['device_' . $row_device['id']]) && intval($_POST['device_' . $row_device['id']]) == 1){

				mysqli_query($conn, "	UPDATE 	`order_orders_devices` 
										SET 	`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
												`order_orders_devices`.`is_shipping_" . ($row_packing['type'] == 3 ? "user" : "technic") . "`='1', 
												`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
										WHERE 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['id'])) . "' 
										AND 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

				mysqli_query($conn, "	INSERT 	`packing_packings_devices` 
										SET 	`packing_packings_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
												`packing_packings_devices`.`packing_id`='" . mysqli_real_escape_string($conn, intval($row_packing['id'])) . "', 
												`packing_packings_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_packing['order_id'])) . "', 
												`packing_packings_devices`.`device_id`='" . mysqli_real_escape_string($conn, intval($row_device['id'])) . "', 
												`packing_packings_devices`.`device_number`='" . mysqli_real_escape_string($conn, $row_device['device_number']) . "'");
			}
		}

		$emsg = "<p>Die gewählten Geräte/Versandartikel wurden dem Packtisch erfolgreich hinzugefügt!</p>\n";

	}

	$_POST['edit'] = "bearbeiten";

?>