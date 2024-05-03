<?php 

	$time = time();

	$row_shopin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `shopin_shopins` WHERE `shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND  `shopin_shopins`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	$row_order = mysqli_fetch_array(mysqli_query($conn, "	SELECT 	* 
															FROM 	`order_orders` 
															WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['order_id'])) . "' 
															AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

	if($row_order['mode'] < 2){

		$order_name = "Auftrag";

		$order_table = "order_orders";

		$order_id_field = "order_id";

	}else{

		$order_name = "Interessent";

		$order_table = "interested_interesteds";

		$order_id_field = "interested_id";

	}

	$row_file = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders_files` WHERE `order_orders_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_files`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['item'])) . "'"), MYSQLI_ASSOC);

	mysqli_query($conn, "	DELETE FROM	`order_orders_files` 
							WHERE 		`order_orders_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'
							AND 		`order_orders_files`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['item'])) . "'");

	@unlink("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/" . (intval($row_file['type']) == 4 ? "userdata" : "document") . "/" . $row_file['file']);

	mysqli_query($conn, "	UPDATE 	`order_orders` 
							SET 	`order_orders`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
									`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
							WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['order_id'])) . "' 
							AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	INSERT 	`" . $order_table . "_events` 
							SET 	`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
									`" . $order_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
									`" . $order_table . "_events`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST["order_id"])) . "', 
									`" . $order_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
									`" . $order_table . "_events`.`message`='" . mysqli_real_escape_string($conn, $order_name . "-Dateien, Datei entfernt, ID [#" . $row_file['id'] . "]") . "', 
									`" . $order_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, $order_name . "-Dateien, Datei entfernt, ID [#" . $row_file['id'] . "]") . "', 
									`" . $order_table . "_events`.`body`='" . mysqli_real_escape_string($conn, "Name [" . $row_file['file'] . "]") . "', 
									`" . $order_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");


	$_POST['shopin_add_device'] = "hinzufügen";

?>