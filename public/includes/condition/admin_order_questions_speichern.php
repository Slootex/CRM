<?php 

	$time = time();

	if(strlen($_POST['user_ip']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte die Kunden-IP-Adresse eingeben. (max. 256 Zeichen)</small><br />\n";
		$inp_user_ip = " is-invalid";
	} else {
		$user_ip = strip_tags($_POST['user_ip']);
	}

	if(strlen($_POST['component']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte das defekte Bauteil auswählen. (max. 256 Zeichen)</small><br />\n";
		$inp_component = " is-invalid";
	} else {
		$component = intval($_POST['component']);
	}

	if(strlen($_POST['reason']) > 700){
		$emsg .= "<small class=\"error text-muted\">Bitte die Fehlerursache/welche Funktionen gehen nicht eingeben. (max. 700 Zeichen)</small><br />\n";
		$inp_reason = " is-invalid";
	} else {
		$reason = str_replace("\r\n", " - ", strip_tags($_POST['reason']));
	}

	if(strlen($_POST['description']) > 700){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein was am Fahrzeug bereits gemacht wurde. (max. 700 Zeichen)</small><br />\n";
		$inp_description = " is-invalid";
	} else {
		$description = str_replace("\r\n", " - ", strip_tags($_POST['description']));
	}

	if($emsg == ""){

		mysqli_query($conn, "	DELETE FROM 	`order_orders_questions` 
								WHERE 			`order_orders_questions`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								AND 			`order_orders_questions`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

		$result_pq = mysqli_query($conn, "	SELECT 		* 
											FROM 		`questions` 
											WHERE 		`questions`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
											AND 		`questions`.`parent_id`='0' 
											AND 		`questions`.`category_id`='1' 
											AND 		`questions`.`enable`='1' 
											ORDER BY 	CAST(`questions`.`pos` AS UNSIGNED) ASC");

		while($row_pq = $result_pq->fetch_array(MYSQLI_ASSOC)){

			mysqli_query($conn, "	INSERT 	`order_orders_questions` 
									SET 	`order_orders_questions`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
											`order_orders_questions`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
											`order_orders_questions`.`question_id`='" . mysqli_real_escape_string($conn, intval($row_pq['id'])) . "', 
											`order_orders_questions`.`answer_id`='" . mysqli_real_escape_string($conn, intval($_POST['q_' . $row_pq['id']])) . "'");

		}

		mysqli_query($conn, "	UPDATE 	`order_orders` 
								SET 	`order_orders`.`user_ip`='" . mysqli_real_escape_string($conn, $user_ip) . "', 
										`order_orders`.`component`='" . mysqli_real_escape_string($conn, $component) . "', 
										`order_orders`.`reason`='" . mysqli_real_escape_string($conn, $reason) . "', 
										`order_orders`.`description`='" . mysqli_real_escape_string($conn, $description) . "', 
										`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
								WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
								AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		mysqli_query($conn, "	INSERT 	`" . $order_table . "_events` 
								SET 	`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`" . $order_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`" . $order_table . "_events`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`" . $order_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
										`" . $order_table . "_events`.`message`='" . mysqli_real_escape_string($conn, $order_name . ", Fragen geändert, ID [#" . intval($_POST["id"]) . "]") . "', 
										`" . $order_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, $order_name . ", Fragen geändert, ID [#" . intval($_POST["id"]) . "]") . "', 
										`" . $order_table . "_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
										`" . $order_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$emsg = "<p>Der " . $order_name . " wurde erfolgreich geändert!</p>\n";

	}

	$_POST['edit'] = "bearbeiten";

?>