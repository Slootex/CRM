<?php 

	if(strlen($_POST['message']) > 65536){
		$emsg .= "<small class=\"error text-muted\">Bitte eine Nachricht eingeben. (max. 65536 Zeichen)</small><br />\n";
		$inp_message = " is-invalid";
	} else {
		$message = preg_replace("~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~", "<a href=\"\\0\" target=\"_blank\">Link öffnen</a>", $_POST['message']);
	}

	if(strlen($_POST['technic_address']) > 11 || intval($_POST['technic_address']) < 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie ein Techniker aus.</small><br />\n";
		//$inp_technic_address = " is-invalid";
	} else {
		//$technic_address = intval($_POST['technic_address']);
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

	if(strlen($_POST['street']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Straßenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_street = " is-invalid";
	} else {
		$street = strip_tags($_POST['street']);
	}

	if(strlen($_POST['streetno']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Hausnummer ein. (max. 10 Zeichen)</small><br />\n";
		$inp_streetno = " is-invalid";
	} else {
		$streetno = strip_tags($_POST['streetno']);
	}

	if(strlen($_POST['zipcode']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie die Postleitzahl ein. (max. 10 Zeichen)</small><br />\n";
		$inp_zipcode = " is-invalid";
	} else {
		$zipcode = strip_tags($_POST['zipcode']);
	}

	if(strlen($_POST['city']) > 128){
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

	if($emsg == ""){

		$time = time();

		$script_paste = "";

		$result_devices = mysqli_query($conn, "	SELECT 		`order_orders_devices`.`id` AS id, 
															`order_orders_devices`.`device_number` AS device_number 
												FROM 		`order_orders_devices` `order_orders_devices` 
												WHERE 		`order_orders_devices`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
												AND 		`order_orders_devices`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
												ORDER BY 	`order_orders_devices`.`device_number` ASC");
	
		while($row_device = $result_devices->fetch_array(MYSQLI_ASSOC)){

			if(isset($_POST['device_' . $row_device['id']]) && intval($_POST['device_' . $row_device['id']]) == 1){

				$script_paste .= "document.getElementById('device_" . $row_device['id'] . "').checked=true;\n";

			}

		}

		$script_paste .= "document.getElementById('message').value='" . str_replace("\r\n", " ", $message) . "';\n";
		$script_paste .= "document.getElementById('packing_companyname').value='" . $companyname . "';\n";
		$script_paste .= isset($_POST['gender']) && intval($_POST['gender']) == 0 ? "document.getElementById('packing_gender_03').checked=true;\n" : "document.getElementById('packing_gender_13').checked=true;\n";
		$script_paste .= "document.getElementById('packing_firstname').value='" . $firstname . "';\n";
		$script_paste .= "document.getElementById('packing_lastname').value='" . $lastname . "';\n";
		$script_paste .= "document.getElementById('packing_route').value='" . $street . "';\n";
		$script_paste .= "document.getElementById('packing_street_number').value='" . $streetno . "';\n";
		$script_paste .= "document.getElementById('packing_postal_code').value='" . $zipcode . "';\n";
		$script_paste .= "document.getElementById('packing_locality').value='" . $city . "';\n";

		$script_paste .= "var country_id=" . intval(isset($_POST['country']) && intval($_POST['country']) > 0 ? $_POST['country'] : 0) . ";\n";
		$script_paste .= "var data_code='';\n";
		$script_paste .= "\$('#packing_country option').each(function(){if(\$(this).attr('value')==country_id){data_code=\$(this).attr('data-code')+'';}});\n";
		$script_paste .= "\$('#packing_country-a li').each(function(){if(\$(this).find('img').attr('data-code')==data_code){\$(this).click();\$('.packing_country-b').toggle();}});\n";

		$script_paste .= "document.getElementById('packing_email').value='" . $email . "';\n";
		$script_paste .= "document.getElementById('packing_mobilnumber').value='" . $mobilnumber . "';\n";
		$script_paste .= "document.getElementById('packing_phonenumber').value='" . $phonenumber . "';\n";
		$script_paste .= "document.getElementById('packing_carriers_service').value=" . strip_tags(isset($_POST['carriers_service']) && $_POST['carriers_service'] != "" ? $_POST['carriers_service'] : "") . ";\n";
		$script_paste .= "document.getElementById('packing_amount').value=" . strip_tags(isset($_POST['amount']) && $_POST['amount'] != "" ? $_POST['amount'] : 0) . ";\n";
		$script_paste .= "document.getElementById('packing_length').value=" . strip_tags(isset($_POST['length']) && $_POST['length'] != "" ? $_POST['length'] : 0) . ";\n";
		$script_paste .= "document.getElementById('packing_width').value=" . strip_tags(isset($_POST['width']) && $_POST['width'] != "" ? $_POST['width'] : 0) . ";\n";
		$script_paste .= "document.getElementById('packing_height').value=" . strip_tags(isset($_POST['height']) && $_POST['height'] != "" ? $_POST['height'] : 0) . ";\n";
		$script_paste .= "document.getElementById('packing_weight').value=" . strip_tags(isset($_POST['weight']) && $_POST['weight'] != "" ? $_POST['weight'] : 0) . ";\n";

		mysqli_query($conn, "	UPDATE	`order_orders` 
								SET 	`order_orders`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
								WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
								AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		mysqli_query($conn, "	INSERT 	`" . $order_table . "_history` 
								SET 	`" . $order_table . "_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`" . $order_table . "_history`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`" . $order_table . "_history`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
										`" . $order_table . "_history`.`type`='4', 
										`" . $order_table . "_history`.`message`='" . mysqli_real_escape_string($conn, $message) . "', 
										`" . $order_table . "_history`.`script`='" . mysqli_real_escape_string($conn, $script_paste) . "', 
										`" . $order_table . "_history`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$_SESSION["history"]["id"] = $conn->insert_id;

		mysqli_query($conn, "	INSERT 	`" . $order_table . "_events` 
								SET 	`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`" . $order_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`" . $order_table . "_events`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`" . $order_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
										`" . $order_table . "_events`.`message`='" . mysqli_real_escape_string($conn, $order_name . "-Auftragshistory, Nachricht erstellt, ID [#" . $_SESSION["history"]["id"] . "]") . "', 
										`" . $order_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, $order_name . "-Auftragshistory, Nachricht erstellt, ID [#" . $_SESSION["history"]["id"] . "]") . "', 
										`" . $order_table . "_events`.`body`='" . mysqli_real_escape_string($conn, $message) . "', 
										`" . $order_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

	}

	$_POST['edit'] = "bearbeiten";

?>