<?php 

	if(strlen($_POST['intern_allocation']) < 1 || strlen($_POST['intern_allocation']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte eine Zuteilung wählen.</small><br />\n";
		$inp_intern_allocation = " is-invalid";
	} else {
		$intern_allocation = intval($_POST['intern_allocation']);
	}

	if(strlen($_POST['intern_info']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den internen Hinweis an. (max. 256 Zeichen)</small><br />\n";
		$inp_intern_info = " is-invalid";
	} else {
		$intern_info = strip_tags($_POST['intern_info']);
	}

	if($emsg == ""){

		$time = time();

		$row_addresses = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `address_addresses` WHERE `address_addresses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `address_addresses`.`id`='" . $intern_allocation . "'"), MYSQLI_ASSOC);

		mysqli_query($conn, "	UPDATE	`order_orders` 
								SET 	`order_orders`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`order_orders`.`intern_allocation`='" . mysqli_real_escape_string($conn, $intern_allocation) . "', 
										`order_orders`.`intern_info`='" . mysqli_real_escape_string($conn, $intern_info) . "', 
										`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
								WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
								AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		mysqli_query($conn, "	INSERT 	`" . $order_table . "_history` 
								SET 	`" . $order_table . "_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`" . $order_table . "_history`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`" . $order_table . "_history`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
										`" . $order_table . "_history`.`message`='" . mysqli_real_escape_string($conn, "Zuteilung: " . $row_addresses['shortcut']) . ($intern_info != "" ? mysqli_real_escape_string($conn, ", Hinweis: " . $intern_info) : "") . "', 
										`" . $order_table . "_history`.`status`='1', 
										`" . $order_table . "_history`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$_SESSION["history"]["id"] = $conn->insert_id;

		mysqli_query($conn, "	INSERT 	`" . $order_table . "_events` 
								SET 	`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`" . $order_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`" . $order_table . "_events`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`" . $order_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
										`" . $order_table . "_events`.`message`='" . mysqli_real_escape_string($conn, $order_name . "-history, Nachricht erstellt, ID [#" . $_SESSION["history"]["id"] . "]") . "', 
										`" . $order_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, $order_name . "-history, Nachricht erstellt, ID [#" . $_SESSION["history"]["id"] . "]") . "', 
										`" . $order_table . "_events`.`body`='" . mysqli_real_escape_string($conn, $message) . "', 
										`" . $order_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$_POST['intern'] = "speichern";

	}

	$_POST['edit'] = "bearbeiten";

?>