<?php 

	$time = time();

	mysqli_query($conn, "	UPDATE	`order_orders` 
							SET 	`order_orders`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
									`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
							WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM 	`" . $order_table . "_history` 
							WHERE			`" . $order_table . "_history`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['history_id'])) . "' 
							AND 			`" . $order_table . "_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	INSERT 	`" . $order_table . "_events` 
							SET 	`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
									`" . $order_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
									`" . $order_table . "_events`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
									`" . $order_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 2) . "', 
									`" . $order_table . "_events`.`message`='" . mysqli_real_escape_string($conn, $order_name . "-Auftragshistorie, Nachricht entfernt, ID [#" . intval($_POST['history_id']) . "]") . "', 
									`" . $order_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, $order_name . "-Auftragshistorie, Nachricht entfernt, ID [#" . intval($_POST['history_id']) . "]") . "', 
									`" . $order_table . "_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
									`" . $order_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

	$_POST['edit'] = "bearbeiten";

?>