<?php 

	$time = time();

	$files = "";

	$arr_files = explode("\r\n", $row_user['userdata']);

	$file_id = 0;
	$file_name = "";

	for($i = 0;$i < count($arr_files);$i++){
		if($i == intval($_POST['item'])){
			@unlink("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/user/" . $row_user['user_number'] . "/userdata/" . $arr_files[$i]);
			$file_id = ($i + 1);
			$file_name = $arr_files[$i];
		}else{
			$files .= $files == "" ? $arr_files[$i] : "\r\n" . $arr_files[$i];
		}
	}

	mysqli_query($conn, "UPDATE 	`user_users` 
							SET 	`user_users`.`userdata`='" . mysqli_real_escape_string($conn, $files) . "' 
							WHERE 	`user_users`.`id`='" . intval($_POST['id']) . "' 
							AND 	`user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "INSERT 	`user_users_events` 
							SET 	`user_users_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
									`user_users_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
									`user_users_events`.`" . $users_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
									`user_users_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
									`user_users_events`.`message`='" . mysqli_real_escape_string($conn, $users_name . ", Dateien, Datei entfernt, ID [#" . $file_id . "]") . "', 
									`user_users_events`.`subject`='" . mysqli_real_escape_string($conn, $users_name . ", Dateien, Datei entfernt, ID [#" . $file_id . "]") . "', 
									`user_users_events`.`body`='" . mysqli_real_escape_string($conn, "Name [" . $file_name . "]") . "', 
									`user_users_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

	$_POST['edit'] = "bearbeiten";

?>