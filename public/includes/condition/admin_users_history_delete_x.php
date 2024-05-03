<?php 

	$time = time();

	mysqli_query($conn, "DELETE FROM 	`" . $users_table . "_history` 
								WHERE 	`" . $users_table . "_history`.`id`='" . intval($_POST['history_id']) . "' 
								AND 	`" . $users_table . "_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "INSERT 	`user_users_events` 
							SET 	`user_users_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
									`user_users_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
									`user_users_events`.`" . $users_id_field . "`='" . mysqli_real_escape_string($conn, $_POST['id']) . "', 
									`user_users_events`.`type`='" . mysqli_real_escape_string($conn, 2) . "', 
									`user_users_events`.`message`='" . mysqli_real_escape_string($conn, $users_name . ", Historie, Nachricht entfernt, ID [#" . intval($_POST['history_id']) . "]") . "', 
									`user_users_events`.`subject`='" . mysqli_real_escape_string($conn, $users_name . ", Historie, Nachricht entfernt, ID [#" . intval($_POST['history_id']) . "]") . "', 
									`user_users_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
									`user_users_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

	$_POST['edit'] = "bearbeiten";

?>