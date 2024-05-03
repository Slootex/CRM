<?php 

	$time = time();

	if(strlen($_POST['order_number']) > 20){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Auftragsnummer ein. (max. 20 Zeichen)</small><br />\n";
		$inp_order_number = " is-invalid";
	} else {
		$order_number = strip_tags($_POST['order_number']);
		$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT `order_orders`.`id` AS id FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`order_number`='" . mysqli_real_escape_string($conn, $order_number) . "'"), MYSQLI_ASSOC);
		if(isset($row_order['id']) && $row_order['id'] > 0){
			$order_id = $row_order['id'];
		}
	}

	if(strlen($_POST['item_number']) > 20){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie Artikelnummer ein. (max. 20 Zeichen)</small><br />\n";
		$inp_item_number = " is-invalid";
	} else {
		$item_number = strip_tags($_POST['item_number']);
	}

	if(strlen($_POST['suppliers']) < 1 || strlen($_POST['suppliers']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie ein Lieferant aus.</small><br />\n";
		$inp_suppliers = " is-invalid";
	} else {
		$suppliers = intval($_POST['suppliers']);
	}

	if(strlen($_POST['supplier']) > 20){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie den Lieferant an. (max. 20 Zeichen)</small><br />\n";
		$inp_supplier = " is-invalid";
	} else {
		$supplier = strip_tags($_POST['supplier']);
	}

	if(strlen($_POST['description']) > 1024){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Beschreibung ein. (max. 1024 Zeichen)</small><br />\n";
		$inp_description = " is-invalid";
	} else {
		$description = strip_tags($_POST['description']);
	}

	if(strlen($_POST['contact_emails']) < 1){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie an wie oft Angeschrieben wurde.</small><br />\n";
		$inp_contact_emails = " is-invalid";
	} else {
		$contact_emails = intval($_POST['contact_emails']);
	}

	if(strlen($_POST['info']) > 1024){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Info ein. (max. 1024 Zeichen)</small><br />\n";
		$inp_info = " is-invalid";
	} else {
		$info = strip_tags($_POST['info']);
	}

	if(strlen($_POST['price']) > 20){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Preis ein.</small><br />\n";
		$inp_price = " is-invalid";
	} else {
		$price = str_replace(",", ".", $_POST['price']);
	}

	if(strlen($_POST['radio_payment']) < 1 || strlen($_POST['radio_payment']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie eine Zahlart aus.</small><br />\n";
		$inp_radio_payment = " is-invalid";
	} else {
		$radio_payment = intval($_POST['radio_payment']);
	}

	if(strlen($_POST['url']) > 512){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Link ein. (max. 512 Zeichen)</small><br />\n";
		$inp_url = " is-invalid";
	} else {
		$url = strip_tags($_POST['url']);
	}

	if($_POST['email'] == "" || preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,26})$/", $_POST['email'])){
		$email = strip_tags($_POST['email']);
	} else {
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine E-Mail-Adresse ein.</small><br />\n";
		$inp_email = " is-invalid";
	}

	if(strlen($_POST['phonenumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Telefonnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_phonenumber = " is-invalid";
	} else {
		$phonenumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['phonenumber']));
	}

	if(strlen($_POST['faxlnumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Faxnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_faxnumber = " is-invalid";
	} else {
		$faxnumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['faxnumber']));
	}

	if(strlen($_POST['retoure_carrier']) < 1 || strlen($_POST['retoure_carrier']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie ein Retouredienst aus.</small><br />\n";
		$inp_retoure_carrier = " is-invalid";
	} else {
		$retoure_carrier = intval($_POST['retoure_carrier']);
	}

	if(strlen($_POST['shipping_id']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Link ein. (max. 256 Zeichen)</small><br />\n";
		$inp_shipping_id = " is-invalid";
	} else {
		$shipping_id = strip_tags($_POST['shipping_id']);
	}

	if($emsg == ""){

		mysqli_query($conn, "	UPDATE 	`shopping_shoppings` 
								SET 	`shopping_shoppings`.`creator_id`='" . mysqli_real_escape_string($conn, intval(isset($_POST['creator_id']) ? $_POST['creator_id'] : 0)) . "', 
										`shopping_shoppings`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`shopping_shoppings`.`order_number`='" . mysqli_real_escape_string($conn, $order_number) . "', 
										`shopping_shoppings`.`order_id`='" . mysqli_real_escape_string($conn, $order_id) . "', 
										`shopping_shoppings`.`item_number`='" . mysqli_real_escape_string($conn, $item_number) . "', 
										`shopping_shoppings`.`suppliers`='" . mysqli_real_escape_string($conn, $suppliers) . "', 
										`shopping_shoppings`.`supplier`='" . mysqli_real_escape_string($conn, $supplier) . "', 
										`shopping_shoppings`.`description`='" . mysqli_real_escape_string($conn, $description) . "', 
										`shopping_shoppings`.`contact_emails`='" . mysqli_real_escape_string($conn, $contact_emails) . "', 
										`shopping_shoppings`.`info`='" . mysqli_real_escape_string($conn, $info) . "', 
										`shopping_shoppings`.`price`='" . mysqli_real_escape_string($conn, $price) . "', 
										`shopping_shoppings`.`radio_payment`='" . mysqli_real_escape_string($conn, $radio_payment) . "', 
										`shopping_shoppings`.`url`='" . mysqli_real_escape_string($conn, $url) . "', 
										`shopping_shoppings`.`email`='" . mysqli_real_escape_string($conn, $email) . "', 
										`shopping_shoppings`.`phonenumber`='" . mysqli_real_escape_string($conn, $phonenumber) . "', 
										`shopping_shoppings`.`faxnumber`='" . mysqli_real_escape_string($conn, $faxnumber) . "', 
										`shopping_shoppings`.`retoure_carrier`='" . mysqli_real_escape_string($conn, $retoure_carrier) . "', 
										`shopping_shoppings`.`shipping_id`='" . mysqli_real_escape_string($conn, $shipping_id) . "', 
										`shopping_shoppings`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "' 
								WHERE 	`shopping_shoppings`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
								AND 	`shopping_shoppings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		mysqli_query($conn, "	INSERT 	`" . $shopping_table . "_events` 
								SET 	`" . $shopping_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`" . $shopping_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`" . $shopping_table . "_events`.`shopping_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`" . $shopping_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
										`" . $shopping_table . "_events`.`message`='" . mysqli_real_escape_string($conn, $shopping_name . ", Einkaufsdaten geändert, ID [#" . intval($_POST["id"]) . "]") . "', 
										`" . $shopping_table . "_events`.`subject`='" . mysqli_real_escape_string($conn, $shopping_name . ", Einkaufsdaten geändert, ID [#" . intval($_POST["id"]) . "]") . "', 
										`" . $shopping_table . "_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
										`" . $shopping_table . "_events`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		if(isset($_FILES['file_image']['name'])){
			move_uploaded_file($_FILES["file_image"]["tmp_name"], "uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/shopping/url_" . intval($_POST['id']) . ".pdf");
		}
			
		$emsg = "<p>Der Einkauf wurde erfolgreich geändert!</p>\n";

		if($parameter['shopping_move'] == "Archiv"){

			$_POST['move'] = "Archiv";

		}

	}

	$_POST['edit'] = "bearbeiten";

?>