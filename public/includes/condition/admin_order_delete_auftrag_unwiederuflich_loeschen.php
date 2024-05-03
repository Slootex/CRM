<?php 

	// delete order_orders
	mysqli_query($conn, "	DELETE FROM	`order_orders` 
							WHERE 		`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
							AND 		`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	// delete order_orders_*
	mysqli_query($conn, "	DELETE FROM	`order_orders_customer_messages` 
							WHERE 		`order_orders_customer_messages`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
							AND 		`order_orders_customer_messages`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	$result_devices = mysqli_query($conn, "SELECT * FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "'");

	while($row_device = $result_devices->fetch_array(MYSQLI_ASSOC)){

		if($row_device['storage_space_id'] > 0){
			// delete used part of a place
			mysqli_query($conn, "UPDATE `storage_places` SET `storage_places`.`used`=`storage_places`.`used`-1 WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['storage_space_id'])) . "'");
		}

	}

	mysqli_query($conn, "	DELETE FROM	`order_orders_audios` 
							WHERE 		`order_orders_audios`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
							AND 		`order_orders_audios`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`order_orders_devices` 
							WHERE 		`order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
							AND 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`order_orders_devices_events` 
							WHERE 		`order_orders_devices_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
							AND 		`order_orders_devices_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`order_orders_emails` 
							WHERE 		`order_orders_emails`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
							AND 		`order_orders_emails`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`order_orders_events` 
							WHERE 		`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
							AND 		`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`order_orders_files` 
							WHERE 		`order_orders_files`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
							AND 		`order_orders_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`order_orders_history` 
							WHERE 		`order_orders_history`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
							AND 		`order_orders_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`order_orders_packing_history` 
							WHERE 		`order_orders_packing_history`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
							AND 		`order_orders_packing_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`order_orders_payings` 
							WHERE 		`order_orders_payings`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
							AND 		`order_orders_payings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`order_orders_questions` 
							WHERE 		`order_orders_questions`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
							AND 		`order_orders_questions`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`order_orders_shipments` 
							WHERE 		`order_orders_shipments`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
							AND 		`order_orders_shipments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`order_orders_statuses` 
							WHERE 		`order_orders_statuses`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
							AND 		`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	// delete interested_interesteds_*
	mysqli_query($conn, "	DELETE FROM	`interested_interesteds_customer_messages` 
							WHERE 		`interested_interesteds_customer_messages`.`interested_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
							AND 		`interested_interesteds_customer_messages`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`interested_interesteds_emails` 
							WHERE 		`interested_interesteds_emails`.`interested_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
							AND 		`interested_interesteds_emails`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`interested_interesteds_events` 
							WHERE 		`interested_interesteds_events`.`interested_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
							AND 		`interested_interesteds_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`interested_interesteds_files` 
							WHERE 		`interested_interesteds_files`.`interested_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
							AND 		`interested_interesteds_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`interested_interesteds_history` 
							WHERE 		`interested_interesteds_history`.`interested_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
							AND 		`interested_interesteds_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`interested_interesteds_packing_history` 
							WHERE 		`interested_interesteds_packing_history`.`interested_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
							AND 		`interested_interesteds_packing_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`interested_interesteds_statuses` 
							WHERE 		`interested_interesteds_statuses`.`interested_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
							AND 		`interested_interesteds_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	array_map('unlink', array_filter((array) glob("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/userdata/*.*")));

	array_map('unlink', array_filter((array) glob("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/document/*.*")));

	array_map('unlink', array_filter((array) glob("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/audio/*.*")));

	@unlink("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/userdata/.htaccess");
	@rmdir("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/userdata");
	@unlink("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/document/.htaccess");
	@rmdir("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/document");
	@unlink("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/audio/.htaccess");
	@rmdir("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/audio");
	@rmdir("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number']);

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`shopping_shoppings` 
									WHERE		`shopping_shoppings`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "'");
	
	while($row_shoppings = $result->fetch_array(MYSQLI_ASSOC)){
		
		mysqli_query($conn, "	DELETE FROM	`shopping_shoppings_emails` 
								WHERE 		`shopping_shoppings_emails`.`shopping_id`='" . mysqli_real_escape_string($conn, intval($row_shoppings['id'])) . "' 
								AND 		`shopping_shoppings_emails`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");
	
		mysqli_query($conn, "	DELETE FROM	`shopping_shoppings_events` 
								WHERE 		`shopping_shoppings_events`.`shopping_id`='" . mysqli_real_escape_string($conn, intval($row_shoppings['id'])) . "' 
								AND 		`shopping_shoppings_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");
	
		mysqli_query($conn, "	DELETE FROM	`shopping_shoppings_statuses` 
								WHERE 		`shopping_shoppings_statuses`.`shopping_id`='" . mysqli_real_escape_string($conn, intval($row_shoppings['id'])) . "' 
								AND 		`shopping_shoppings_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");
	
		mysqli_query($conn, "	DELETE FROM	`shopping_retoures_emails` 
								WHERE 		`shopping_retoures_emails`.`shopping_id`='" . mysqli_real_escape_string($conn, intval($row_shoppings['id'])) . "' 
								AND 		`shopping_retoures_emails`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");
	
		mysqli_query($conn, "	DELETE FROM	`shopping_retoures_events` 
								WHERE 		`shopping_retoures_events`.`shopping_id`='" . mysqli_real_escape_string($conn, intval($row_shoppings['id'])) . "' 
								AND 		`shopping_retoures_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");
	
		mysqli_query($conn, "	DELETE FROM	`shopping_retoures_statuses` 
								WHERE 		`shopping_retoures_statuses`.`shopping_id`='" . mysqli_real_escape_string($conn, intval($row_shoppings['id'])) . "' 
								AND 		`shopping_retoures_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		@unlink("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/shopping/url_" . intval($row_shoppings['id']) . ".pdf");

	}

	mysqli_query($conn, "	DELETE FROM	`shopping_shoppings` 
							WHERE 		`shopping_shoppings`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
							AND 		`shopping_shoppings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`intern_interns` 
							WHERE 		`intern_interns`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
							AND 		`intern_interns`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	$result_packings = mysqli_query($conn, "SELECT * FROM `packing_packings` WHERE `packing_packings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `packing_packings`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "'");

	while($row_packing = $result_packings->fetch_array(MYSQLI_ASSOC)){

		mysqli_query($conn, "	DELETE FROM	`packing_packings_events` 
								WHERE 		`packing_packings_events`.`packing_id`='" . mysqli_real_escape_string($conn, intval($row_packing['id'])) . "' 
								AND 		`packing_packings_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		mysqli_query($conn, "	DELETE FROM	`packing_packings_statuses` 
								WHERE 		`packing_packings_statuses`.`packing_id`='" . mysqli_real_escape_string($conn, intval($row_packing['id'])) . "' 
								AND 		`packing_packings_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		array_map('unlink', array_filter((array) glob("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/packing/" . $row_packing['packing_number'] . "/document/*.*")));
	
		@unlink("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/packing/" . $row_packing['packing_number'] . "/document/.htaccess");
		@rmdir("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/packing/" . $row_packing['packing_number'] . "/document");
		@rmdir("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/packing/" . $row_packing['packing_number']);

	}

	mysqli_query($conn, "	DELETE FROM	`packing_packings` 
							WHERE 		`packing_packings`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
							AND 		`packing_packings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`packing_packings_devices` 
							WHERE 		`packing_packings_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
							AND 		`packing_packings_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	unset($_POST['id']);

?>