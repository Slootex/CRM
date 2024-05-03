<?php 

	if(strlen($_POST['message']) > 65536){
		$emsg .= "<small class=\"error text-muted\">Bitte eine Nachricht eingeben. (max. 65536 Zeichen)</small><br />\n";
		$inp_message = " is-invalid";
	} else {
		$message = preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~", "<a href=\"\\0\" target=\"_blank\">Link öffnen</a>", $_POST['message']);
	}

	if($emsg == ""){

		$time = time();

		$script_paste = "";

		$result_devices = mysqli_query($conn, "	SELECT 		`order_orders_devices`.`id` AS id, 
															`order_orders_devices`.`device_number` AS device_number 
												FROM 		`order_orders_devices` `order_orders_devices` 
												WHERE 		`order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
												AND 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
												ORDER BY 	`order_orders_devices`.`device_number` ASC");
	
		while($row_device = $result_devices->fetch_array(MYSQLI_ASSOC)){

			if(isset($_POST['storage_space_id_' . $row_device['id']]) && intval($_POST['storage_space_id_' . $row_device['id']]) > 0){

				$script_paste .= "document.getElementById('storage_space_id_" . $row_device['id'] . "').value=" . intval($_POST['storage_space_id_' . $row_device['id']]) . ";\n";

			}

		}

		$script_paste .= "document.getElementById('message').value='" . str_replace("\r\n", " ", $message) . "';\n";

		mysqli_query($conn, "	UPDATE	`order_orders` 
								SET 	`order_orders`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
								WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
								AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		mysqli_query($conn, "	INSERT 	`" . $order_table . "_history` 
								SET 	`" . $order_table . "_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`" . $order_table . "_history`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`" . $order_table . "_history`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
										`" . $order_table . "_history`.`type`='2', 
										`" . $order_table . "_history`.`message`='" . mysqli_real_escape_string($conn, $message) . "', 
										`" . $order_table . "_history`.`script`='" . mysqli_real_escape_string($conn, $script_paste) . "', 
										`" . $order_table . "_history`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$_SESSION["history"]["id"] = $conn->insert_id;

		mysqli_query($conn, "	INSERT 	`" . $order_table . "_events` 
								SET 	`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`" . $order_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`" . $order_table . "_events`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`" . $order_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
										`" . $order_table . "_events`.`message`='" . mysqli_real_escape_string($conn, $order_name . "-Auftragshistory, Nachricht erstellt, ID [#" . $_SESSION["history"]["id"] . "]") . "', 
										`" . $order_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, $order_name . "-Auftragshistory, Nachricht erstellt, ID [#" . $_SESSION["history"]["id"] . "]") . "', 
										`" . $order_table . "_events`.`body`='" . mysqli_real_escape_string($conn, $message) . "', 
										`" . $order_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

	}

	$_POST['edit'] = "bearbeiten";

?>