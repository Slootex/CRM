<?php 

	$time = time();

	if(strlen($_POST['message']) > 65536){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Zusatzbemerkungen ein. (max. 65536 Zeichen)</small><br />\n";
		$inp_message = " is-invalid";
	} else {
		$message = strip_tags($_POST['message']);
	}

	if($emsg == ""){

		mysqli_query($conn, "	UPDATE 	`packing_packings` 
								SET 	`packing_packings`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`packing_packings`.`message`='" . mysqli_real_escape_string($conn, $message) . "', 
										`packing_packings`.`file1`='" . mysqli_real_escape_string($conn, intval(isset($_POST['file1']) ? $_POST['file1'] : 1)) . "', 
										`packing_packings`.`file2`='" . mysqli_real_escape_string($conn, intval(isset($_POST['file2']) ? $_POST['file2'] : 1)) . "' 
								WHERE 	`packing_packings`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
								AND 	`packing_packings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		mysqli_query($conn, "	INSERT 	`" . $packing_table . "_events` 
								SET 	`" . $packing_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`" . $packing_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`" . $packing_table . "_events`.`packing_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`" . $packing_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
										`" . $packing_table . "_events`.`message`='" . mysqli_real_escape_string($conn, $packing_name . ", Packtischdaten geändert, ID [#" . intval($_POST["id"]) . "]") . "', 
										`" . $packing_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, $packing_name . ", Packtischdaten geändert, ID [#" . intval($_POST["id"]) . "]") . "', 
										`" . $packing_table . "_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
										`" . $packing_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$emsg = "<p>Der Packtisch wurde erfolgreich geändert!</p>\n";

	}

	$_POST['edit'] = "bearbeiten";

?>