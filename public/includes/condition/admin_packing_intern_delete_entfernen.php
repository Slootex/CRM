<?php 

	$time = time();

	$row_intern = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `intern_interns` WHERE `intern_interns`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND  `intern_interns`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	if($row_intern['type'] == 2){

		$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND  `order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($row_intern['order_id'])) . "'"), MYSQLI_ASSOC);

		if(isset($row_order['id']) && $row_order['mode'] < 2){

			$order_name = "Auftrag";

			$order_table = "order_orders";

			$order_id_field = "order_id";

			$status_field = "";

		}else{

			$order_name = "Interessent";

			$order_table = "interested_interesteds";

			$order_id_field = "interested_id";

			$status_field = "";

		}

		mysqli_query($conn, "UPDATE `storage_places` SET `storage_places`.`used`=`storage_places`.`used`-1 WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_intern['to_storage_space_id'])) . "'");

		mysqli_query($conn, "	INSERT 	`" . $order_table . "_events` 
								SET 	`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`" . $order_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`" . $order_table . "_events`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($row_intern['order_id'])) . "', 
										`" . $order_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
										`" . $order_table . "_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $row_intern['device_number'] . ", Daten geändert (Umlagerungs - Lagerplatz " . $row_intern['storage_space'] . " entfernt), ID [#" . intval($row_intern['device_id']) . "]") . "', 
										`" . $order_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $row_intern['device_number'] . ", Daten geändert (Umlagerungs - Lagerplatz " . $row_intern['storage_space'] . " entfernt), ID [#" . intval($row_intern['device_id']) . "]") . "', 
										`" . $order_table . "_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
										`" . $order_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		mysqli_query($conn, "	INSERT 	`order_orders_devices_events` 
								SET 	`order_orders_devices_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`order_orders_devices_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`order_orders_devices_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_intern['order_id'])) . "', 
										`order_orders_devices_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
										`order_orders_devices_events`.`message`='" . mysqli_real_escape_string($conn, "<span class=\"badge badge-danger\">Gerät " . $row_intern['device_number'] . ", Lagerplatz " . $row_intern['storage_space'] . " entfernt, ID [#" . $row_intern['device_id'] . "]</span>") . "', 
										`order_orders_devices_events`.`subject`='', 
										`order_orders_devices_events`.`body`='', 
										`order_orders_devices_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

	}

	mysqli_query($conn, "	UPDATE 	`order_orders_devices` 
							SET 	`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
									`order_orders_devices`.`is_labeling`='0', 
									`order_orders_devices`.`is_photo`='0', 
									`order_orders_devices`.`is_relocate`='0', 
									`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
							WHERE 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($row_intern['device_id'])) . "' 
							AND 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`intern_interns` 
							WHERE 		`intern_interns`.`id`='" . mysqli_real_escape_string($conn, intval($row_intern['id'])) . "' 
							AND 		`intern_interns`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	unset($_POST['id']);

?>