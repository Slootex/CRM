<?php 

	$row_shopin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `shopin_shopins` WHERE `shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND  `shopin_shopins`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($row_shopin['order_id'])) . "'"), MYSQLI_ASSOC);

	if($emsg == ""){

		$time = time();

		if(intval($row_order['transfer_date']) == 0){

			mysqli_query($conn, "	UPDATE 	`order_orders` 
									SET 	`order_orders`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`order_orders`.`mode`='0', 
											`order_orders`.`transfer_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
											`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
									WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($row_shopin['order_id'])) . "' 
									AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		}else{

			mysqli_query($conn, "	UPDATE 	`order_orders` 
									SET 	`order_orders`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`order_orders`.`mode`='0', 
											`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
									WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($row_shopin['order_id'])) . "' 
									AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		}

		mysqli_query($conn, "	UPDATE 	`shopin_shopins` 
								SET 	`shopin_shopins`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`shopin_shopins`.`type`='8', 
										`shopin_shopins`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
								WHERE 	`shopin_shopins`.`id`='" . mysqli_real_escape_string($conn, intval($row_shopin['id'])) . "' 
								AND 	`shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		$_POST['shopin_next_storage'] = "complete";

	}else{

		$_POST['shopin_next_storage'] = "hinzufügen";
	
	}

?>