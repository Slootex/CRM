<?php 

	$time = time();

	if($emsg == ""){

		$row_device = mysqli_fetch_array(mysqli_query($conn, "	SELECT 	* 
																FROM 	`packing_packings_devices` 
																WHERE 	`packing_packings_devices`.`id`='" . mysqli_real_escape_string($conn, intval(isset($_POST['device_id']) ? $_POST['device_id'] : 0)) . "' 
																AND 	`packing_packings_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

		mysqli_query($conn, "	UPDATE 	`order_orders_devices` 
								SET 	`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`order_orders_devices`.`is_shipping_user`='0', 
										`order_orders_devices`.`is_shipping_technic`='0', 
										`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
								WHERE 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['device_id'])) . "' 
								AND 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		mysqli_query($conn, "	DELETE FROM	`packing_packings_devices` 
								WHERE 		`packing_packings_devices`.`id`='" . mysqli_real_escape_string($conn, intval(isset($_POST['device_id']) ? $_POST['device_id'] : 0)) . "' 
								AND 		`packing_packings_devices`.`packing_id`='" . mysqli_real_escape_string($conn, intval($row_packing['id'])) . "' 
								AND 		`packing_packings_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");


		$emsg = "<p>Das entfernen des Versandartikels wurde erfolgreich durchgeführt!</p>\n";

	}

	$_POST['edit'] = "bearbeiten";

?>