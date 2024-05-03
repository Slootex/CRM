<?php 

	if($emsg == ""){

		$time = time();

		mysqli_query($conn, "	UPDATE	`order_orders` 
								SET 	`order_orders`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`order_orders`.`his_date`='" . mysqli_real_escape_string($conn, $time) . "', 
										`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, $time) . "' 
								WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
								AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		$result = mysqli_query($conn, "	SELECT 		* 
										FROM 		`" . $order_table . "_customer_messages` 
										WHERE 		`" . $order_table . "_customer_messages`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
										AND 		`" . $order_table . "_customer_messages`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
										AND 		`" . $order_table . "_customer_messages`.`is_level`='1'");

		$level_pos = intval($result->num_rows) + 1;

		$result = mysqli_query($conn, "	SELECT 		* 
										FROM 		`statuses_level` 
										WHERE 		`statuses_level`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
										AND 		`statuses_level`.`status_id`='" . mysqli_real_escape_string($conn, intval($_POST['status_id'])) . "'");

		$level_amount = intval($result->num_rows);

		if($level_pos <= $level_amount){

			$row_level = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `statuses_level` WHERE `statuses_level`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses_level`.`pos`='" . mysqli_real_escape_string($conn, intval($level_pos)) . "' AND `statuses_level`.`status_id`='" . mysqli_real_escape_string($conn, intval($_POST['status_id'])) . "'"), MYSQLI_ASSOC);

			if(isset($row_level['id'])){

				$random_id = rand(1, 3);

				$message = $row_level['variant_' . $random_id . '_text'];

				$level_time = $row_level['variant_' . $random_id . '_time'];

				mysqli_query($conn, "	INSERT 	`" . $order_table . "_customer_messages` 
										SET 	`" . $order_table . "_customer_messages`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
												`" . $order_table . "_customer_messages`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
												`" . $order_table . "_customer_messages`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
												`" . $order_table . "_customer_messages`.`message`='" . mysqli_real_escape_string($conn, $message) . "', 
												`" . $order_table . "_customer_messages`.`status`='1', 
												`" . $order_table . "_customer_messages`.`level_time`='" . mysqli_real_escape_string($conn, "<strong class=\"text-danger\">" . $level_time . "</strong>") . "', 
												`" . $order_table . "_customer_messages`.`level`='" . mysqli_real_escape_string($conn, $row_level['level']) . "', 
												`" . $order_table . "_customer_messages`.`is_level`='1', 
												`" . $order_table . "_customer_messages`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

				$_SESSION["customer_messages"]["id"] = $conn->insert_id;

				mysqli_query($conn, "	INSERT 	`" . $order_table . "_events` 
										SET 	`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
												`" . $order_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
												`" . $order_table . "_events`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
												`" . $order_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
												`" . $order_table . "_events`.`message`='" . mysqli_real_escape_string($conn, $order_name . "-Kundenhistory, (auto) Nachricht erstellt, ID [#" . $_SESSION["customer_messages"]["id"] . "]") . "', 
												`" . $order_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, $order_name . "-Kundenhistory, (auto) Nachricht erstellt, ID [#" . $_SESSION["customer_messages"]["id"] . "]") . "', 
												`" . $order_table . "_events`.`body`='" . mysqli_real_escape_string($conn, $message) . "', 
												`" . $order_table . "_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

				$message = "";

			}

		}

	}

	$_POST['edit'] = "bearbeiten";

?>