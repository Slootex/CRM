<?php 

	if($emsg == ""){

		$ids = explode(",", strip_tags($_POST['ids']));

		for($i = 0;$i < count($ids);$i++){

			$time = time();

			$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($ids[$i])) . "'"), MYSQLI_ASSOC);
			$row_status = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`='" . mysqli_real_escape_string($conn, intval($maindata[$parameter['order_to_archive_status']])) . "'"), MYSQLI_ASSOC);
			$row_template = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `templates` WHERE `templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `templates`.`id`='" . mysqli_real_escape_string($conn, intval($row_status['email_template'])) . "'"), MYSQLI_ASSOC);

			$row_status_admin_id = mysqli_fetch_array(mysqli_query($conn, "	SELECT 		`" . $order_table . "_statuses`.`admin_id` AS admin_id 
																			FROM 		`" . $order_table . "_statuses` 
																			LEFT JOIN 	`statuses` 
																			ON 			`statuses`.`id`=`" . $order_table . "_statuses`.`status_id` 
																			WHERE 		`" . $order_table . "_statuses`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($ids[$i])) . "' 
																			AND 		`" . $order_table . "_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																			AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																			AND 		`statuses`.`public`>='0' 
																			ORDER BY 	CAST(`" . $order_table . "_statuses`.`time` AS UNSIGNED) DESC limit 0, 1"), MYSQLI_ASSOC);

			mysqli_query($conn, "	UPDATE	`order_orders` 
									SET 	`order_orders`.`mode`='" . mysqli_real_escape_string($conn, intval($order_archiv_mode)) . "', 
											`order_orders`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`order_orders`.`agent_id`='" . mysqli_real_escape_string($conn, intval($row_status_admin_id['admin_id'])) . "', 
											`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
									WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($ids[$i])) . "' 
									AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

			$_SESSION["status"]["id"] = 0;

			mysqli_query($conn, "	INSERT 	`" . $order_table . "_events` 
									SET 	`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
											`" . $order_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`" . $order_table . "_events`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($ids[$i])) . "', 
											`" . $order_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
											`" . $order_table . "_events`.`message`='" . mysqli_real_escape_string($conn, $order_name . " nach Archiv verschoben, ID [#" . $_SESSION["status"]["id"] . "]") . "', 
											`" . $order_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
											`" . $order_table . "_events`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
											`" . $order_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		}

	}

?>