<?php 

	if(strlen($_POST['message']) < 1 || strlen($_POST['message']) > 65536){
		$emsg .= "<small class=\"error text-muted\">Bitte eine Nachricht eingeben. (max. 65536 Zeichen)</small><br />\n";
		$inp_message = " is-invalid";
	} else {
		$message = $_POST['message'];
	}

	if($emsg == ""){

		$time = time();

		mysqli_query($conn, "INSERT 	`" . $users_table . "_customer_messages` 
								SET 	`" . $users_table . "_customer_messages`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`" . $users_table . "_customer_messages`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`" . $users_table . "_customer_messages`.`" . $users_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
										`" . $users_table . "_customer_messages`.`message`='" . mysqli_real_escape_string($conn, $message) . "', 
										`" . $users_table . "_customer_messages`.`time`='" . $time . "'");

		$_SESSION["customer_messages"]["id"] = $conn->insert_id;

		mysqli_query($conn, "INSERT 	`user_users_events` 
								SET 	`user_users_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`user_users_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`user_users_events`.`" . $users_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`user_users_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
										`user_users_events`.`message`='" . mysqli_real_escape_string($conn, $users_name . ", Kundenhistory, Nachricht erstellt, ID [#" . $_SESSION["customer_messages"]["id"] . "]") . "', 
										`user_users_events`.`subject`='" . mysqli_real_escape_string($conn, $users_name . ", Kundenhistory, Nachricht erstellt, ID [#" . $_SESSION["customer_messages"]["id"] . "]") . "', 
										`user_users_events`.`body`='" . mysqli_real_escape_string($conn, $message) . "', 
										`user_users_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

	}

	$_POST['edit'] = "bearbeiten";

?>