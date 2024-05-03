<?php 

	if($emsg == ""){

		$ids = explode(",", strip_tags($_POST['ids']));

		for($i = 0;$i < count($ids);$i++){

			$time = time();

			$row_shopping = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `shopping_shoppings` WHERE `shopping_shoppings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `shopping_shoppings`.`id`='" . mysqli_real_escape_string($conn, intval($ids[$i])) . "'"), MYSQLI_ASSOC);

			$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($row_shopping['order_id'])) . "'"), MYSQLI_ASSOC);

			$row_status = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`='" . mysqli_real_escape_string($conn, intval($maindata[$parameter['shopping_to_archive_status']])) . "'"), MYSQLI_ASSOC);
			$row_template = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `templates` WHERE `templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `templates`.`id`='" . mysqli_real_escape_string($conn, intval($row_status['email_template'])) . "'"), MYSQLI_ASSOC);

			$row_status_admin_id = mysqli_fetch_array(mysqli_query($conn, "	SELECT 		`" . $shopping_table . "_statuses`.`admin_id` AS admin_id 
																			FROM 		`" . $shopping_table . "_statuses` 
																			LEFT JOIN 	`statuses` 
																			ON 			`statuses`.`id`=`" . $shopping_table . "_statuses`.`status_id` 
																			WHERE 		`" . $shopping_table . "_statuses`.`shopping_id`='" . mysqli_real_escape_string($conn, intval($row_shopping['id'])) . "' 
																			AND 		`" . $shopping_table . "_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																			AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																			AND 		`statuses`.`public`>='0' 
																			ORDER BY 	CAST(`" . $shopping_table . "_statuses`.`time` AS UNSIGNED) DESC limit 0, 1"), MYSQLI_ASSOC);

			mysqli_query($conn, "	UPDATE	`shopping_shoppings` 
									SET 	`shopping_shoppings`.`mode`='" . $shopping_archiv_mode . "', 
											`shopping_shoppings`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`shopping_shoppings`.`agent_id`='" . mysqli_real_escape_string($conn, intval($row_status_admin_id['admin_id'])) . "', 
											`shopping_shoppings`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
									WHERE 	`shopping_shoppings`.`id`='" . mysqli_real_escape_string($conn, intval($row_shopping['id'])) . "' 
									AND 	`shopping_shoppings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

			$_SESSION["status"]["id"] = 0;

			mysqli_query($conn, "	INSERT 	`" . $shopping_table . "_events` 
									SET 	`" . $shopping_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
											`" . $shopping_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`" . $shopping_table . "_events`.`shopping_id`='" . mysqli_real_escape_string($conn, intval($row_shopping['id'])) . "', 
											`" . $shopping_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
											`" . $shopping_table . "_events`.`message`='" . mysqli_real_escape_string($conn, $shopping_name . " nach Archiv verschoben, ID [#" . $_SESSION["status"]["id"] . "]") . "', 
											`" . $shopping_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
											`" . $shopping_table . "_events`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
											`" . $shopping_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		}

	}

?>