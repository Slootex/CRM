<?php 

	$time = time();

	if(strlen($_POST['message']) > 65536){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Information ein. (max. 65536 Zeichen)</small><br />\n";
		$inp_message = " is-invalid";
	} else {
		$message = strip_tags($_POST['message']);
	}

	if($emsg == ""){

		mysqli_query($conn, "	UPDATE 	`intern_interns` 
								SET 	`intern_interns`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`intern_interns`.`message`='" . mysqli_real_escape_string($conn, $message) . "', 
										`intern_interns`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
								WHERE 	`intern_interns`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
								AND 	`intern_interns`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		$emsg = "<p>Die interne Aufgabe wurde erfolgreich geändert!</p>\n";

	}

	$_POST['intern_photo_edit'] = "bearbeiten";

?>