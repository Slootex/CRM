<?php 

	$time = time();

	mysqli_query($conn, "UPDATE		`user_users` 
							SET 	`user_users`.`mode`='" . mysqli_real_escape_string($conn, intval($users_archiv_mode)) . "' 
							WHERE 	`user_users`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 	`user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "INSERT 	`user_users_events` 
							SET 	`user_users_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
									`user_users_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
									`user_users_events`.`" . $users_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
									`user_users_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
									`user_users_events`.`message`='" . mysqli_real_escape_string($conn, $users_name . ", ins Archiv verschoben, ID [#" . intval($_POST["id"]) . "]") . "', 
									`user_users_events`.`subject`='" . mysqli_real_escape_string($conn, $users_name . ", ins Archiv verschoben, ID [#" . intval($_POST["id"]) . "]") . "', 
									`user_users_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
									`user_users_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

?>