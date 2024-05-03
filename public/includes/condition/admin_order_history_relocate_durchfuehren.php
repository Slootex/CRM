<?php 

	$time = time();

	$error = "";

	if($emsg == ""){


		$result = mysqli_query($conn, "	SELECT 		`order_orders_devices`.`id` AS id, 
													`order_orders_devices`.`device_number` AS device_number, 
													`order_orders_devices`.`storage_space` AS storage_space, 
													`order_orders_devices`.`storage_space_id` AS storage_space_id 
										FROM 		`order_orders_devices` `order_orders_devices` 
										WHERE 		`order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
										AND 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
										ORDER BY 	`order_orders_devices`.`device_number` ASC");
	
		while($row_device = $result->fetch_array(MYSQLI_ASSOC)){

			if(isset($_POST['storage_space_id_' . $row_device['id']]) && intval($_POST['storage_space_id_' . $row_device['id']]) > 0){

				if(intval($_POST['storage_space_id_' . $row_device['id']]) > 0 && intval($_POST['storage_space_id_' . $row_device['id']]) != $row_device['storage_space_id']){

					$row_storage_place = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['storage_space_id_' . $row_device['id']])) . "'"), MYSQLI_ASSOC);
					if($row_storage_place['used'] < $row_storage_place['parts']){
						if($row_device['storage_space_id'] > 0){
							mysqli_query($conn, "UPDATE `storage_places` SET `storage_places`.`used`=`storage_places`.`used`-1 WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['storage_space_id'])) . "'");
							mysqli_query($conn, "	INSERT 	`order_orders_events` 
													SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
															`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
															`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
															`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
															`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $row_device['device_number'] . ", Daten geändert (Lagerplatz " . $row_device['storage_space'] . " entfernt), ID [#" . intval($_POST["id"]) . "]") . "', 
															`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $row_device['device_number'] . ", Daten geändert (Lagerplatz " . $row_device['storage_space'] . " entfernt), ID [#" . intval($_POST["id"]) . "]") . "', 
															`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
															`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
							mysqli_query($conn, "	INSERT 	`order_orders_devices_events` 
													SET 	`order_orders_devices_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
															`order_orders_devices_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
															`order_orders_devices_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
															`order_orders_devices_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
															`order_orders_devices_events`.`message`='" . mysqli_real_escape_string($conn, "<span class=\"badge badge-danger\">Gerät " . $row_device['device_number'] . ", Lagerplatz " . $row_device['storage_space'] . " entfernt, ID [#" . $row_device['id'] . "]</span>") . "', 
															`order_orders_devices_events`.`subject`='', 
															`order_orders_devices_events`.`body`='', 
															`order_orders_devices_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
						}
						mysqli_query($conn, "UPDATE `storage_places` SET `storage_places`.`used`=`storage_places`.`used`+1 WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['storage_space_id_' . $row_device['id']])) . "'");
						mysqli_query($conn, "	INSERT 	`order_orders_events` 
												SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
														`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
														`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
														`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
														`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $row_device['device_number'] . ", Daten geändert (Lagerplatz hinzugefügt, " . $row_storage_place['name'] . "), ID [#" . intval($_POST["id"]) . "]") . "', 
														`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $row_device['device_number'] . ", Daten geändert (Lagerplatz hinzugefügt, " . $row_storage_place['name'] . "), ID [#" . intval($_POST["id"]) . "]") . "', 
														`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
														`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
							mysqli_query($conn, "	INSERT 	`order_orders_devices_events` 
													SET 	`order_orders_devices_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
															`order_orders_devices_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
															`order_orders_devices_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
															`order_orders_devices_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
															`order_orders_devices_events`.`message`='" . mysqli_real_escape_string($conn, "<span class=\"badge badge-success\">Gerät " . $row_device['device_number'] . ", Lagerplatz " . $row_storage_place['name'] . " hinzugefügt, ID [#" . $row_device['id'] . "]</span>") . "', 
															`order_orders_devices_events`.`subject`='', 
															`order_orders_devices_events`.`body`='', 
															`order_orders_devices_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
						$storage_space = $row_storage_place['name'];
					}else{
						$_POST['storage_space_id_' . $row_device['id']] = 0;
						$error = "<small class=\"error text-muted\">Bitte ein Lagerplatz auswählen bei dem noch nicht die maximale Teileanzahl erreicht wurde.</small><br />\n";
					}
				}elseif(intval($_POST['storage_space_id_' . $row_device['id']]) == 0){
					if($row_device['storage_space_id'] > 0){
						mysqli_query($conn, "UPDATE `storage_places` SET `storage_places`.`used`=`storage_places`.`used`-1 WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['storage_space_id'])) . "'");
						mysqli_query($conn, "	INSERT 	`order_orders_events` 
												SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
														`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
														`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
														`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
														`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $row_device['device_number'] . ", Daten geändert (Lagerplatz " . $row_device['storage_space'] . " entfernt), ID [#" . intval($_POST["id"]) . "]") . "', 
														`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $row_device['device_number'] . ", Daten geändert (Lagerplatz " . $row_device['storage_space'] . " entfernt), ID [#" . intval($_POST["id"]) . "]") . "', 
														`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
														`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
							mysqli_query($conn, "	INSERT 	`order_orders_devices_events` 
													SET 	`order_orders_devices_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
															`order_orders_devices_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
															`order_orders_devices_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
															`order_orders_devices_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
															`order_orders_devices_events`.`message`='" . mysqli_real_escape_string($conn, "<span class=\"badge badge-danger\">Gerät " . $row_device['device_number'] . ", Lagerplatz " . $row_device['storage_space'] . " entfernt, ID [#" . $row_device['id'] . "]</span>") . "', 
															`order_orders_devices_events`.`subject`='', 
															`order_orders_devices_events`.`body`='', 
															`order_orders_devices_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
					}
				}

				if($error == ""){
			
					$row_storage_place = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `storage_places` WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['storage_space_id_' . $row_device['id']])) . "'"), MYSQLI_ASSOC);
			
					mysqli_query($conn, "	UPDATE 	`order_orders_devices` 
											SET 	`order_orders_devices`.`creator_id`='" . mysqli_real_escape_string($conn, intval(isset($_POST['creator_id']) ? $_POST['creator_id'] : 0)) . "', 
													`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
													`order_orders_devices`.`component`='" . mysqli_real_escape_string($conn, $component) . "', 
													`order_orders_devices`.`manufacturer`='" . mysqli_real_escape_string($conn, $manufacturer) . "', 
													`order_orders_devices`.`serial`='" . mysqli_real_escape_string($conn, $serial) . "', 
													`order_orders_devices`.`additional_numbers`='" . mysqli_real_escape_string($conn, $additional_numbers) . "', 
													`order_orders_devices`.`fromthiscar`='" . mysqli_real_escape_string($conn, $fromthiscar) . "', 
													`order_orders_devices`.`open_by_user`='" . mysqli_real_escape_string($conn, $open_by_user) . "', 
													`order_orders_devices`.`info`='" . mysqli_real_escape_string($conn, $info) . "', 
													`order_orders_devices`.`storage_space`='" . mysqli_real_escape_string($conn, strip_tags($row_storage_place['name'])) . "', 
													`order_orders_devices`.`storage_space_id`='" . mysqli_real_escape_string($conn, intval(isset($_POST['storage_space_id_' . $row_device['id']]) ? $_POST['storage_space_id_' . $row_device['id']] : 0)) . "', 
													`order_orders_devices`.`storage_space_owner`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`order_orders_devices`.`storage_space_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
													`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
											WHERE 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['id'])) . "' 
											AND 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");
			
					mysqli_query($conn, "	INSERT 	`order_orders_devices_events` 
											SET 	`order_orders_devices_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
													`order_orders_devices_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`order_orders_devices_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
													`order_orders_devices_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
													`order_orders_devices_events`.`message`='" . mysqli_real_escape_string($conn, "<span class=\"badge badge-warning\">Gerät " . $row_device['device_number'] . " geändert, ID [#" . $row_device['id'] . "]</span>") . "', 
													`order_orders_devices_events`.`subject`='', 
													`order_orders_devices_events`.`body`='', 
													`order_orders_devices_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
			
					mysqli_query($conn, "	INSERT 	`order_orders_events` 
											SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
													`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
													`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
													`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $row_device['device_number'] . " geändert, ID [#" . intval($_POST["id"]) . "]") . "', 
													`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag - Gerät " . $row_device['device_number'] . " geändert, ID [#" . intval($_POST["id"]) . "]") . "', 
													`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
													`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
			
					$emsg .= "<p>Das Gerät wurde erfolgreich geändert!</p>\n";
			
				}else{

					$emsg .= $error;

					$error = "";

				}

			}

		}

	}

	$_POST['edit'] = "bearbeiten";

?>