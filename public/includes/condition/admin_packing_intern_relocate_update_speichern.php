<?php 

	$time = time();

	$row_intern = mysqli_fetch_array(mysqli_query($conn, "	SELECT 		`intern_interns`.`id` AS id, 
																		`intern_interns`.`intern_number` AS intern_number, 
																		`intern_interns`.`order_id` AS order_id, 
																		`intern_interns`.`to_storage_space_id` AS to_storage_space_id, 
																		`intern_interns`.`message` AS message, 
																		`order_orders_devices`.`device_number` AS device_number, 
																		`order_orders_devices`.`storage_space_id` AS storage_space_id, 
																		(SELECT `storage_places`.`name` AS s_s_name FROM `storage_places` WHERE `storage_places`.`id`=`order_orders_devices`.`storage_space_id`) AS storage_space, 
																		(SELECT `storage_places`.`name` AS s_s_to_name FROM `storage_places` WHERE `storage_places`.`id`=`intern_interns`.`to_storage_space_id`) AS to_storage_space, 
																		(SELECT `storage_places`.`parts` AS s_s_to_parts FROM `storage_places` WHERE `storage_places`.`id`=`intern_interns`.`to_storage_space_id`) AS to_parts, 
																		(SELECT `storage_places`.`used` AS s_s_to_used FROM `storage_places` WHERE `storage_places`.`id`=`intern_interns`.`to_storage_space_id`) AS to_used 
															FROM 		`intern_interns` 
															LEFT JOIN	`order_orders_devices` 
															ON			`intern_interns`.`device_id`=`order_orders_devices`.`id` 
															WHERE		`intern_interns`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
															AND 		`intern_interns`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	if(strlen($_POST['message']) > 65536){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Information ein. (max. 65536 Zeichen)</small><br />\n";
		$inp_message = " is-invalid";
	} else {
		$message = strip_tags($_POST['message']);
	}

	$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND  `order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($row_intern['order_id'])) . "'"), MYSQLI_ASSOC);

	if(isset($row_order['id']) && $row_order['mode'] < 2){

		$order_name = "Auftrag";

		$order_table = "order_orders";

		$order_id_field = "order_id";

		$status_field = "order_relocate_status";

	}else{

		$order_name = "Interessent";

		$order_table = "interested_interesteds";

		$order_id_field = "interested_id";

		$status_field = "interested_relocate_status";

	}

	$row_storage_place = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['to_storage_space_id'])) . "'"), MYSQLI_ASSOC);

	if($row_storage_place['used'] < $row_storage_place['parts']){

	}else{

		$emsg .= "<small class=\"error text-muted\">Bitte ein Lagerplatz auswählen bei dem noch nicht die maximale Teileanzahl erreicht wurde.</small><br />\n";

	}

	if(intval($_POST['to_storage_space_id']) == 0 || strip_tags($_POST['to_storage_space_id']) == ""){
		
		$emsg .= "<small class=\"error text-muted\">Bitte ein freien Zielplatz auswählen.</small><br />\n";

	}

	if(intval($_POST['to_storage_space_id']) == intval($row_intern['storage_space_id'])){
		
		$emsg .= "<small class=\"error text-muted\">Bitte ein anderen Zielplatz als den aktuellen Lagerplatz auswählen.</small><br />\n";

	}

	if($emsg == ""){

		mysqli_query($conn, "	UPDATE 	`intern_interns` 
								SET 	`intern_interns`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`intern_interns`.`to_storage_space_id`='" . mysqli_real_escape_string($conn, intval($_POST['to_storage_space_id'])) . "', 
										`intern_interns`.`message`='" . mysqli_real_escape_string($conn, $message) . "', 
										`intern_interns`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
								WHERE 	`intern_interns`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
								AND 	`intern_interns`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		mysqli_query($conn, "UPDATE `storage_places` SET `storage_places`.`used`=`storage_places`.`used`-1 WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_intern['to_storage_space_id'])) . "'");

		mysqli_query($conn, "UPDATE `storage_places` SET `storage_places`.`used`=`storage_places`.`used`+1 WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['to_storage_space_id'])) . "'");

		mysqli_query($conn, "	INSERT 	`" . $order_table . "_events` 
								SET 	`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`" . $order_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`" . $order_table . "_events`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($row_intern['order_id'])) . "', 
										`" . $order_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
										`" . $order_table . "_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $row_intern['device_number'] . ", Daten geändert (Umlagern Zielplatz von " . $row_intern['storage_space'] . " auf " . $row_storage_place['name'] . " geändert), ID [#" . intval($row_intern['device_id']) . "]") . "', 
										`" . $order_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $row_intern['device_number'] . ", Daten geändert (Umlagern Zielplatz von " . $row_intern['storage_space'] . " auf " . $row_storage_place['name'] . " geändert), ID [#" . intval($row_intern['device_id']) . "]") . "', 
										`" . $order_table . "_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
										`" . $order_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		mysqli_query($conn, "	INSERT 	`order_orders_devices_events` 
								SET 	`order_orders_devices_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`order_orders_devices_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`order_orders_devices_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_intern['order_id'])) . "', 
										`order_orders_devices_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
										`order_orders_devices_events`.`message`='" . mysqli_real_escape_string($conn, "<span class=\"badge badge-danger\">Gerät " . $row_intern['device_number'] . ", Umlagern Zielplatz von " . $row_intern['storage_space'] . " auf " . $row_storage_place['name'] . " geändert, ID [#" . $row_intern['device_id'] . "]</span>") . "', 
										`order_orders_devices_events`.`subject`='', 
										`order_orders_devices_events`.`body`='', 
										`order_orders_devices_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$emsg = "<p>Die interne Aufgabe wurde erfolgreich geändert!</p>\n";

	}

	$_POST['intern_relocate_edit'] = "bearbeiten";

?>