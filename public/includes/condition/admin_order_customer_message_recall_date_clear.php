<?php 

	if($emsg == ""){

		$time = time();

		mysqli_query($conn, "	UPDATE	`order_orders` 
								SET 	`order_orders`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`order_orders`.`recall_date`='" . mysqli_real_escape_string($conn, "") . "', 
										`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
								WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
								AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		mysqli_query($conn, "	INSERT 	`" . $order_table . "_customer_messages` 
								SET 	`" . $order_table . "_customer_messages`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`" . $order_table . "_customer_messages`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`" . $order_table . "_customer_messages`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
										`" . $order_table . "_customer_messages`.`message`='" . mysqli_real_escape_string($conn, "Rückruf erledigt") . "', 
										`" . $order_table . "_customer_messages`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$_SESSION["customer_messages"]["id"] = $conn->insert_id;

		mysqli_query($conn, "	INSERT 	`" . $order_table . "_events` 
								SET 	`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`" . $order_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`" . $order_table . "_events`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`" . $order_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
										`" . $order_table . "_events`.`message`='" . mysqli_real_escape_string($conn, $order_name . "-Kundenhistory, (auto) Nachricht erstellt, ID [#" . $_SESSION["customer_messages"]["id"] . "]") . "', 
										`" . $order_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, $order_name . "-Kundenhistory, (auto) Nachricht erstellt, ID [#" . $_SESSION["customer_messages"]["id"] . "]") . "', 
										`" . $order_table . "_events`.`body`='" . mysqli_real_escape_string($conn, "Rückruf erledigt") . "', 
										`" . $order_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$message = "";

	}

	$_POST['edit'] = "bearbeiten";

?>