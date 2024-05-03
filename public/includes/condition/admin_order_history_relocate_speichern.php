<?php 

	$time = time();

	if(strlen($_POST['message']) > 65536){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Information ein. (max. 65536 Zeichen)</small><br />\n";
		$inp_message = " is-invalid";
	} else {
		$message = strip_tags($_POST['message']);
	}

	if($emsg == ""){

		$result_devices = mysqli_query($conn, "	SELECT 		`order_orders_devices`.`id` AS id, 
															`order_orders_devices`.`device_number` AS device_number, 
															`order_orders_devices`.`storage_space_id` AS storage_space_id 
												FROM 		`order_orders_devices` `order_orders_devices` 
												WHERE 		`order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
												AND 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
												ORDER BY 	`order_orders_devices`.`device_number` ASC");
	
		while($row_device = $result_devices->fetch_array(MYSQLI_ASSOC)){

			if($row_device['storage_space_id'] != intval($_POST['storage_space_id_' . $row_device['id']])){

				if(isset($_POST['storage_space_id_' . $row_device['id']]) && intval($_POST['storage_space_id_' . $row_device['id']]) > 0){

					$row_storage_place = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['storage_space_id_' . $row_device['id']])) . "'"), MYSQLI_ASSOC);

					if($row_storage_place['used'] < $row_storage_place['parts']){

					}else{

						$emsg .= "<small class=\"error text-muted\">Bitte ein Lagerplatz auswählen bei dem noch nicht die maximale Teileanzahl erreicht wurde.</small><br />\n";

					}

				}
				
			}else{
				
				$emsg .= "<small class=\"error text-muted\">Bitte ein anderen Zielplatz als den aktuellen Lagerplatz auswählen.</small><br />\n";

			}

		}

		if($emsg == ""){

			$result_devices = mysqli_query($conn, "	SELECT 		`order_orders_devices`.`id` AS id, 
																`order_orders_devices`.`device_number` AS device_number, 
																`order_orders_devices`.`storage_space_id` AS storage_space_id 
													FROM 		`order_orders_devices` `order_orders_devices` 
													WHERE 		`order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
													AND 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
													ORDER BY 	`order_orders_devices`.`device_number` ASC");
	
			while($row_device = $result_devices->fetch_array(MYSQLI_ASSOC)){

				$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND  `order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['order_id'])) . "'"), MYSQLI_ASSOC);

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

				if(isset($_POST['storage_space_id_' . $row_device['id']]) && intval($_POST['storage_space_id_' . $row_device['id']]) > 0){

					$row_storage_place = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['storage_space_id_' . $row_device['id']])) . "'"), MYSQLI_ASSOC);
					if($row_storage_place['used'] < $row_storage_place['parts']){
						mysqli_query($conn, "UPDATE `storage_places` SET `storage_places`.`used`=`storage_places`.`used`+1 WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['storage_space_id_' . $row_device['id']])) . "'");
						mysqli_query($conn, "	INSERT 	`" . $order_table . "_events` 
												SET 	`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
														`" . $order_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
														`" . $order_table . "_events`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($row_device['order_id'])) . "', 
														`" . $order_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
														`" . $order_table . "_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $row_device['device_number'] . ", Daten geändert (Umlagern neuer Lagerplatz hinzugefügt, " . $row_storage_place['name'] . "), ID [#" . intval($row_device['id']) . "]") . "', 
														`" . $order_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $row_device['device_number'] . ", Daten geändert (Umlagern neuer Lagerplatz hinzugefügt, " . $row_storage_place['name'] . "), ID [#" . intval($row_device['id']) . "]") . "', 
														`" . $order_table . "_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
														`" . $order_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
							mysqli_query($conn, "	INSERT 	`order_orders_devices_events` 
													SET 	`order_orders_devices_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
															`order_orders_devices_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
															`order_orders_devices_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_device['order_id'])) . "', 
															`order_orders_devices_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
															`order_orders_devices_events`.`message`='" . mysqli_real_escape_string($conn, "<span class=\"badge badge-success\">Gerät " . $row_device['device_number'] . ", Umlagern neuer Lagerplatz " . $row_storage_place['name'] . " hinzugefügt, ID [#" . $row_device['id'] . "]</span>") . "', 
															`order_orders_devices_events`.`subject`='', 
															`order_orders_devices_events`.`body`='', 
															`order_orders_devices_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
						$storage_space = $row_storage_place['name'];

						$intern_number = 0;

						while($intern_number == 0){

							$random = rand(10001, 99999);

							$result = mysqli_query($conn, "SELECT * FROM `intern_interns` WHERE `intern_interns`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `intern_interns`.`intern_number`='" . $random . "'");

							if($result->num_rows == 0){
								$intern_number = $random;
							}

						}

						mysqli_query($conn, "	INSERT 	`intern_interns` 
												SET 	`intern_interns`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
														`intern_interns`.`mode`='0', 
														`intern_interns`.`type`='2', 
														`intern_interns`.`intern_number`='" . mysqli_real_escape_string($conn, $intern_number) . "', 
														`intern_interns`.`creator_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
														`intern_interns`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
														`intern_interns`.`agent_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
														`intern_interns`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
														`intern_interns`.`device_id`='" . mysqli_real_escape_string($conn, intval($row_device['id'])) . "', 
														`intern_interns`.`to_storage_space_id`='" . mysqli_real_escape_string($conn, intval($_POST['storage_space_id_' . $row_device['id']])) . "', 
														`intern_interns`.`message`='" . mysqli_real_escape_string($conn, $message) . "', 
														`intern_interns`.`reg_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
														`intern_interns`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

						mysqli_query($conn, "	UPDATE 	`order_orders_devices` 
												SET 	`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
														`order_orders_devices`.`is_relocate`='1', 
														`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
												WHERE 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['id'])) . "' 
												AND 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

					}else{

						$emsg .= "<small class=\"error text-muted\">Bitte ein Lagerplatz auswählen bei dem noch nicht die maximale Teileanzahl erreicht wurde.</small><br />\n";

					}

				}

			}

		}

		$emsg = $emsg != "" ? $emsg : "<p>Der neue Intern wurde erfolgreich hinzugefügt!</p>\n";

	}

	$_POST['edit'] = "bearbeiten";

?>