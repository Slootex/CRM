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
										`shopin_shopins`.`type`='4', 
										`shopin_shopins`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
								WHERE 	`shopin_shopins`.`id`='" . mysqli_real_escape_string($conn, intval($row_shopin['id'])) . "' 
								AND 	`shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		if(file_exists("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/" . $row_order['order_number'] . ".pdf")){

			$random = rand(1, 100000);

			copy("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/" . $row_order['order_number'] . ".pdf", "uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/document/" . $random . '_' . $row_order['order_number'] . ".pdf");

			@unlink("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/" . $row_order['order_number'] . ".pdf");

			mysqli_query($conn, "	INSERT 	`order_orders_files` 
									SET 	`order_orders_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
											`order_orders_files`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
											`order_orders_files`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "', 
											`order_orders_files`.`device_id`='" . mysqli_real_escape_string($conn, intval($row_shopin['device_id'])) . "', 
											`order_orders_files`.`type`='5', 
											`order_orders_files`.`file`='" . mysqli_real_escape_string($conn, $random . '_' . $row_order['order_number'] . ".pdf") . "', 
											`order_orders_files`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		}

		$files = scandir("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/");

		foreach($files as $k => $filename){

			if($filename != "." && $filename != ".." && $filename != ".htaccess" && $filename != "@eaDir"){

				$order_number = explode("_", $filename);

				if($row_order['order_number'] == $order_number[0]){

					$random = rand(1, 100000);

					copy("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/" . $filename, "uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/document/" . $random . '_' . $filename);

					@unlink("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/" . $filename);

					mysqli_query($conn, "	INSERT 	`order_orders_files` 
											SET 	`order_orders_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
													`order_orders_files`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`order_orders_files`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "', 
													`order_orders_files`.`device_id`='" . mysqli_real_escape_string($conn, intval($row_shopin['device_id'])) . "', 
													`order_orders_files`.`type`='6', 
													`order_orders_files`.`file`='" . mysqli_real_escape_string($conn, $random . '_' . $filename) . "', 
													`order_orders_files`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

				}

			}

		}

		$_POST['shopin_add_device'] = "complete";

	}else{

		$_POST['shopin_add_device'] = "hinzufügen";

	}

?>