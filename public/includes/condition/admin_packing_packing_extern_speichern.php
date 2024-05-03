<?php 

	$time = time();

	$row_packing = mysqli_fetch_array(mysqli_query($conn, "	SELECT 	* 
															FROM 	`packing_packings` 
															WHERE 	`packing_packings`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
															AND 	`packing_packings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

	$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($row_packing['order_id'])) . "'"), MYSQLI_ASSOC);

	if(strlen($_POST['message']) > 65536){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Information ein. (max. 65536 Zeichen)</small><br />\n";
		$inp_message = " is-invalid";
	} else {
		$message = strip_tags($_POST['message']);
	}

	if(strlen($_POST['technic_address']) > 11 || intval($_POST['technic_address']) < 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie ein Techniker aus.</small><br />\n";
	} else {

	}

	if(strlen($_POST['companyname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Firmenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_companyname = " is-invalid";
	} else {
		$companyname = strip_tags($_POST['companyname']);
	}

	if(strlen($_POST['firstname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Vorname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_firstname = " is-invalid";
	} else {
		$firstname = strip_tags($_POST['firstname']);
	}

	if(strlen($_POST['lastname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Nachname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_lastname = " is-invalid";
	} else {
		$lastname = strip_tags($_POST['lastname']);
	}

	if(strlen($_POST['street']) < 1|| strlen($_POST['street']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Straßenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_street = " is-invalid";
	} else {
		$street = strip_tags($_POST['street']);
	}

	if(strlen($_POST['streetno']) < 1 || strlen($_POST['streetno']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Hausnummer ein. (max. 10 Zeichen)</small><br />\n";
		$inp_streetno = " is-invalid";
	} else {
		$streetno = strip_tags($_POST['streetno']);
	}

	if(strlen($_POST['zipcode']) < 1 || strlen($_POST['zipcode']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Postleitzahl ein. (max. 10 Zeichen)</small><br />\n";
		$inp_zipcode = " is-invalid";
	} else {
		$zipcode = strip_tags($_POST['zipcode']);
	}

	if(strlen($_POST['city']) < 1 || strlen($_POST['city']) > 128){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Ort ein. (max. 128 Zeichen)</small><br />\n";
		$inp_city = " is-invalid";
	} else {
		$city = strip_tags($_POST['city']);
	}

	if(strlen($_POST['country']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie das Land an. (max. 11 Zeichen)</small><br />\n";
		$inp_country = " is-invalid";
	} else {
		$country = intval($_POST['country']);
	}

	if(strlen($_POST['phonenumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Telefonnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_phonenumber = " is-invalid";
	} else {
		$phonenumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['phonenumber']));
	}

	if(strlen($_POST['mobilnumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Mobilnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_mobilnumber = " is-invalid";
	} else {
		$mobilnumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['mobilnumber']));
	}

	if(preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,26})$/", $_POST['email']) && $_POST['email'] != ""){
		$email = strip_tags($_POST['email']);
	} else {
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die E-Mail-Adresse ein.</small><br />\n";
		$inp_email = " is-invalid";
	}

	$emsg_files = "";

	$sumsize = 0;

	$upload_max_filesize = (int)ini_get("upload_max_filesize");

	$j = 1;

	$allowed = explode(",", str_replace(".", "", str_replace(", ", ",", $maindata['input_file_accept'])));

	if(isset($_FILES["file"]["error"])){
		foreach($_FILES["file"]["error"] as $key => $error) {
			//if ($j <= 5 && $_FILES["file"]["name"][$key] != "") {
				$ext = pathinfo($_FILES["file"]["name"][$key], PATHINFO_EXTENSION);
				if(in_array($ext, $allowed)){
					$sumsize+=filesize($_FILES["file"]["tmp_name"][$key]);
				}
			//}
			$j++;
		}
		if($sumsize > $upload_max_filesize * 1024 * 1024){
			$emsg_files = "<p>Die upload Datengröße ist zu hoch. Es sind nur " . $upload_max_filesize . "MB insgesammt erlaubt!</p>";
		}
	}

	$uploaddir = 'uploads/';

	$files = "";

	$j = 1;

	if($emsg_files == ""){
		if(isset($_FILES["file"]["error"])){
			foreach($_FILES["file"]["error"] as $key => $error) {
				//if ($j <= 5 && $_FILES["file"]["name"][$key] != "") {
					$ext = pathinfo($_FILES["file"]["name"][$key], PATHINFO_EXTENSION);
					if(in_array($ext, $allowed)){
						$random = rand(1, 100000);
						$_FILES["file"]["name"][$key] = preg_replace("/[^a-z0-9\_\-\.]/i", '', strip_tags(basename($_FILES["file"]["name"][$key])));
						move_uploaded_file($_FILES["file"]["tmp_name"][$key], $uploaddir . "company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $row_order['order_number'] . "/document/" . basename($random . '_' . $_FILES["file"]["name"][$key]));
						$files .= $files == "" ? $random . '_' . $_FILES["file"]["name"][$key] : "\r\n" . $random . '_' . $_FILES["file"]["name"][$key];
						mysqli_query($conn, "	INSERT 	`order_orders_files` 
												SET 	`order_orders_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
														`order_orders_files`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
														`order_orders_files`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "', 
														`order_orders_files`.`type`='0', 
														`order_orders_files`.`file`='" . mysqli_real_escape_string($conn, $random . '_' . $_FILES["file"]["name"][$key]) . "', 
														`order_orders_files`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
					}else{
						$emsg_files .= "<p>Der Dateityp " . $ext . " ist nicht erlaubt, " . $_FILES["file"]["name"][$key] . "</p>\n";
					}
				//}
				$j++;
			}
		}
	}

	if($emsg_files == "" && $files != ""){

		mysqli_query($conn, "	UPDATE 	`order_orders` 
								SET 	`order_orders`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
								WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($row_order['id'])) . "' 
								AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		mysqli_query($conn, "	INSERT 	`order_orders_events` 
								SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($row_order["id"])) . "', 
										`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
										`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag, Dateien hochgeladen, ID [#" . intval($row_order["id"]) . "]") . "', 
										`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag, Dateien hochgeladen, ID [#" . intval($row_order["id"]) . "]") . "', 
										`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "Dateien: [" . str_replace("\r\n", ", ", $files) . "]") . "', 
										`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$emsg_files = "<p>Der Auftrag wurde erfolgreich geändert!</p>\n";

	}

	if($emsg == ""){

		$order_extended_items = "";

		$arr_order_extended_items = explode("\r\n", $row_packing['order_extended_items']);

		if($row_packing['order_extended_items'] != ""){

			for($item = 0;$item < count($arr_order_extended_items);$item++){

				$arr_item = explode("|", $arr_order_extended_items[$item]);

				$order_extended_items .= $order_extended_items == "" ? $arr_item[0] . "|" . $arr_item[1] . "|" . (isset($_POST[$arr_item[0]]) ? intval($_POST[$arr_item[0]]) : 0) : "\r\n" . $arr_item[0] . "|" . $arr_item[1] . "|" . (isset($_POST[$arr_item[0]]) ? intval($_POST[$arr_item[0]]) : 0);

			}

		}

		mysqli_query($conn, "	UPDATE 	`packing_packings` 
								SET 	`packing_packings`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`packing_packings`.`agent_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`packing_packings`.`companyname`='" . mysqli_real_escape_string($conn, $companyname) . "', 
										`packing_packings`.`gender`='" . mysqli_real_escape_string($conn, $gender) . "', 
										`packing_packings`.`firstname`='" . mysqli_real_escape_string($conn, $firstname) . "', 
										`packing_packings`.`lastname`='" . mysqli_real_escape_string($conn, $lastname) . "', 
										`packing_packings`.`street`='" . mysqli_real_escape_string($conn, $street) . "', 
										`packing_packings`.`streetno`='" . mysqli_real_escape_string($conn, $streetno) . "', 
										`packing_packings`.`zipcode`='" . mysqli_real_escape_string($conn, $zipcode) . "', 
										`packing_packings`.`city`='" . mysqli_real_escape_string($conn, $city) . "', 
										`packing_packings`.`country`='" . mysqli_real_escape_string($conn, $country) . "', 
										`packing_packings`.`email`='" . mysqli_real_escape_string($conn, $email) . "', 
										`packing_packings`.`mobilnumber`='" . mysqli_real_escape_string($conn, $mobilnumber) . "', 
										`packing_packings`.`phonenumber`='" . mysqli_real_escape_string($conn, $phonenumber) . "', 
										`packing_packings`.`radio_payment`='" . mysqli_real_escape_string($conn, intval($_POST['radio_payment'])) . "', 
										`packing_packings`.`radio_saturday`='" . mysqli_real_escape_string($conn, intval($_POST['radio_saturday'])) . "', 
										`packing_packings`.`amount`='" . mysqli_real_escape_string($conn, number_format($_POST['amount'], 2, '.', '')) . "', 
										`packing_packings`.`carriers_service`='" . mysqli_real_escape_string($conn, intval($_POST['carriers_service'])) . "', 
										`packing_packings`.`weight`='" . mysqli_real_escape_string($conn, $_POST['weight']) . "', 
										`packing_packings`.`length`='" . mysqli_real_escape_string($conn, $_POST['length']) . "', 
										`packing_packings`.`width`='" . mysqli_real_escape_string($conn, $_POST['width']) . "', 
										`packing_packings`.`height`='" . mysqli_real_escape_string($conn, $_POST['height']) . "', 
										`packing_packings`.`message`='" . mysqli_real_escape_string($conn, $message) . "', 
										`packing_packings`.`file1`='" . mysqli_real_escape_string($conn, intval(isset($_POST['file1']) ? $_POST['file1'] : 0)) . "', 
										`packing_packings`.`file2`='" . mysqli_real_escape_string($conn, intval(isset($_POST['file2']) ? $_POST['file2'] : 0)) . "', 
										`packing_packings`.`order_extended_items`='" . mysqli_real_escape_string($conn, strip_tags($order_extended_items)) . "', 
										`packing_packings`.`adding`='" . mysqli_real_escape_string($conn, intval($_POST['adding'])) . "', 
										`packing_packings`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'  
								WHERE 	`packing_packings`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
								AND 	`packing_packings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	}

?>