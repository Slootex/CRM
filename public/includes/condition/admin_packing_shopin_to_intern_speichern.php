<?php 

	$row_shopin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `shopin_shopins` WHERE `shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND  `shopin_shopins`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($row_shopin['order_id'])) . "'"), MYSQLI_ASSOC);

	if(strlen($_POST['message']) > 65536){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Information ein. (max. 65536 Zeichen)</small><br />\n";
		$inp_message = " is-invalid";
	} else {
		$message = strip_tags($_POST['message']);
	}

	if($emsg == ""){

		$time = time();

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
										`intern_interns`.`type`='3', 
										`intern_interns`.`intern_number`='" . mysqli_real_escape_string($conn, $intern_number) . "', 
										`intern_interns`.`creator_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`intern_interns`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`intern_interns`.`agent_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`intern_interns`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_shopin['order_id'])) . "', 
										`intern_interns`.`device_id`='" . mysqli_real_escape_string($conn, intval($row_shopin['device_id'])) . "', 
										`intern_interns`.`help_device_number`='" . mysqli_real_escape_string($conn, intval($row_shopin['help_device_number'])) . "', 
										`intern_interns`.`message`='" . mysqli_real_escape_string($conn, $message) . "', 
										`intern_interns`.`reg_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
										`intern_interns`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		mysqli_query($conn, "	UPDATE 	`shopin_shopins` 
								SET 	`shopin_shopins`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`shopin_shopins`.`mode`='1', 
										`shopin_shopins`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
								WHERE 	`shopin_shopins`.`id`='" . mysqli_real_escape_string($conn, intval($row_shopin['id'])) . "' 
								AND 	`shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		if(file_exists("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/" . $row_shopin['help_device_number'] . ".pdf")){

			@unlink("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/" . $row_shopin['help_device_number'] . ".pdf");

		}

		$files = scandir("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/");

		foreach($files as $k => $filename){

			if($filename != "." && $filename != ".." && $filename != ".htaccess" && $filename != "@eaDir"){

				$order_number = explode("_", $filename);

				if($row_shopin['help_device_number'] == $order_number[0]){

					@unlink("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/scan/" . $filename);

				}

			}

		}

	}

	unset($_POST['id']);

?>