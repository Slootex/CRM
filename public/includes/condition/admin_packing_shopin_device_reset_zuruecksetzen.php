<?php 

	echo "Info: Der Code des Buttons ist vorübergehend entfernt!<br>";
	echo "Datei: admin_packing_shopin_device_reset_zuruecksetzen.php<br>";
	$_POST['shopin_used'] = "benutzt";

	/*$time = time();

	$row_device = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND  `order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	mysqli_query($conn, "	DELETE FROM	`shopin_shopins` 
							WHERE 		`shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'
							AND 		`shopin_shopins`.`device_id`='" . mysqli_real_escape_string($conn, intval($row_device['id'])) . "'");

	if($row_device['storage_space_id'] > 0){
		mysqli_query($conn, "UPDATE `storage_places` SET `storage_places`.`used`=`storage_places`.`used`-1 WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['storage_space_id'])) . "'");
	}

	mysqli_query($conn, "	UPDATE 	`order_orders_devices` 
							SET 	`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
									`order_orders_devices`.`storage_space_id`='0', 
									`order_orders_devices`.`is_storage`='0', 
									`order_orders_devices`.`is_shopin_relocate`='0', 
									`order_orders_devices`.`is_labeling`='0', 
									`order_orders_devices`.`is_photo`='0', 
									`order_orders_devices`.`is_shipping_user`='0', 
									`order_orders_devices`.`is_shipping_technic`='0', 
									`order_orders_devices`.`is_send`='0', 
									`order_orders_devices`.`is_relocate`='0', 
									`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
							WHERE 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['id'])) . "' 
							AND 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	$row_order = mysqli_fetch_array(mysqli_query($conn, "	SELECT 	* 
															FROM	`order_orders` 
															WHERE	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
															AND 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, strip_tags($row_device['order_id'])) . "'"), MYSQLI_ASSOC);

	$shopin_number = 0;

	while($shopin_number == 0){

		$random = rand(10001, 99999);

		$result = mysqli_query($conn, "SELECT * FROM `shopin_shopins` WHERE `shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `shopin_shopins`.`shopin_number`='" . $random . "'");

		if($result->num_rows == 0){

			$shopin_number = $random;

		}

	}

	$result = mysqli_query($conn, "SELECT * FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' ORDER BY CAST(`storage_places`.`pos` AS UNSIGNED) ASC");

	$storage_space = "";

	$storage_space_id = 0;

	while($row_storage_place = $result->fetch_array(MYSQLI_ASSOC)){

		if($row_storage_place['used'] < $row_storage_place['parts']){

			$storage_space = $row_storage_place['name'];

			$storage_space_id = $row_storage_place['id'];

			mysqli_query($conn, "UPDATE `storage_places` SET `storage_places`.`used`=`storage_places`.`used`+1 WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_storage_place['id'])) . "'");

			break;

		}

	}

	mysqli_query($conn, "	UPDATE 	`order_orders_devices` 
							SET 	`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
									`order_orders_devices`.`storage_space_id`='" . mysqli_real_escape_string($conn, intval($storage_space_id)) . "', 
									`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
							WHERE 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['id'])) . "' 
							AND 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	INSERT 	`shopin_shopins` 
							SET 	`shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
									`shopin_shopins`.`mode`='0', 
									`shopin_shopins`.`type`='5', 
									`shopin_shopins`.`shopin_number`='" . mysqli_real_escape_string($conn, strip_tags($shopin_number)) . "', 
									`shopin_shopins`.`order_number`='" . mysqli_real_escape_string($conn, strip_tags($row_order['order_number'])) . "', 
									`shopin_shopins`.`creator_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
									`shopin_shopins`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
									`shopin_shopins`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_device['order_id'])) . "', 
									`shopin_shopins`.`device_id`='" . mysqli_real_escape_string($conn, intval($row_device["id"])) . "', 
									`shopin_shopins`.`storage_space_id`='" . mysqli_real_escape_string($conn, intval($storage_space_id)) . "', 
									`shopin_shopins`.`old_storage_space_id`='" . mysqli_real_escape_string($conn, intval($row_device['storage_space_id'])) . "', 
									`shopin_shopins`.`description`='" . mysqli_real_escape_string($conn, strip_tags("Gerät im Auftrag gefunden!")) . "', 
									`shopin_shopins`.`reg_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
									`shopin_shopins`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

	$_POST["id"] = $conn->insert_id;

	$_POST['shopin_relocate'] = "hinzufügen";*/

?>