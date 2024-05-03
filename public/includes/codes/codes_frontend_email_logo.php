<?php 

if(isset($param['company_id']) && intval($param['company_id']) > 0 && isset($param['order_number']) && isset($param['status_number'])){

	$row_company = mysqli_fetch_array(mysqli_query($conn, "	SELECT 	* 
															FROM 	`companies` 
															WHERE 	`companies`.`id`='" . mysqli_real_escape_string($conn, intval($param['company_id'])) . "'"), MYSQLI_ASSOC);

	if(isset($row_company['id']) && intval($row_company['id']) > 0){

		$order_orders = $row_company['theme_id'] == 1 ? "order_orders" : "order_orders_" . $row_company['theme_id'];

		$row_order_status = mysqli_fetch_array(mysqli_query($conn, "	SELECT 		`order_orders_statuses`.`id` AS status_id 
																		FROM 		`" . $order_orders . "` 
																		LEFT JOIN 	`order_orders_statuses` 
																		ON 			`order_orders_statuses`.`order_id`=`" . $order_orders . "`.`id` 
																		WHERE 		`" . $order_orders . "`.`company_id`='" . mysqli_real_escape_string($conn, intval($row_company['id'])) . "' 
																		AND 		`" . $order_orders . "`.`order_number`='" . mysqli_real_escape_string($conn, strip_tags($param['order_number'])) . "' 
																		AND 		`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($row_company['id'])) . "' 
																		AND 		`order_orders_statuses`.`status_number`='" . mysqli_real_escape_string($conn, strip_tags($param['status_number'])) . "'"), MYSQLI_ASSOC);

		if(isset($row_order_status['status_id']) && intval($row_order_status['status_id']) > 0){

			mysqli_query($conn, "	UPDATE 	`order_orders_statuses` 
									SET 	`order_orders_statuses`.`email_reads`=`order_orders_statuses`.`email_reads`+1 
									WHERE 	`order_orders_statuses`.`id`='" . $row_order_status['status_id'] . "'");

		}

		$row_order_status = mysqli_fetch_array(mysqli_query($conn, "	SELECT 		`interested_interesteds_statuses`.`id` AS status_id 
																		FROM 		`" . $order_orders . "` 
																		LEFT JOIN 	`interested_interesteds_statuses` 
																		ON 			`interested_interesteds_statuses`.`interested_id`=`" . $order_orders . "`.`id` 
																		WHERE 		`" . $order_orders . "`.`company_id`='" . mysqli_real_escape_string($conn, intval($row_company['id'])) . "' 
																		AND 		`" . $order_orders . "`.`order_number`='" . mysqli_real_escape_string($conn, strip_tags($param['order_number'])) . "' 
																		AND 		`interested_interesteds_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($row_company['id'])) . "' 
																		AND 		`interested_interesteds_statuses`.`status_number`='" . mysqli_real_escape_string($conn, strip_tags($param['status_number'])) . "'"), MYSQLI_ASSOC);

		if(isset($row_order_status['status_id']) && intval($row_order_status['status_id']) > 0){

			mysqli_query($conn, "	UPDATE 	`interested_interesteds_statuses` 
									SET 	`interested_interesteds_statuses`.`email_reads`=`interested_interesteds_statuses`.`email_reads`+1 
									WHERE 	`interested_interesteds_statuses`.`id`='" . $row_order_status['status_id'] . "'");

		}

	}

}

?>