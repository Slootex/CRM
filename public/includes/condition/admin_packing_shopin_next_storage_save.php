<?php 

	$time = time();

	$row_shopin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `shopin_shopins` WHERE `shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND  `shopin_shopins`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	mysqli_query($conn, "	UPDATE 	`order_orders_devices` 
							SET 	`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
									`order_orders_devices`.`radio_technic_1`='" . mysqli_real_escape_string($conn, intval(isset($_POST['radio_technic_1']) ? $_POST['radio_technic_1'] : 0)) . "', 
									`order_orders_devices`.`radio_technic_2`='" . mysqli_real_escape_string($conn, intval(isset($_POST['radio_technic_2']) ? $_POST['radio_technic_2'] : 0)) . "', 
									`order_orders_devices`.`is_next_storage`='0', 
									`order_orders_devices`.`is_send`='0', 
									`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
							WHERE 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($row_shopin['device_id'])) . "' 
							AND 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	UPDATE 	`shopin_shopins` 
							SET 	`shopin_shopins`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
									`shopin_shopins`.`mode`='1', 
									`shopin_shopins`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
							WHERE 	`shopin_shopins`.`id`='" . mysqli_real_escape_string($conn, intval($row_shopin['id'])) . "' 
							AND 	`shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	unset($_POST['id']);

?>