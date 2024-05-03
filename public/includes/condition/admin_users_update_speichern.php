<?php 

	$time = time();

	// Schritt 3: Rechnungsanschrift

	if(strlen($_POST['companyname']) < 1 || strlen($_POST['companyname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Firmenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_companyname = " is-invalid";
	} else {
		$companyname = strip_tags($_POST['companyname']);
	}

	if(strlen($_POST['firstname']) < 1 || strlen($_POST['firstname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Vorname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_firstname = " is-invalid";
	} else {
		$firstname = strip_tags($_POST['firstname']);
	}

	if(strlen($_POST['lastname']) < 1 || strlen($_POST['lastname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Nachname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_lastname = " is-invalid";
	} else {
		$lastname = strip_tags($_POST['lastname']);
	}

	if(strlen($_POST['street']) < 1 || strlen($_POST['street']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Straßenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_street = " is-invalid";
	} else {
		$street = strip_tags($_POST['street']);
	}

	if(strlen($_POST['streetno']) < 1 || strlen($_POST['streetno']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Hausnummer ein. (max. 10 Zeichen)</small><br />\n";
		$inp_streetno = " is-invalid";
	} else {
		$streetno = strip_tags($_POST['streetno']);
	}

	if(strlen($_POST['zipcode']) < 1 || strlen($_POST['zipcode']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Postleitzahl ein. (max. 10 Zeichen)</small><br />\n";
		$inp_zipcode = " is-invalid";
	} else {
		$zipcode = strip_tags($_POST['zipcode']);
	}

	if(strlen($_POST['city']) < 1 || strlen($_POST['city']) > 128){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Ort ein. (max. 128 Zeichen)</small><br />\n";
		$inp_city = " is-invalid";
	} else {
		$city = strip_tags($_POST['city']);
	}

	if(strlen($_POST['country']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihr Land ein. (max. 11 Zeichen)</small><br />\n";
		$inp_country = " is-invalid";
	} else {
		$country = intval($_POST['country']);
	}

	if(strlen($_POST['phonenumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Telefonnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_phonenumber = " is-invalid";
	} else {
		$phonenumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['phonenumber']));
	}

	if(strlen($_POST['mobilnumber']) > 100){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Mobilnummer ein. (max. 100 Zeichen)</small><br />\n";
		$inp_mobilnumber = " is-invalid";
	} else {
		$mobilnumber = preg_replace("/[^0-9]/", "", strip_tags($_POST['mobilnumber']));
	}

	if(preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,26})$/", $_POST['email']) && $_POST['email'] != ""){
		$email = strip_tags($_POST['email']);
	} else {
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre E-Mail-Adresse ein.</small><br />\n";
		$inp_email = " is-invalid";
	}

	// Weitere Optionen

	if(strlen($_POST['ref_number']) > 128){
		$emsg .= "<small class=\"error text-muted\">Bitte eine Referenznummer eingeben. (max. 128 Zeichen)</small><br />\n";
		$inp_ref_number = " is-invalid";
	} else {
		$ref_number = strip_tags($_POST['ref_number']);
	}

	if($_POST['password'] != "" && (strlen($_POST['password']) < 8 || strlen($_POST['password']) > 128)){
		$emsg .= "<small class=\"error text-muted\">Bitte ein Kennwort eingeben. (8 - 128 Zeichen)</small><br />\n";
		$inp_password = " is-invalid";
	} else {
		$password = strip_tags($_POST['password']);
	}

	if($emsg == ""){

		mysqli_query($conn, "UPDATE 	`user_users` 
								SET 	`user_users`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`user_users`.`ref_number`='" . mysqli_real_escape_string($conn, $ref_number) . "', 
										`user_users`.`companyname`='" . mysqli_real_escape_string($conn, $companyname) . "', 
										`user_users`.`gender`='" . mysqli_real_escape_string($conn, intval(isset($_POST['gender']) ? $_POST['gender'] : 0)) . "', 
										`user_users`.`firstname`='" . mysqli_real_escape_string($conn, $firstname) . "', 
										`user_users`.`lastname`='" . mysqli_real_escape_string($conn, $lastname) . "', 
										`user_users`.`street`='" . mysqli_real_escape_string($conn, $street) . "', 
										`user_users`.`streetno`='" . mysqli_real_escape_string($conn, $streetno) . "', 
										`user_users`.`zipcode`='" . mysqli_real_escape_string($conn, $zipcode) . "', 
										`user_users`.`city`='" . mysqli_real_escape_string($conn, $city) . "', 
										`user_users`.`country`='" . mysqli_real_escape_string($conn, $country) . "', 
										`user_users`.`phonenumber`='" . mysqli_real_escape_string($conn, $phonenumber) . "', 
										`user_users`.`mobilnumber`='" . mysqli_real_escape_string($conn, $mobilnumber) . "', 
										`user_users`.`email`='" . mysqli_real_escape_string($conn, $email) . "', 
										" . ($password != "" ? "`user_users`.`password`='" . mysqli_real_escape_string($conn, sha1($password)) . "', " : "") . "
										`user_users`.`upd_date`='" . $time . "' 
								WHERE 	`user_users`.`id`='" . intval($_POST['id']) . "' 
								AND 	`user_users`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		mysqli_query($conn, "INSERT 	`user_users_events` 
								SET 	`user_users_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`user_users_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`user_users_events`.`" . $users_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`user_users_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
										`user_users_events`.`message`='" . mysqli_real_escape_string($conn, $users_name . ", Daten geändert, ID [#" . intval($_POST["id"]) . "]") . "', 
										`user_users_events`.`subject`='" . mysqli_real_escape_string($conn, $users_name . ", Daten geändert, ID [#" . intval($_POST["id"]) . "]") . "', 
										`user_users_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
										`user_users_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

		$emsg = "<p>Der " . $users_name . " wurde erfolgreich geändert!</p>\n";

	}

	$_POST['edit'] = "bearbeiten";

?>