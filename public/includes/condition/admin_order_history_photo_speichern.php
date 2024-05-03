<?php 

	$time = time();

	$has_devices = false;

	$result_devices = mysqli_query($conn, "	SELECT 		`order_orders_devices`.`id` AS id, 
														`order_orders_devices`.`device_number` AS device_number 
											FROM 		`order_orders_devices` `order_orders_devices` 
											WHERE 		`order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
											AND 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
											ORDER BY 	`order_orders_devices`.`device_number` ASC");

	while($row_device = $result_devices->fetch_array(MYSQLI_ASSOC)){

		if(isset($_POST['device_' . $row_device['id']]) && intval($_POST['device_' . $row_device['id']]) == 1){
			$has_devices = true;
		}

	}

	if($has_devices == false){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie mindestens 1 Gerät aus!</small><br />\n";
	}

	if(strlen($_POST['message']) > 65536){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Information ein. (max. 65536 Zeichen)</small><br />\n";
		$inp_message = " is-invalid";
	} else {
		$message = strip_tags($_POST['message']);
	}

	if($emsg == ""){

		$result_devices = mysqli_query($conn, "	SELECT 		`order_orders_devices`.`id` AS id, 
															`order_orders_devices`.`device_number` AS device_number 
												FROM 		`order_orders_devices` `order_orders_devices` 
												WHERE 		`order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
												AND 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
												ORDER BY 	`order_orders_devices`.`device_number` ASC");
	
		while($row_device = $result_devices->fetch_array(MYSQLI_ASSOC)){

			if(isset($_POST['device_' . $row_device['id']]) && intval($_POST['device_' . $row_device['id']]) == 1){

				$intern_number = 0;
		
				while($intern_number == 0){
		
					$random = rand(10001, 99999);
		
					$result = mysqli_query($conn, "SELECT * FROM `intern_interns` WHERE `intern_interns`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `intern_interns`.`intern_number`='" . $random . "'");
		
					if($result->num_rows == 0){
						$intern_number = $random;
					}
		
				}

				mysqli_query($conn, "	INSERT 	`intern_interns` 
										SET 	`intern_interns`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
												`intern_interns`.`mode`='0', 
												`intern_interns`.`type`='1', 
												`intern_interns`.`intern_number`='" . mysqli_real_escape_string($conn, $intern_number) . "', 
												`intern_interns`.`creator_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
												`intern_interns`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
												`intern_interns`.`agent_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
												`intern_interns`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
												`intern_interns`.`device_id`='" . mysqli_real_escape_string($conn, intval($row_device['id'])) . "', 
												`intern_interns`.`message`='" . mysqli_real_escape_string($conn, $message) . "', 
												`intern_interns`.`reg_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
												`intern_interns`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

				mysqli_query($conn, "	UPDATE 	`order_orders_devices` 
										SET 	`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
												`order_orders_devices`.`is_photo`='1', 
												`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
										WHERE 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['id'])) . "' 
										AND 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

			}

		}

		$emsg = "<p>Der neue Intern wurde erfolgreich hinzugefügt!</p>\n";

	}

	$_POST['edit'] = "bearbeiten";

?>