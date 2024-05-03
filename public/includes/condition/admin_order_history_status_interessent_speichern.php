<?php 

	switch(strip_tags($_POST['history_status_interessent'])){
		case "speichern_0":
			$_POST['status'] = 0;
			break;
		case "speichern_1":
			$_POST['status'] = 1;
			break;
		case "speichern_2":
			$_POST['status'] = 2;
			break;
	}

	$time = time();

	$row_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "'"), MYSQLI_ASSOC);

	mysqli_query($conn, "	UPDATE	`order_orders` 
							SET 	`order_orders`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
									`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
							WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	if(intval($_POST['status']) == 2){
		mysqli_query($conn, "	UPDATE 	`" . $order_table . "_history` 
								SET 	`" . $order_table . "_history`.`status`='" . mysqli_real_escape_string($conn, intval($_POST['status'])) . "', 
										`" . $order_table . "_history`.`message`=CONCAT(`interested_interesteds_history`.`message`, ' - Erledigt durch: " . mysqli_real_escape_string($conn, $row_admin['name']) . " (" . date("d.m.Y - H:i", time()) . ")') 
								WHERE 	`" . $order_table . "_history`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['history_id'])) . "' 
								AND 	`" . $order_table . "_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");
	}else{
		mysqli_query($conn, "	UPDATE 	`" . $order_table . "_history` 
								SET 	`" . $order_table . "_history`.`status`='" . mysqli_real_escape_string($conn, intval($_POST['status'])) . "' 
								WHERE 	`" . $order_table . "_history`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['history_id'])) . "' 
								AND 	`" . $order_table . "_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");
	}

	mysqli_query($conn, "	INSERT 	`" . $order_table . "_events` 
							SET 	`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
									`" . $order_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
									`" . $order_table . "_events`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
									`" . $order_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
									`" . $order_table . "_events`.`message`='" . mysqli_real_escape_string($conn, $order_name . "-Auftragshistorie, Nachricht, Status geändert, ID [#" . intval($_POST['history_id']) . "]") . "', 
									`" . $order_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, $order_name . "-Auftragshistorie, Nachricht, Status geändert, ID [#" . intval($_POST['history_id']) . "]") . "', 
									`" . $order_table . "_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
									`" . $order_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

	$_POST['edit'] = "bearbeiten";

?>