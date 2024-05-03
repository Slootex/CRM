<?php 

	require_once('includes/class_dbbmailer.php');

	use setasign\Fpdi\Fpdi;

	require_once('includes/fpdf/fpdf.php');
	require_once('includes/fpdi/code39.php');
	require_once('includes/fpdi/autoload.php');

	@session_start();

	$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

	$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

	$time = time();

	$code = "";

	if(isset($_POST['order_number']) && $_POST['order_number'] != ""){

		if(preg_match("/^([10000-99999]{5})([\-]{1})([11-99]{2})([\-]{1})(AT)([\-]{1})([1-9]{1})$/", $_POST['order_number'], $matches)){

			$arr_number = explode("-", $_POST['order_number']);

			$row_shopin = mysqli_fetch_array(mysqli_query($conn, "	SELECT		`shopin_shopins`.`id` AS id, 
																				`shopin_shopins`.`type` AS type 
																	FROM		`shopin_shopins` 
																	LEFT JOIN	`order_orders_devices` 
																	ON			`shopin_shopins`.`device_id`=`order_orders_devices`.`id` 
																	WHERE		`shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																	AND 		`shopin_shopins`.`mode`='0' 
																	AND 		`shopin_shopins`.`order_id`=`order_orders_devices`.`order_id` 
																	AND 		`shopin_shopins`.`order_id`>0 
																	AND 		`order_orders_devices`.`device_number`='" . mysqli_real_escape_string($conn, strip_tags($arr_number[0] . "-" . $arr_number[1])) . "' 
																	AND 		`order_orders_devices`.`atot_mode`='1' 
																	AND 		`order_orders_devices`.`at`='" . mysqli_real_escape_string($conn, intval($arr_number[3])) . "'"), MYSQLI_ASSOC);

			$row_device = mysqli_fetch_array(mysqli_query($conn, "	SELECT		* 
																	FROM		`order_orders_devices` 
																	WHERE		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																	AND 		`order_orders_devices`.`device_number`='" . mysqli_real_escape_string($conn, strip_tags($arr_number[0] . "-" . $arr_number[1])) . "' 
																	AND 		`order_orders_devices`.`atot_mode`='1' 
																	AND 		`order_orders_devices`.`at`='" . mysqli_real_escape_string($conn, intval($arr_number[3])) . "'"), MYSQLI_ASSOC);

			if(isset($row_shopin['id']) && intval($row_shopin['id']) > 0){

				$_POST['id'] = $row_shopin['id'];

				if($row_shopin['type'] == 0){

					$code = "screen_storage";

				}

				if($row_shopin['type'] == 4){

					$code = "screen_storage_complete";

				}

				if($row_shopin['type'] == 5){

					$code = "screen_relocate_next";

				}

				if($row_shopin['type'] == 6){

					$code = "screen_relocate_complete";

				}

			}elseif(isset($row_device['id']) && intval($row_device['id']) > 0){

				if($row_device['is_storage'] == 0 && $row_device['is_next_storage'] == 0 && $row_device['is_shopin_relocate'] == 0 && $row_device['is_labeling'] == 0 && $row_device['is_photo'] == 0 && $row_device['is_shipping_user'] == 0 && $row_device['is_shipping_technic'] == 0 && $row_device['is_shipping_extern'] == 0 && $row_device['is_relocate'] == 0){

					if($row_device['storage_space_id'] > 0){

						$code = "screen_relocate";

					}else{

						$code = "screen_next_storage";

					}

				}else{

					$code = "screen_used";

				}

			}else{

				$_POST['order_number'] = $arr_number[0];

				$row_order = mysqli_fetch_array(mysqli_query($conn, "	SELECT 	* 
																		FROM	`order_orders` 
																		WHERE	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																		AND 	`order_orders`.`order_number`='" . mysqli_real_escape_string($conn, strip_tags($_POST['order_number'])) . "'"), MYSQLI_ASSOC);

				if(isset($row_order['id']) && intval($row_order['id']) > 0){

					$code = "new_device_to_order";

				}else{

					$code = "help_device";

				}

			}

		}else{

			if(preg_match("/^([10000-99999]{5})([\-]{1})([11-99]{2})([\-]{1})(ORG)([\-]{1})([1-9]{1})$/", $_POST['order_number'], $matches)){

				$arr_number = explode("-", $_POST['order_number']);

				$row_shopin = mysqli_fetch_array(mysqli_query($conn, "	SELECT		`shopin_shopins`.`id` AS id, 
																					`shopin_shopins`.`type` AS type 
																		FROM		`shopin_shopins` 
																		LEFT JOIN	`order_orders_devices` 
																		ON			`shopin_shopins`.`device_id`=`order_orders_devices`.`id` 
																		WHERE		`shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																		AND 		`shopin_shopins`.`mode`='0' 
																		AND 		`shopin_shopins`.`order_id`=`order_orders_devices`.`order_id` 
																		AND 		`shopin_shopins`.`order_id`>0 
																		AND 		`order_orders_devices`.`device_number`='" . mysqli_real_escape_string($conn, strip_tags($arr_number[0] . "-" . $arr_number[1])) . "' 
																		AND 		`order_orders_devices`.`atot_mode`='2' 
																		AND 		`order_orders_devices`.`ot`='" . mysqli_real_escape_string($conn, intval($arr_number[3])) . "'"), MYSQLI_ASSOC);

				$row_device = mysqli_fetch_array(mysqli_query($conn, "	SELECT		* 
																		FROM		`order_orders_devices` 
																		WHERE		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																		AND 		`order_orders_devices`.`device_number`='" . mysqli_real_escape_string($conn, strip_tags($arr_number[0] . "-" . $arr_number[1])) . "' 
																		AND 		`order_orders_devices`.`atot_mode`='2' 
																		AND 		`order_orders_devices`.`ot`='" . mysqli_real_escape_string($conn, intval($arr_number[3])) . "'"), MYSQLI_ASSOC);

				if(isset($row_shopin['id']) && intval($row_shopin['id']) > 0){

					$_POST['id'] = $row_shopin['id'];

					if($row_shopin['type'] == 0){

						$code = "screen_storage";

					}

					if($row_shopin['type'] == 4){

						$code = "screen_storage_complete";

					}

					if($row_shopin['type'] == 5){

						$code = "screen_relocate_next";

					}

					if($row_shopin['type'] == 6){

						$code = "screen_relocate_complete";

					}

				}elseif(isset($row_device['id']) && intval($row_device['id']) > 0){

					if($row_device['is_storage'] == 0 && $row_device['is_next_storage'] == 0 && $row_device['is_shopin_relocate'] == 0 && $row_device['is_labeling'] == 0 && $row_device['is_photo'] == 0 && $row_device['is_shipping_user'] == 0 && $row_device['is_shipping_technic'] == 0 && $row_device['is_shipping_extern'] == 0 && $row_device['is_relocate'] == 0){

						if($row_device['storage_space_id'] > 0){

							$code = "screen_relocate";

						}else{

							$code = "screen_next_storage";

						}

					}else{

						$code = "screen_used";

					}

				}else{

					$_POST['order_number'] = $arr_number[0];

					$row_order = mysqli_fetch_array(mysqli_query($conn, "	SELECT 	* 
																			FROM	`order_orders` 
																			WHERE	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																			AND 	`order_orders`.`order_number`='" . mysqli_real_escape_string($conn, strip_tags($_POST['order_number'])) . "'"), MYSQLI_ASSOC);

					if(isset($row_order['id']) && intval($row_order['id']) > 0){

						$code = "new_device_to_order";

					}else{

						$code = "help_device";

					}

				}

			}else{

				if(preg_match("/^([10000-99999]{5})$/", $_POST['order_number'], $matches)){

					$row_order = mysqli_fetch_array(mysqli_query($conn, "	SELECT 	* 
																			FROM	`order_orders` 
																			WHERE	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																			AND 	`order_orders`.`order_number`='" . mysqli_real_escape_string($conn, strip_tags($_POST['order_number'])) . "'"), MYSQLI_ASSOC);

					if(isset($row_order['id']) && intval($row_order['id']) > 0){

						$code = "new_device_to_order";

					}else{

						$code = "help_device";

					}

				}else{

					$code = "help_device";

				}

			}

		}

	}else{

		$code = "help_device";

	}

	switch($code){

		case "screen_storage": 

			$_POST['shopin_add_device'] = "hinzufügen";

			break;

		case "screen_storage_complete": 

			$_POST['shopin_add_device'] = "complete";

			break;

		case "screen_next_storage": 

			$row_order = mysqli_fetch_array(mysqli_query($conn, "	SELECT 	* 
																	FROM	`order_orders` 
																	WHERE	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																	AND 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, strip_tags($row_device['order_id'])) . "'"), MYSQLI_ASSOC);

			$shopin_number = 0;

			while($shopin_number == 0){

				$random = rand(10001, 99999);

				$result = mysqli_query($conn, "SELECT * FROM `shopin_shopins` WHERE `shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `shopin_shopins`.`shopin_number`='" . $random . "'");

				if($result->num_rows == 0){

					$shopin_number = $random;

				}

			}

			$result = mysqli_query($conn, "	SELECT 		`storage_places`.`id` AS id, 
														`storage_places`.`name` AS name, 
														`storage_places`.`parts` AS parts, 
														`storage_places`.`used` AS used 
											FROM 		`storage_places` 
											LEFT JOIN	`storage_rooms` 
											ON			`storage_places`.`room_id`=`storage_rooms`.`id` 
											WHERE 		`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
											AND 		`storage_rooms`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
											ORDER BY 	CAST(`storage_rooms`.`pos` AS UNSIGNED) ASC, CAST(`storage_places`.`pos` AS UNSIGNED) ASC");

			$storage_space = "";

			$storage_space_id = 0;

			while($row_storage_place = $result->fetch_array(MYSQLI_ASSOC)){

				if($row_storage_place['used'] < $row_storage_place['parts']){

					$storage_space = $row_storage_place['name'];

					$storage_space_id = $row_storage_place['id'];

					mysqli_query($conn, "UPDATE `storage_places` SET `storage_places`.`used`=`storage_places`.`used`+1 WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_storage_place['id'])) . "'");

					break;

				}

			}

			if($storage_space != ""){

				mysqli_query($conn, "	UPDATE 	`order_orders_devices` 
										SET 	`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
												`order_orders_devices`.`storage_space_id`='" . mysqli_real_escape_string($conn, intval($storage_space_id)) . "', 
												`order_orders_devices`.`is_next_storage`='1', 
												`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
										WHERE 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['id'])) . "' 
										AND 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

				mysqli_query($conn, "	INSERT 	`shopin_shopins` 
										SET 	`shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
												`shopin_shopins`.`mode`='0', 
												`shopin_shopins`.`type`='7', 
												`shopin_shopins`.`shopin_number`='" . mysqli_real_escape_string($conn, strip_tags($shopin_number)) . "', 
												`shopin_shopins`.`order_number`='" . mysqli_real_escape_string($conn, strip_tags($row_order['order_number'])) . "', 
												`shopin_shopins`.`creator_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
												`shopin_shopins`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
												`shopin_shopins`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_device['order_id'])) . "', 
												`shopin_shopins`.`device_id`='" . mysqli_real_escape_string($conn, intval($row_device["id"])) . "', 
												`shopin_shopins`.`storage_space_id`='" . mysqli_real_escape_string($conn, intval($storage_space_id)) . "', 
												`shopin_shopins`.`old_storage_space_id`='" . mysqli_real_escape_string($conn, intval($row_device['storage_space_id'])) . "', 
												`shopin_shopins`.`description`='" . mysqli_real_escape_string($conn, strip_tags("Gerät ohne Lagerplatz im Auftrag gefunden!")) . "', 
												`shopin_shopins`.`reg_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
												`shopin_shopins`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

				$_POST["id"] = $conn->insert_id;

				$_POST['shopin_next_storage'] = "hinzufügen";

			}else{

				$_POST['shopin_storage_space_id'] = "empty";

			}

			break;

		case "new_device_to_order": 

			$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`order_number`='" . mysqli_real_escape_string($conn, strip_tags($_POST['order_number'])) . "'"), MYSQLI_ASSOC);

			if(isset($row_order['id']) && $row_order['mode'] < 2){

				$order_name = "Auftrag";

				$order_table = "order_orders";

				$order_id_field = "order_id";

				$status_field = "order_new_device_status";

			}else{

				$order_name = "Interessent";

				$order_table = "interested_interesteds";

				$order_id_field = "interested_id";

				$status_field = "interested_new_device_status";

			}

			if(isset($row_order['id']) && intval($row_order['id']) > 0){

				$result = mysqli_query($conn, "	SELECT 		`storage_places`.`id` AS id, 
															`storage_places`.`name` AS name, 
															`storage_places`.`parts` AS parts, 
															`storage_places`.`used` AS used 
												FROM 		`storage_places` 
												LEFT JOIN	`storage_rooms` 
												ON			`storage_places`.`room_id`=`storage_rooms`.`id` 
												WHERE 		`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
												AND 		`storage_rooms`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
												ORDER BY 	CAST(`storage_rooms`.`pos` AS UNSIGNED) ASC, CAST(`storage_places`.`pos` AS UNSIGNED) ASC");

				$storage_space = "";

				$storage_space_id = 0;

				while($row_storage_place = $result->fetch_array(MYSQLI_ASSOC)){

					if($row_storage_place['used'] < $row_storage_place['parts']){

						$storage_space = $row_storage_place['name'];

						$storage_space_id = $row_storage_place['id'];

						break;

					}

				}

				if($storage_space != ""){

					mysqli_query($conn, "UPDATE `storage_places` SET `storage_places`.`used`=`storage_places`.`used`+1 WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($storage_space_id)) . "'");

					mysqli_query($conn, "	INSERT 	`" . $order_table . "_events` 
											SET 	`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
													`" . $order_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`" . $order_table . "_events`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "', 
													`" . $order_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
													`" . $order_table . "_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag - Neues Gerät, Lagerplatz " . $storage_space . " hinzugefügt") . "', 
													`" . $order_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag - Neues Gerät, Lagerplatz " . $storage_space . " hinzugefügt") . "', 
													`" . $order_table . "_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
													`" . $order_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

					mysqli_query($conn, "	INSERT 	`order_orders_devices_events` 
											SET 	`order_orders_devices_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
													`order_orders_devices_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`order_orders_devices_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "', 
													`order_orders_devices_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
													`order_orders_devices_events`.`message`='" . mysqli_real_escape_string($conn, "<span class=\"badge badge-success\">Neues Gerät, Lagerplatz " . $storage_space . " hinzugefügt</span>") . "', 
													`order_orders_devices_events`.`subject`='', 
													`order_orders_devices_events`.`body`='', 
													`order_orders_devices_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

					$device_number = $row_order['order_number'];

					for($i = 11;$i < 100;$i++){

						$number = $device_number . "-" . $i;

						$result = mysqli_query($conn, "SELECT * FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`device_number`='" . $number . "'");

						if($result->num_rows == 0){

							$device_number = $number;

							break;

						}

					}

					$atot_mode = 0;

					$at = 0;

					$ot = 0;

					if(isset($_POST['atot_mode'])){

						if(intval($_POST['atot_mode']) == 1){

							$atot_mode = 1;

							$at = 0;

							for($i = 1;$i < 100;$i++){

								$row_device = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' AND `order_orders_devices`.`atot_mode`='1' AND `order_orders_devices`.`at`='" . mysqli_real_escape_string($conn, intval($i)) . "'"), MYSQLI_ASSOC);

								if(!isset($row_device['id'])){
									$at = $i;
									break;
								}

							}

						}

						if(intval($_POST['atot_mode']) == 2){

							$atot_mode = 2;

							$ot = 0;

							for($i = 1;$i < 100;$i++){

								$row_device = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' AND `order_orders_devices`.`atot_mode`='2' AND `order_orders_devices`.`ot`='" . mysqli_real_escape_string($conn, intval($i)) . "'"), MYSQLI_ASSOC);

								if(!isset($row_device['id'])){
									$ot = $i;
									break;
								}

							}

						}

					}

					$row_devices_count = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS c FROM `order_orders_devices` WHERE `order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "'"), MYSQLI_ASSOC);

					mysqli_query($conn, "	INSERT 	`order_orders_devices` 
											SET 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
													`order_orders_devices`.`creator_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "', 
													`order_orders_devices`.`device_number`='" . mysqli_real_escape_string($conn, strip_tags($device_number)) . "', 
													`order_orders_devices`.`atot_mode`='" . mysqli_real_escape_string($conn, intval($atot_mode)) . "', 
													`order_orders_devices`.`at`='" . mysqli_real_escape_string($conn, intval($at)) . "', 
													`order_orders_devices`.`ot`='" . mysqli_real_escape_string($conn, intval($ot)) . "', 
													`order_orders_devices`.`info`='" . mysqli_real_escape_string($conn, strip_tags("Auftrag gefunden u. neues Gerät!")) . "', 
													`order_orders_devices`.`storage_space`='" . mysqli_real_escape_string($conn, strip_tags($storage_space)) . "', 
													`order_orders_devices`.`storage_space_id`='" . mysqli_real_escape_string($conn, intval($storage_space_id)) . "', 
													`order_orders_devices`.`storage_space_owner`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`order_orders_devices`.`storage_space_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
													`order_orders_devices`.`star`='" . mysqli_real_escape_string($conn, intval($row_devices_count['c'] == 0 ? 1 : 0)) . "', 
													`order_orders_devices`.`is_storage`='1', 
													`order_orders_devices`.`reg_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
													`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

					$_POST["device_id"] = $conn->insert_id;

					mysqli_query($conn, "	INSERT 	`order_orders_devices_events` 
											SET 	`order_orders_devices_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
													`order_orders_devices_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
													`order_orders_devices_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "', 
													`order_orders_devices_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
													`order_orders_devices_events`.`message`='" . mysqli_real_escape_string($conn, "<span class=\"badge badge-success\">Gerät " . strip_tags($device_number . ($atot_mode == 1 ? "-AT-" . $at : ($atot_mode == 2 ? "-ORG-" . $ot : ""))) . ", erstellt, ID [#" . intval($_POST["device_id"]) . "]</span>") . "', 
													`order_orders_devices_events`.`subject`='', 
													`order_orders_devices_events`.`body`='', 
													`order_orders_devices_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

					$shopin_number = 0;

					while($shopin_number == 0){

						$random = rand(10001, 99999);

						$result = mysqli_query($conn, "SELECT * FROM `shopin_shopins` WHERE `shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `shopin_shopins`.`shopin_number`='" . $random . "'");

						if($result->num_rows == 0){

							$shopin_number = $random;

						}

					}

					mysqli_query($conn, "	INSERT 	`shopin_shopins` 
											SET 	`shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
													`shopin_shopins`.`mode`='0', 
													`shopin_shopins`.`type`='0', 
													`shopin_shopins`.`shopin_number`='" . mysqli_real_escape_string($conn, strip_tags($shopin_number)) . "', 
													`shopin_shopins`.`order_number`='" . mysqli_real_escape_string($conn, strip_tags($row_order['order_number'])) . "', 
													`shopin_shopins`.`creator_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`shopin_shopins`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`shopin_shopins`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "', 
													`shopin_shopins`.`device_id`='" . mysqli_real_escape_string($conn, intval($_POST["device_id"])) . "', 
													`shopin_shopins`.`storage_space_id`='" . mysqli_real_escape_string($conn, intval($storage_space_id)) . "', 
													`shopin_shopins`.`description`='" . mysqli_real_escape_string($conn, strip_tags("Auftrag gefunden u. neues Gerät!")) . "', 
													`shopin_shopins`.`reg_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
													`shopin_shopins`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

					$_POST["id"] = $conn->insert_id;

					$row_status = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`='" . mysqli_real_escape_string($conn, intval($maindata[$status_field])) . "'"), MYSQLI_ASSOC);

					$row_template = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `templates` WHERE `templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `templates`.`id`='" . mysqli_real_escape_string($conn, intval($row_status['email_template'])) . "'"), MYSQLI_ASSOC);

					$row_template['body'] .= $row_admin['email_signature'];

					$status_number = intval($_SESSION["admin"]["id"]) . "A" . date("dmYHis", time());

					$fields = array('subject', 'body', 'admin_mail_subject');

					for($j = 0;$j < count($fields);$j++){

						$row_template[$fields[$j]] = str_replace("[status_id]", $status_number, $row_template[$fields[$j]]);
						$row_template[$fields[$j]] = str_replace("[status]", $row_status["name"], $row_template[$fields[$j]]);

						$row_template[$fields[$j]] = str_replace("[id]", $device_number, $row_template[$fields[$j]]);
						$row_template[$fields[$j]] = str_replace("[order_id]", $order_number, $row_template[$fields[$j]]);
						$row_template[$fields[$j]] = str_replace("[date]", date("d.m.Y (H:i)", $time), $row_template[$fields[$j]]);

						if(isset($row_order['id']) && $row_order['id'] > 0){

							$row_template[$fields[$j]] = str_replace("[companyname]", $row_order['companyname'], $row_template[$fields[$j]]);
							$row_template[$fields[$j]] = str_replace("[gender]", ($row_order['gender'] == 1 ? "Sehr geehrte Frau" : "Sehr geehrter Herr"), $row_template[$fields[$j]]);
							$row_template[$fields[$j]] = str_replace("[sexual]", ($row_order['gender'] == 1 ? "Frau" : "Herr"), $row_template[$fields[$j]]);
							$row_template[$fields[$j]] = str_replace("[firstname]", $row_order['firstname'], $row_template[$fields[$j]]);
							$row_template[$fields[$j]] = str_replace("[lastname]", $row_order['lastname'], $row_template[$fields[$j]]);
							$row_template[$fields[$j]] = str_replace("[street]", $row_order['street'], $row_template[$fields[$j]]);
							$row_template[$fields[$j]] = str_replace("[streetno]", $row_order['streetno'], $row_template[$fields[$j]]);
							$row_template[$fields[$j]] = str_replace("[zipcode]", $row_order['zipcode'], $row_template[$fields[$j]]);
							$row_template[$fields[$j]] = str_replace("[city]", $row_order['city'], $row_template[$fields[$j]]);
							$row_template[$fields[$j]] = str_replace("[country]", (isset($row_country['id']) ? $row_country['name'] : ""), $row_template[$fields[$j]]);
							$row_template[$fields[$j]] = str_replace("[phonenumber]", $row_order['phonenumber'], $row_template[$fields[$j]]);
							$row_template[$fields[$j]] = str_replace("[mobilnumber]", $row_order['mobilnumber'], $row_template[$fields[$j]]);
							$row_template[$fields[$j]] = str_replace("[email]", "<a href=\"mailto: " . $row_order['email'] . "\">" . $row_order['email'] . "</a>\n", $row_template[$fields[$j]]);

							$differing_shipping_address = 	$row_order['differing_shipping_address'] == 0 ? 
															"" : 
															"<h4>Abweichende Lieferadresse</h4>\n" . 
															"<table cellspacing=\"3\" cellpadding=\"3\" border=\"0\">\n" . 
															"	<tr><td width=\"200\"><strong>Firma:</strong></td><td><span>[differing_companyname]</span></td></tr>\n" . 
															"	<tr><td><strong>Vorname:</strong></td><td><span>[differing_firstname]</span></td></tr>\n" . 
															"	<tr><td><strong>Nachname:</strong></td><td><span>[differing_lastname]</span></td></tr>\n" . 
															"	<tr><td><strong>Straße:</strong></td><td><span>[differing_street]</span></td></tr>\n" . 
															"	<tr><td><strong>Hausnummer:</strong></td><td><span>[differing_streetno]</span></td></tr>\n" . 
															"	<tr><td><strong>PLZ:</strong></td><td><span>[differing_zipcode]</span></td></tr>\n" . 
															"	<tr><td><strong>Ort:</strong></td><td><span>[differing_city]</span></td></tr>\n" . 
															"	<tr><td><strong>Land:</strong></td><td><span>[differing_country]</span></td></tr>\n" . 
															"</table>\n" . 
															"<br />\n";

							$row_template[$fields[$j]] = str_replace("[differing_shipping_address]", $differing_shipping_address, $row_template[$fields[$j]]);
							$row_template[$fields[$j]] = str_replace("[differing_companyname]", $row_order['differing_companyname'], $row_template[$fields[$j]]);
							$row_template[$fields[$j]] = str_replace("[differing_firstname]", $row_order['differing_firstname'], $row_template[$fields[$j]]);
							$row_template[$fields[$j]] = str_replace("[differing_lastname]", $row_order['differing_lastname'], $row_template[$fields[$j]]);
							$row_template[$fields[$j]] = str_replace("[differing_street]", $row_order['differing_street'], $row_template[$fields[$j]]);
							$row_template[$fields[$j]] = str_replace("[differing_streetno]", $row_order['differing_streetno'], $row_template[$fields[$j]]);
							$row_template[$fields[$j]] = str_replace("[differing_zipcode]", $row_order['differing_zipcode'], $row_template[$fields[$j]]);
							$row_template[$fields[$j]] = str_replace("[differing_city]", $row_order['differing_city'], $row_template[$fields[$j]]);
							$row_template[$fields[$j]] = str_replace("[differing_country]", (isset($row_differing_country['id']) ? $row_differing_country['name'] : ""), $row_template[$fields[$j]]);

							$row_template[$fields[$j]] = str_replace("[pricemwst]", number_format($row_order['pricemwst'], 2, ',', '') . " €", $row_template[$fields[$j]]);
							$radio_radio_shipping = array(	0 => "Expressversand", 
															1 => "Standardversand", 
															2 => "International", 
															3 => "Abholung");
							$row_template[$fields[$j]] = str_replace("[radio_shipping]", $radio_radio_shipping[$row_order['radio_shipping']], $row_template[$fields[$j]]);
							$radio_radio_payment = array(	0 => "Überweisung (Sie überweisen den Rechnungsbetrag per Überweisung)", 
															1 => "Nachnahme", 
															2 => "Bar");
							$row_template[$fields[$j]] = str_replace("[radio_payment]", $radio_radio_payment[$row_order['radio_payment']], $row_template[$fields[$j]]);

							$row_template[$fields[$j]] = str_replace("[machine]", strip_tags($row_order['machine']), $row_template[$fields[$j]]);
							$row_template[$fields[$j]] = str_replace("[model]", strip_tags($row_order['model']), $row_template[$fields[$j]]);
							$row_template[$fields[$j]] = str_replace("[constructionyear]", strip_tags($row_order['constructionyear']), $row_template[$fields[$j]]);
							$row_template[$fields[$j]] = str_replace("[carid]", strtoupper(strip_tags($row_order['carid'])), $row_template[$fields[$j]]);
							$row_template[$fields[$j]] = str_replace("[kw]", strip_tags($row_order['kw']), $row_template[$fields[$j]]);
							$row_template[$fields[$j]] = str_replace("[mileage]", number_format(intval($row_order['mileage']), 0, '', '.') . " km", $row_template[$fields[$j]]);
							$row_template[$fields[$j]] = str_replace("[mechanism]", ($row_order['mechanism'] == 0 ? "Schaltung" : "Automatik"), $row_template[$fields[$j]]);
							$row_template[$fields[$j]] = str_replace("[fuel]", ($row_order['fue'] == 0 ? "Benzin" : "Diesel"), $row_template[$fields[$j]]);

			//				$row_template[$fields[$j]] = str_replace("[files]", $links, $row_template[$fields[$j]]);

						}

					}

					mysqli_query($conn, "	INSERT 	`" . $order_table . "_statuses` 
											SET 	`" . $order_table . "_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
													`" . $order_table . "_statuses`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "', 
													`" . $order_table . "_statuses`.`status_number`='" . mysqli_real_escape_string($conn, $status_number) . "', 
													`" . $order_table . "_statuses`.`admin_id`='" . mysqli_real_escape_string($conn, $_SESSION["admin"]["id"]) . "', 
													`" . $order_table . "_statuses`.`status_id`='" . mysqli_real_escape_string($conn, $row_status['id']) . "', 
													`" . $order_table . "_statuses`.`template`='" . mysqli_real_escape_string($conn, $row_template['name']) . "', 
													`" . $order_table . "_statuses`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
													`" . $order_table . "_statuses`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
													`" . $order_table . "_statuses`.`public`='1', 
													`" . $order_table . "_statuses`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

					$_SESSION["status"]["id"] = $conn->insert_id;

					mysqli_query($conn, "	INSERT 	`" . $order_table . "_events` 
											SET 	`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
													`" . $order_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
													`" . $order_table . "_events`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "', 
													`" . $order_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
													`" . $order_table . "_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag gefunden - Gerät " . $device_number . ($atot_mode == 1 ? "-AT-" . $at : ($atot_mode == 2 ? "-ORG-" . $ot : "")) . " erstellt, ID [#" . $_POST['device_id'] . "]") . "', 
													`" . $order_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
													`" . $order_table . "_events`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
													`" . $order_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

					$tracking_image = "<img src=\"" . $domain . "/email-logo/" . $_SESSION["admin"]["company_id"] . "/" . $order_number . "/" . $status_number . "\" width=\"0\" height=\"0\" border=\"0\" />\n";

					if($row_template['mail_with_pdf'] == 1){

						$filename = "begleitschein.pdf";

						$pdf = new Fpdi();

						$pdf->AddPage();

						require('includes/email_template_pdf_code_' . $row_template['id'] . '.php');

						$pdfdoc = $pdf->Output("", "S");

						if(isset($row_order['id']) && $row_status['usermail'] == 1 && $row_order['email'] != ""){

							$mail = new dbbMailer();

							$mail->host = $maindata['smtp_host'];
							$mail->username = $maindata['smtp_username'];
							$mail->password = $maindata['smtp_password'];
							$mail->secure = $maindata['smtp_secure'];
							$mail->port = intval($maindata['smtp_port']);
							$mail->charset = $maindata['smtp_charset'];

							$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
							$mail->addAddress($row_order['email'], $row_order['firstname'] . " " . $row_order['lastname']);

							//$mail->addAttachment(dirname(__FILE__) . "/../../temp/condition.tar");

							$mail->addStringAttachment($pdfdoc, $filename, 'base64', 'application/pdf');

							$mail->subject = strip_tags($row_template['subject']);

							$mail->body = str_replace("[track]", $tracking_image, $row_template['body']);

							if(!$mail->send()){
								$emsg .= "<small class=\"error text-muted\">Das versenden der E-Mail an den Kunden wurde abgebrochen!</small><br />\n";
							}

						}

						if($row_status['adminmail'] == 1){

							$mail = new dbbMailer();

							$mail->host = $maindata['smtp_host'];
							$mail->username = $maindata['smtp_username'];
							$mail->password = $maindata['smtp_password'];
							$mail->secure = $maindata['smtp_secure'];
							$mail->port = intval($maindata['smtp_port']);
							$mail->charset = $maindata['smtp_charset'];

							$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
							$mail->addAddress($row_admin['email']);

							//$mail->addAttachment(dirname(__FILE__) . "/../../temp/condition.tar");

							$mail->addStringAttachment($pdfdoc, $filename, 'base64', 'application/pdf');

							$mail->subject = strip_tags($row_template['admin_mail_subject']);

							$mail->body = str_replace("[track]", "", $row_template['body']);

							if(!$mail->send()){
								$emsg .= "<small class=\"error text-muted\">Das versenden der E-Mail an den Administrator wurde abgebrochen!</small><br />\n";
							}

						}

					}else{

						if(isset($row_order['id']) && $row_status['usermail'] == 1 && $row_order['email'] != ""){

							$mail = new dbbMailer();

							$mail->host = $maindata['smtp_host'];
							$mail->username = $maindata['smtp_username'];
							$mail->password = $maindata['smtp_password'];
							$mail->secure = $maindata['smtp_secure'];
							$mail->port = intval($maindata['smtp_port']);
							$mail->charset = $maindata['smtp_charset'];

							$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
							$mail->addAddress($row_order['email'], $row_order['firstname'] . " " . $row_order['lastname']);

							$mail->subject = strip_tags($row_template['subject']);

							$mail->body = str_replace("[track]", $tracking_image, $row_template['body']);

							if(!$mail->send()){
								$emsg .= "<small class=\"error text-muted\">Das versenden der E-Mail an den Kunden wurde abgebrochen!</small><br />\n";
							}

						}

						if($row_status['adminmail'] == 1){

							$mail = new dbbMailer(true);

							$mail->host = $maindata['smtp_host'];
							$mail->username = $maindata['smtp_username'];
							$mail->password = $maindata['smtp_password'];
							$mail->secure = $maindata['smtp_secure'];
							$mail->port = intval($maindata['smtp_port']);
							$mail->charset = $maindata['smtp_charset'];

							$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
							$mail->addAddress($row_admin['email']);

							$mail->subject = strip_tags($row_template['admin_mail_subject']);

							$mail->body = str_replace("[track]", "", $row_template['body']);

							if(!$mail->send()){
								$emsg .= "<small class=\"error text-muted\">Das versenden der E-Mail an den Administrator wurde abgebrochen!</small><br />\n";
							}

						}

					}

					$_POST['order_id'] = intval($row_order['id']);

					$_POST['shopin_add_device'] = "hinzufügen";

				}else{

					$_POST['shopin_storage_space_id'] = "empty";

				}

			}else{

				$_POST['shopin_order_id'] = "empty";

			}

			break;

		case "screen_relocate": 

			$row_order = mysqli_fetch_array(mysqli_query($conn, "	SELECT 	* 
																	FROM	`order_orders` 
																	WHERE	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																	AND 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, strip_tags($row_device['order_id'])) . "'"), MYSQLI_ASSOC);

			$shopin_number = 0;

			while($shopin_number == 0){

				$random = rand(10001, 99999);

				$result = mysqli_query($conn, "SELECT * FROM `shopin_shopins` WHERE `shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `shopin_shopins`.`shopin_number`='" . $random . "'");

				if($result->num_rows == 0){

					$shopin_number = $random;

				}

			}

			$result = mysqli_query($conn, "	SELECT 		`storage_places`.`id` AS id, 
														`storage_places`.`name` AS name, 
														`storage_places`.`parts` AS parts, 
														`storage_places`.`used` AS used 
											FROM 		`storage_places` 
											LEFT JOIN	`storage_rooms` 
											ON			`storage_places`.`room_id`=`storage_rooms`.`id` 
											WHERE 		`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
											AND 		`storage_rooms`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
											ORDER BY 	CAST(`storage_rooms`.`pos` AS UNSIGNED) ASC, CAST(`storage_places`.`pos` AS UNSIGNED) ASC");

			$storage_space = "";

			$storage_space_id = 0;

			while($row_storage_place = $result->fetch_array(MYSQLI_ASSOC)){

				if($row_storage_place['used'] < $row_storage_place['parts']){

					$storage_space = $row_storage_place['name'];

					$storage_space_id = $row_storage_place['id'];

					mysqli_query($conn, "UPDATE `storage_places` SET `storage_places`.`used`=`storage_places`.`used`+1 WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_storage_place['id'])) . "'");

					break;

				}

			}

			if($storage_space != ""){

				mysqli_query($conn, "	UPDATE 	`order_orders_devices` 
										SET 	`order_orders_devices`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
												`order_orders_devices`.`storage_space_id`='" . mysqli_real_escape_string($conn, intval($storage_space_id)) . "', 
												`order_orders_devices`.`is_shopin_relocate`='1', 
												`order_orders_devices`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
										WHERE 	`order_orders_devices`.`id`='" . mysqli_real_escape_string($conn, intval($row_device['id'])) . "' 
										AND 	`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

				mysqli_query($conn, "	INSERT 	`shopin_shopins` 
										SET 	`shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
												`shopin_shopins`.`mode`='0', 
												`shopin_shopins`.`type`='5', 
												`shopin_shopins`.`shopin_number`='" . mysqli_real_escape_string($conn, strip_tags($shopin_number)) . "', 
												`shopin_shopins`.`order_number`='" . mysqli_real_escape_string($conn, strip_tags($row_order['order_number'])) . "', 
												`shopin_shopins`.`creator_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
												`shopin_shopins`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
												`shopin_shopins`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_device['order_id'])) . "', 
												`shopin_shopins`.`device_id`='" . mysqli_real_escape_string($conn, intval($row_device["id"])) . "', 
												`shopin_shopins`.`storage_space_id`='" . mysqli_real_escape_string($conn, intval($storage_space_id)) . "', 
												`shopin_shopins`.`old_storage_space_id`='" . mysqli_real_escape_string($conn, intval($row_device['storage_space_id'])) . "', 
												`shopin_shopins`.`description`='" . mysqli_real_escape_string($conn, strip_tags("Gerät im Auftrag gefunden!")) . "', 
												`shopin_shopins`.`reg_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
												`shopin_shopins`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

				$_POST["id"] = $conn->insert_id;

				$_POST['shopin_relocate'] = "hinzufügen";

			}else{
				
				$_POST['shopin_storage_space_id'] = "empty";

			}

			break;

		case "screen_used": 

			$_POST['id'] = $row_device['id'];

			$_POST['shopin_used'] = "benutzt";

			break;

		case "screen_relocate_next": 

			$_POST['shopin_relocate'] = "hinzufügen";

			break;

		case "screen_relocate_complete": 

			$_POST['shopin_relocate'] = "complete";

			break;

		case "help_device": 

			$shopin_number = 0;

			while($shopin_number == 0){

				$random = rand(10001, 99999);

				$result = mysqli_query($conn, "SELECT * FROM `shopin_shopins` WHERE `shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `shopin_shopins`.`shopin_number`='" . $random . "'");

				if($result->num_rows == 0){

					$shopin_number = $random;

				}

			}

			$order_number = 0;

			while($order_number == 0){

				$random = rand(101, 999);

				$result = mysqli_query($conn, "SELECT * FROM `shopin_shopins` WHERE `shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `shopin_shopins`.`help_order_number`='" . $random . "'");

				if($result->num_rows == 0){

					$order_number = $random;

				}

			}

			$device_number = 0;

			while($device_number == 0){

				$random = rand(1001, 9999);

				$result = mysqli_query($conn, "SELECT * FROM `shopin_shopins` WHERE `shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `shopin_shopins`.`help_device_number`='" . $random . "'");

				if($result->num_rows == 0){

					$device_number = $random;

				}

			}

			$result = mysqli_query($conn, "	SELECT 		`storage_places`.`id` AS id, 
														`storage_places`.`name` AS name, 
														`storage_places`.`parts` AS parts, 
														`storage_places`.`used` AS used 
											FROM 		`storage_places` 
											LEFT JOIN	`storage_rooms` 
											ON			`storage_places`.`room_id`=`storage_rooms`.`id` 
											WHERE 		`storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
											AND 		`storage_rooms`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
											ORDER BY 	CAST(`storage_rooms`.`pos` AS UNSIGNED) ASC, CAST(`storage_places`.`pos` AS UNSIGNED) ASC");

			$storage_space = "";

			$storage_space_id = 0;

			while($row_storage_place = $result->fetch_array(MYSQLI_ASSOC)){

				if($row_storage_place['used'] < $row_storage_place['parts']){

					$storage_space = $row_storage_place['name'];

					$storage_space_id = $row_storage_place['id'];

					mysqli_query($conn, "UPDATE `storage_places` SET `storage_places`.`used`=`storage_places`.`used`+1 WHERE `storage_places`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `storage_places`.`id`='" . mysqli_real_escape_string($conn, intval($row_storage_place['id'])) . "'");

					break;

				}

			}

			if($storage_space != ""){

				mysqli_query($conn, "	INSERT 	`shopin_shopins` 
										SET 	`shopin_shopins`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
												`shopin_shopins`.`mode`='0', 
												`shopin_shopins`.`type`='1', 
												`shopin_shopins`.`shopin_number`='" . mysqli_real_escape_string($conn, strip_tags($shopin_number)) . "', 
												`shopin_shopins`.`order_number`='" . mysqli_real_escape_string($conn, strip_tags($order_number)) . "', 
												`shopin_shopins`.`creator_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
												`shopin_shopins`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
												`shopin_shopins`.`help_device_number`='" . mysqli_real_escape_string($conn, strip_tags($device_number)) . "', 
												`shopin_shopins`.`storage_space_id`='" . mysqli_real_escape_string($conn, intval($storage_space_id)) . "', 
												`shopin_shopins`.`description`='" . mysqli_real_escape_string($conn, strip_tags("Auftrag <u>nicht</u> gefunden!")) . "', 
												`shopin_shopins`.`reg_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
												`shopin_shopins`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

				$_POST["id"] = $conn->insert_id;

				$_POST['shopin_order'] = "none";

			}else{
				
				$_POST['shopin_storage_space_id'] = "empty";

			}

			break;

	}

?>