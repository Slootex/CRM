<?php 

	mysqli_query($conn, "DELETE FROM	`user_users` 
							WHERE 		`user_users`.`id`='" . mysqli_real_escape_string($conn, intval($row_user['id'])) . "' 
							AND 		`user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "DELETE FROM	`" . $users_table . "_customer_messages` 
							WHERE 		`" . $users_table . "_customer_messages`.`" . $users_id_field . "`='" . mysqli_real_escape_string($conn, intval($row_user['id'])) . "' 
							AND 		`" . $users_table . "_customer_messages`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "DELETE FROM	`" . $users_table . "_emails` 
							WHERE 		`" . $users_table . "_emails`.`" . $users_id_field . "`='" . mysqli_real_escape_string($conn, intval($row_user['id'])) . "' 
							AND 		`" . $users_table . "_emails`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "DELETE FROM	`user_users_events` 
							WHERE 		`user_users_events`.`" . $users_id_field . "`='" . mysqli_real_escape_string($conn, intval($row_user['id'])) . "' 
							AND 		`user_users_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "DELETE FROM	`user_users_files` 
							WHERE 		`user_users_files`.`" . $users_id_field . "`='" . mysqli_real_escape_string($conn, intval($row_user['id'])) . "' 
							AND 		`user_users_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "DELETE FROM	`" . $users_table . "_history` 
							WHERE 		`" . $users_table . "_history`.`" . $users_id_field . "`='" . mysqli_real_escape_string($conn, intval($row_user['id'])) . "' 
							AND 		`" . $users_table . "_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "DELETE FROM	`" . $users_table . "_statuses` 
							WHERE 		`" . $users_table . "_statuses`.`" . $users_id_field . "`='" . mysqli_real_escape_string($conn, intval($row_user['id'])) . "' 
							AND 		`" . $users_table . "_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	array_map('unlink', array_filter((array) glob("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/user/" . $row_user['user_number'] . "/userdata/*.*")));

	array_map('unlink', array_filter((array) glob("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/user/" . $row_user['user_number'] . "/document/*.*")));

	array_map('unlink', array_filter((array) glob("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/user/" . $row_user['user_number'] . "/audio/*.*")));

	@unlink("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/user/" . $row_user['user_number'] . "/userdata/.htaccess");
	@rmdir("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/user/" . $row_user['user_number'] . "/userdata");
	@unlink("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/user/" . $row_user['user_number'] . "/document/.htaccess");
	@rmdir("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/user/" . $row_user['user_number'] . "/document");
	@unlink("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/user/" . $row_user['user_number'] . "/audio/.htaccess");
	@rmdir("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/user/" . $row_user['user_number'] . "/audio");
	@rmdir("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/user/" . $row_user['user_number']);

?>