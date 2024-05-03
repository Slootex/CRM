<?php 

	$time = time();

	$row_shopin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `shopin_shopins` WHERE `shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `shopin_shopins`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	if($row_shopin['storage_space_id'] > 0){

		mysqli_query($conn, "UPDATE `storage_places` SET `storage_places`.`used`=`storage_places`.`used`-1 WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_shopin['storage_space_id'])) . "'");

	}

	mysqli_query($conn, "	UPDATE 	`order_orders_devices` 
							SET 	`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
									`order_orders_devices`.`storage_space_id`='" . mysqli_real_escape_string($conn, intval($row_shopin['old_storage_space_id'])) . "', 
									`order_orders_devices`.`is_shopin_relocate`='0', 
									`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
							WHERE 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($row_shopin['device_id'])) . "' 
							AND 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`shopin_shopins` 
							WHERE 		`shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'
							AND 		`shopin_shopins`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	unset($_POST['id']);

?>