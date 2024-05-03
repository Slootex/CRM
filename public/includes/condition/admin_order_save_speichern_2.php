<?php 

	use setasign\Fpdi\Fpdi;

	require_once('includes/fpdf/fpdf.php');
	require_once('includes/fpdi/code39.php');
	require_once('includes/fpdi/autoload.php');

	if(strlen($_POST['companyname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Firmenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_companyname = " is-invalid";
	} else {
		$companyname = strip_tags($_POST['companyname']);
	}

	if(strlen($_POST['firstname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Vorname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_firstname = " is-invalid";
	} else {
		$firstname = strip_tags($_POST['firstname']);
	}

	if(strlen($_POST['lastname']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Nachname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_lastname = " is-invalid";
	} else {
		$lastname = strip_tags($_POST['lastname']);
	}

	if(strlen($_POST['street']) > 256){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Straßenname ein. (max. 256 Zeichen)</small><br />\n";
		$inp_street = " is-invalid";
	} else {
		$street = strip_tags($_POST['street']);
	}

	if(strlen($_POST['streetno']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Hausnummer ein. (max. 10 Zeichen)</small><br />\n";
		$inp_streetno = " is-invalid";
	} else {
		$streetno = strip_tags($_POST['streetno']);
	}

	if(strlen($_POST['zipcode']) > 10){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Postleitzahl ein. (max. 10 Zeichen)</small><br />\n";
		$inp_zipcode = " is-invalid";
	} else {
		$zipcode = strip_tags($_POST['zipcode']);
	}

	if(strlen($_POST['city']) > 128){
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

	if($_POST['email'] == "" || preg_match("/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,26})$/", $_POST['email'])){
		$email = strip_tags($_POST['email']);
	} else {
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre E-Mail-Adresse ein.</small><br />\n";
		$inp_email = " is-invalid";
	}

	if(isset($_POST['differing_shipping_address']) && (intval($_POST['differing_shipping_address']) > 1 || intval($_POST['differing_shipping_address']) < 0)){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie hier ob eine abweichender Lieferadresse verwendet werden soll. (max. 1 Zeichen)</small><br />\n";
		$inp_differing_shipping_address = " is-invalid";
	} else {
		$differing_shipping_address = (isset($_POST['differing_shipping_address']) ? intval($_POST['differing_shipping_address']) : 0);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_companyname']) > 256) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_companyname']) > 256))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Firmenname der abweichender Lieferadresse ein. (max. 256 Zeichen)</small><br />\n";
		$inp_differing_companyname = " is-invalid";
	} else {
		$differing_companyname = strip_tags($_POST['differing_companyname']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_firstname']) > 256) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_firstname']) > 256))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Vorname der abweichender Lieferadresse ein. (max. 256 Zeichen)</small><br />\n";
		$inp_differing_firstname = " is-invalid";
	} else {
		$differing_firstname = strip_tags($_POST['differing_firstname']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_lastname']) > 256) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_lastname']) > 256))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Nachname der abweichender Lieferadresse ein. (max. 256 Zeichen)</small><br />\n";
		$inp_differing_lastname = " is-invalid";
	} else {
		$differing_lastname = strip_tags($_POST['differing_lastname']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_street']) > 256) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_street']) > 256))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Straßenname der abweichender Lieferadresse ein. (max. 256 Zeichen)</small><br />\n";
		$inp_differing_street = " is-invalid";
	} else {
		$differing_street = strip_tags($_POST['differing_street']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['streetno']) > 10) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_streetno']) > 10))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Hausnummer der abweichender Lieferadresse ein. (max. 10 Zeichen)</small><br />\n";
		$inp_differing_streetno = " is-invalid";
	} else {
		$differing_streetno = strip_tags($_POST['differing_streetno']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_zipcode']) > 10) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_zipcode']) > 10))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihre Postleitzahl der abweichender Lieferadresse ein. (max. 10 Zeichen)</small><br />\n";
		$inp_differing_zipcode = " is-invalid";
	} else {
		$differing_zipcode = strip_tags($_POST['differing_zipcode']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_city']) > 128) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_city']) > 128))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihren Ort der abweichender Lieferadresse ein. (max. 128 Zeichen)</small><br />\n";
		$inp_differing_city = " is-invalid";
	} else {
		$differing_city = strip_tags($_POST['differing_city']);
	}

	if((!isset($_POST['differing_shipping_address']) && strlen($_POST['differing_country']) > 11) || (isset($_POST['differing_shipping_address']) && $_POST['differing_shipping_address'] == 1 && (strlen($_POST['differing_country']) > 11))){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ihr Land der abweichender Lieferadresse ein. (max. 11 Zeichen)</small><br />\n";
		$inp_differing_country = " is-invalid";
	} else {
		$differing_country = intval($_POST['differing_country']);
	}

	if(strlen($_POST['pricemwst']) > 20){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie ein Betrag ein.</small><br />\n";
		$inp_pricemwst = " is-invalid";
	} else {
		$pricemwst = str_replace(",", ".", $_POST['pricemwst']);
	}

	if(strlen($_POST['radio_shipping']) < 1 || strlen($_POST['radio_shipping']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie den Typ für den DE Rückversand.</small><br />\n";
		$inp_radio_shipping = " is-invalid";
	} else {
		$radio_shipping = intval($_POST['radio_shipping']);
	}

	if(strlen($_POST['radio_payment']) < 1 || strlen($_POST['radio_payment']) > 1){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie die Bezahlungsart.</small><br />\n";
		$inp_radio_payment = " is-invalid";
	} else {
		$radio_payment = intval($_POST['radio_payment']);
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

	$sumsize = 0;

	$upload_max_filesize = (int)ini_get("upload_max_filesize");

	$j = 1;

	$allowed = explode(",", str_replace(".", "", str_replace(", ", ",", $maindata['input_file_accept'])));

	if(isset($_FILES["file"]["error"])){
		foreach($_FILES["file"]["error"] as $key => $error) {
			if ($j <= 5 && $_FILES["file"]["name"][$key] != "") {
				$ext = pathinfo($_FILES["file"]["name"][$key], PATHINFO_EXTENSION);
				if(in_array($ext, $allowed)){
					$sumsize+=filesize($_FILES["file"]["tmp_name"][$key]);
				}
			}
			$j++;
		}
		if($sumsize > $upload_max_filesize * 1024 * 1024){
			$emsg = "<p>Die upload Datengröße ist zu hoch. Es sind nur " . $upload_max_filesize . "MB insgesammt erlaubt!</p>";
		}
	}

	if($emsg == ""){

		$hash = $order_hash != "" ? bin2hex(random_bytes(32)) : "";

		$row_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "'"), MYSQLI_ASSOC);
		$row_reason = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `reasons` WHERE `reasons`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `reasons`.`id`='" . mysqli_real_escape_string($conn, intval($component)) . "'"), MYSQLI_ASSOC);
		$row_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . mysqli_real_escape_string($conn, intval($country)) . "'"), MYSQLI_ASSOC);
		$row_differing_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . mysqli_real_escape_string($conn, intval($differing_country)) . "'"), MYSQLI_ASSOC);

		$time = time();

		$order_number = 0;

		while($order_number == 0){

			$random = rand(10001, 99999);

			$result = mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`order_number`='" . $random . "'");

			if($result->num_rows == 0){
				$order_number = $random;
			}

		}

		mkdir("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $order_number, 0777);
		mkdir("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $order_number . "/userdata", 0777);
		copy("includes/.htaccess", "uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $order_number . "/userdata/.htaccess");
		mkdir("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $order_number . "/document", 0777);
		copy("includes/.htaccess", "uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $order_number . "/document/.htaccess");
		mkdir("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $order_number . "/audio", 0777);
		copy("includes/.htaccess", "uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $order_number . "/audio/.htaccess");

		$domain = isset($_SERVER['HTTPS']) ? "https://" . $_SERVER['HTTP_HOST'] : "http://" . $_SERVER['HTTP_HOST'];

		$uploaddir = 'uploads/';

		$files = "";
		$links = "";
		$docs = "";

		$j = 1;

		$_SESSION["files"] = array();

		$allowed = explode(",", str_replace(".", "", str_replace(", ", ",", $maindata['input_file_accept'])));

		if(isset($_FILES["file"]["error"])){
			foreach($_FILES["file"]["error"] as $key => $error) {
				if ($j <= 5 && $_FILES["file"]["name"][$key] != "") {
					$ext = pathinfo($_FILES["file"]["name"][$key], PATHINFO_EXTENSION);
					if(in_array($ext, $allowed)){
						$random = rand(1, 100000);
						$_FILES["file"]["name"][$key] = preg_replace("/[^a-z0-9\_\-\.]/i", '', strip_tags(basename($_FILES["file"]["name"][$key])));
						move_uploaded_file($_FILES["file"]["tmp_name"][$key], $uploaddir . "company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $order_number . "/document/" . basename($random . '_' . $_FILES["file"]["name"][$key]));
						$files .= $files == "" ? $random . '_' . $_FILES["file"]["name"][$key] : "\r\n" . $random . '_' . $_FILES["file"]["name"][$key];
						$links .= $links == "" ? "<a href=\"" . $domain . "/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $order_number . "/document/" . $random . '_' . $_FILES["file"]["name"][$key] . "\">" . $random . '_' . $_FILES["file"]["name"][$key] . "</a>\n" : "<br /><a href=\"" . $domain . "/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/order/" . $order_number . "/document/" . $random . '_' . $_FILES["file"]["name"][$key] . "\">" . $random . '_' . $_FILES["file"]["name"][$key] . "</a>\n";
						$docs .= $docs == "" ? $random . '_' . $_FILES["file"]["name"][$key] : ", " . $random . '_' . $_FILES["file"]["name"][$key];
						$_SESSION["files"][] = $random . '_' . $_FILES["file"]["name"][$key];
					}
				}
				$j++;
			}
		}

		mysqli_query($conn, "	INSERT 	`order_orders` 
								SET 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`order_orders`.`mode`='" . mysqli_real_escape_string($conn, $order_mode) . "', 
										`order_orders`.`order_number`='" . mysqli_real_escape_string($conn, $order_number) . "', 
										`order_orders`.`creator_id`='" . mysqli_real_escape_string($conn, intval(isset($_POST['admin_id']) ? $_POST['admin_id'] : 0)) . "', 
										`order_orders`.`admin_id`='" . mysqli_real_escape_string($conn, intval(isset($_POST['admin_id']) ? $_POST['admin_id'] : 0)) . "', 

										`order_orders`.`companyname`='" . mysqli_real_escape_string($conn, $companyname) . "', 
										`order_orders`.`gender`='" . mysqli_real_escape_string($conn, intval(isset($_POST['gender']) ? $_POST['gender'] : 0)) . "', 
										`order_orders`.`firstname`='" . mysqli_real_escape_string($conn, $firstname) . "', 
										`order_orders`.`lastname`='" . mysqli_real_escape_string($conn, $lastname) . "', 
										`order_orders`.`street`='" . mysqli_real_escape_string($conn, $street) . "', 
										`order_orders`.`streetno`='" . mysqli_real_escape_string($conn, $streetno) . "', 
										`order_orders`.`zipcode`='" . mysqli_real_escape_string($conn, $zipcode) . "', 
										`order_orders`.`city`='" . mysqli_real_escape_string($conn, $city) . "', 
										`order_orders`.`country`='" . mysqli_real_escape_string($conn, $country) . "', 
										`order_orders`.`phonenumber`='" . mysqli_real_escape_string($conn, $phonenumber) . "', 
										`order_orders`.`mobilnumber`='" . mysqli_real_escape_string($conn, $mobilnumber) . "', 
										`order_orders`.`email`='" . mysqli_real_escape_string($conn, $email) . "', 
										`order_orders`.`differing_shipping_address`='" . mysqli_real_escape_string($conn, $differing_shipping_address) . "', 
										`order_orders`.`differing_companyname`='" . mysqli_real_escape_string($conn, $differing_companyname) . "', 
										`order_orders`.`differing_gender`='" . mysqli_real_escape_string($conn, intval(isset($_POST['differing_gender']) ? $_POST['differing_gender'] : 0)) . "', 
										`order_orders`.`differing_firstname`='" . mysqli_real_escape_string($conn, $differing_firstname) . "', 
										`order_orders`.`differing_lastname`='" . mysqli_real_escape_string($conn, $differing_lastname) . "', 
										`order_orders`.`differing_street`='" . mysqli_real_escape_string($conn, $differing_street) . "', 
										`order_orders`.`differing_streetno`='" . mysqli_real_escape_string($conn, $differing_streetno) . "', 
										`order_orders`.`differing_zipcode`='" . mysqli_real_escape_string($conn, $differing_zipcode) . "', 
										`order_orders`.`differing_city`='" . mysqli_real_escape_string($conn, $differing_city) . "', 
										`order_orders`.`differing_country`='" . mysqli_real_escape_string($conn, $differing_country) . "', 

										`order_orders`.`source`='" . mysqli_real_escape_string($conn, intval(isset($_POST['source']) ? $_POST['source'] : 0)) . "', 

										`order_orders`.`pricemwst`='" . mysqli_real_escape_string($conn, $pricemwst) . "', 
										`order_orders`.`radio_shipping`='" . mysqli_real_escape_string($conn, intval(isset($_POST['radio_shipping']) ? $_POST['radio_shipping'] : 0)) . "', 
										`order_orders`.`radio_payment`='" . mysqli_real_escape_string($conn, intval(isset($_POST['radio_payment']) ? $_POST['radio_payment'] : 0)) . "', 

										`order_orders`.`reason`='" . mysqli_real_escape_string($conn, $reason) . "', 
										`order_orders`.`description`='" . mysqli_real_escape_string($conn, $description) . "', 

										`order_orders`.`files`='" . mysqli_real_escape_string($conn, $files) . "', 

										`order_orders`.`ref_number`='" . mysqli_real_escape_string($conn, ($ref_number != "" ? $ref_number : $order_number)) . "', 
										`order_orders`.`customer_number`='" . mysqli_real_escape_string($conn, $customer_number) . "', 
										`order_orders`.`call_date`='" . mysqli_real_escape_string($conn, strtotime($call_date)) . "', 

										`order_orders`.`public`='1', 
										`order_orders`.`hash`='" . mysqli_real_escape_string($conn, strip_tags($hash)) . "', 
										`order_orders`.`transfer_date`='" . mysqli_real_escape_string($conn, intval($order_mode == 0 ? $time : 0)) . "', 
										`order_orders`.`run_date`='" . mysqli_real_escape_string($conn, intval($_POST['run_date'])) . "', 
										`order_orders`.`reg_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
										`order_orders`.`cpy_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', 
										`order_orders`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$_POST["id"] = $conn->insert_id;

		mysqli_query($conn, "	DELETE FROM `order_orders_questions` 
								WHERE 		`order_orders_questions`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								AND 		`order_orders_questions`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

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

		$j = 1;

		foreach($_SESSION["files"] as $key => $val) {
			if ($j <= 5 && $_SESSION["files"][$key] != "") {
				mysqli_query($conn, "	INSERT 	`order_orders_files` 
										SET 	`order_orders_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
												`order_orders_files`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
												`order_orders_files`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
												`order_orders_files`.`type`='0', 
												`order_orders_files`.`file`='" . mysqli_real_escape_string($conn, $_SESSION["files"][$key]) . "', 
												`order_orders_files`.`upd_date`='" . mysqli_real_escape_string($conn, intval($time)) . "'");
			}
			$j++;
		}

		$links = $links == "" ? "" : "	<table cellspacing=\"3\" cellpadding=\"3\" border=\"0\"><tr><td width=\"200\" valign=\"top\"><span>Dateien:</span></td><td>" . $links . "</td></tr></table><br />\n";

		$row_status = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`id`='" . mysqli_real_escape_string($conn, intval($maindata[$parameter['order_status_intern']])) . "'"), MYSQLI_ASSOC);

		$row_template = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `templates` WHERE `templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `templates`.`id`='" . mysqli_real_escape_string($conn, intval($row_status['email_template'])) . "'"), MYSQLI_ASSOC);

		$row_template['body'] .= $row_admin['email_signature'];

		$questions = array();

		$result_qa = mysqli_query($conn, "	SELECT 		* 
											FROM 		`order_orders_questions` 
											WHERE 		`order_orders_questions`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
											AND 		`order_orders_questions`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
											ORDER BY 	CAST(`order_orders_questions`.`id` AS UNSIGNED) ASC");

		while($row_qa = $result_qa->fetch_array(MYSQLI_ASSOC)){
			$questions['question_' . $row_qa['question_id']] = $row_qa['answer_id'];
		}

		$result_pq_1 = mysqli_query($conn, "	SELECT 		`questions`.`id` AS id, 
															`questions`.`name` AS name, 
															`questions`.`title` AS title, 
															`questions`.`imagepath` AS imagepath, 
															`questions`.`hash` AS hash, 
															`questions`.`pos` AS pos 
												FROM 		`questions` 
												WHERE 		`questions`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
												AND 		`questions`.`parent_id`='0' 
												AND 		`questions`.`category_id`='1' 
												AND 		`questions`.`enable`='1' 
												ORDER BY 	CAST(`questions`.`pos` AS UNSIGNED) ASC");

		$question_str = "<table cellspacing=\"1\" cellpadding=\"1\">\n";

		while($row_pq_1 = $result_pq_1->fetch_array(MYSQLI_ASSOC)){

			$question_str .= 	"	<tr>\n" . 
								"		<td>" . $row_pq_1['title'] . "</td>\n" . 
								"		<td>\n";

			$result_sq_1 = mysqli_query($conn, "	SELECT 		`questions`.`id` AS id, 
																`questions`.`name` AS name, 
																`questions`.`title` AS title, 
																`questions`.`imagepath` AS imagepath, 
																`questions`.`hash` AS hash, 
																`questions`.`pos` AS pos 
													FROM 		`questions` 
													WHERE 		`questions`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
													AND 		`questions`.`parent_id`='" . mysqli_real_escape_string($conn, intval($row_pq_1['id'])) . "' 
													AND 		`questions`.`category_id`='1' 
													AND 		`questions`.`enable`='1' 
													ORDER BY 	CAST(`questions`.`pos` AS UNSIGNED) ASC");

			while($row_sq_1 = $result_sq_1->fetch_array(MYSQLI_ASSOC)){
				$question_str .= 	"			<input type=\"radio\" name=\"answer_" . $row_sq_1['id'] . "\"" . (isset($questions['question_' . $row_pq_1['id']]) && intval($questions['question_' . $row_pq_1['id']]) == $row_sq_1['id'] ? " checked=\"checked\"" : "") . " value=\"1\" /><strong>" . $row_sq_1['title'] . "</strong><br />\n";
			}

			$question_str .= 	"		</td>\n" . 
								"	</tr>\n";

		}

		$question_str .= 	"</table>\n";

		$status_number = intval($_SESSION["admin"]["id"]) . "A" . date("dmYHis", time());

		$fields = array('subject', 'body', 'admin_mail_subject');

		for($j = 0;$j < count($fields);$j++){

			$row_template[$fields[$j]] = str_replace("[status_id]", $status_number, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[status]", $row_status["name"], $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[id]", $order_number, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[date]", date("d.m.Y (H:i)", $time), $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[hash]", $hash, $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[companyname]", $companyname, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[gender]", (isset($_POST['gender']) && $_POST['gender'] == 1 ? "Sehr geehrte Frau" : "Sehr geehrter Herr"), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[sexual]", (isset($_POST['gender']) && $_POST['gender'] == 1 ? "Frau" : "Herr"), $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[firstname]", $firstname, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[lastname]", $lastname, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[street]", $street, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[streetno]", $streetno, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[zipcode]", $zipcode, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[city]", $city, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[country]", $row_country['name'], $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[phonenumber]", $phonenumber, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[mobilnumber]", $mobilnumber, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[email]", "<a href=\"mailto: " . $email . "\">" . $email . "</a>\n", $row_template[$fields[$j]]);

			$differing_shipping_address = 	$differing_shipping_address == 0 ? 
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
			$row_template[$fields[$j]] = str_replace("[differing_companyname]", $differing_companyname, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_firstname]", $differing_firstname, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_lastname]", $differing_lastname, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_street]", $differing_street, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_streetno]", $differing_streetno, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_zipcode]", $differing_zipcode, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_city]", $differing_city, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[differing_country]", $row_differing_country['name'], $row_template[$fields[$j]]);

			$question_str = "<table cellspacing=\"1\" cellpadding=\"1\">\n" . 
							"	<tr>\n" . 
							"		<td width=\"200\" valign=\"top\"><u>Fragen</u></td>\n" . 
							"		<td>\n" . 

							$question_str . 

							"		</td>\n" . 
							"	</tr>\n" . 
							"</table>\n";
			$row_template[$fields[$j]] = str_replace("[question]", $question_str, $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[pricemwst]", number_format($pricemwst, 2, ',', '') . " €", $row_template[$fields[$j]]);
			$radio_radio_shipping = array(	0 => "Expressversand", 
											1 => "Standardversand", 
											2 => "International", 
											3 => "Abholung");
			$row_template[$fields[$j]] = str_replace("[radio_shipping]", $radio_radio_shipping[$radio_shipping], $row_template[$fields[$j]]);
			$radio_radio_payment = array(	0 => "Überweisung (Sie überweisen den Rechnungsbetrag per Überweisung)", 
											1 => "Nachnahme", 
											2 => "Bar");
			$row_template[$fields[$j]] = str_replace("[radio_payment]", $radio_radio_payment[$radio_payment], $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[reason]", $reason, $row_template[$fields[$j]]);
			$row_template[$fields[$j]] = str_replace("[description]", $description, $row_template[$fields[$j]]);

			$row_template[$fields[$j]] = str_replace("[files]", $links, $row_template[$fields[$j]]);

		}

		mysqli_query($conn, "	INSERT 	`" . $order_table . "_statuses` 
								SET 	`" . $order_table . "_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`" . $order_table . "_statuses`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`" . $order_table . "_statuses`.`status_number`='" . mysqli_real_escape_string($conn, $status_number) . "', 
										`" . $order_table . "_statuses`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`" . $order_table . "_statuses`.`status_id`='" . mysqli_real_escape_string($conn, intval($row_status['id'])) . "', 
										`" . $order_table . "_statuses`.`template`='" . mysqli_real_escape_string($conn, $row_template['name']) . "', 
										`" . $order_table . "_statuses`.`subject`='" . mysqli_real_escape_string($conn, $row_template['subject']) . "', 
										`" . $order_table . "_statuses`.`body`='" . mysqli_real_escape_string($conn, $row_template['body']) . "', 
										`" . $order_table . "_statuses`.`public`='1', 
										`" . $order_table . "_statuses`.`time`='" . mysqli_real_escape_string($conn, intval($time)) . "'");

		$_SESSION["status"]["id"] = $conn->insert_id;

		mysqli_query($conn, "	INSERT 	`" . $order_table . "_events` 
								SET 	`" . $order_table . "_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`" . $order_table . "_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`" . $order_table . "_events`.`" . $order_id_field . "`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`" . $order_table . "_events`.`type`='" . mysqli_real_escape_string($conn, 0) . "', 
										`" . $order_table . "_events`.`message`='" . mysqli_real_escape_string($conn, $order_name . " (Intern), erstellt, ID [#" . $_SESSION["status"]["id"] . "]") . "', 
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

			if($row_status['usermail'] == 1 && $email != ""){

				$mail = new dbbMailer();

				$mail->host = $maindata['smtp_host'];
				$mail->username = $maindata['smtp_username'];
				$mail->password = $maindata['smtp_password'];
				$mail->secure = $maindata['smtp_secure'];
				$mail->port = intval($maindata['smtp_port']);
				$mail->charset = $maindata['smtp_charset'];
 
				$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
				$mail->addAddress($email, $firstname . " " . $lastname);

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

			if($row_status['usermail'] == 1 && $email != ""){

				$mail = new dbbMailer();

				$mail->host = $maindata['smtp_host'];
				$mail->username = $maindata['smtp_username'];
				$mail->password = $maindata['smtp_password'];
				$mail->secure = $maindata['smtp_secure'];
				$mail->port = intval($maindata['smtp_port']);
				$mail->charset = $maindata['smtp_charset'];
 
				$mail->setFrom($row_admin['email'], strip_tags($row_template['from']));
				$mail->addAddress($email, $firstname . " " . $lastname);

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

		$emsg = "<p>Der neue " . $order_name . " wurde erfolgreich hinzugefügt!</p>\n";

		$parameter['link'] = $parameter['link_edit'];

		$_POST["edit"] = "bearbeiten";

	}else{

		$_POST["add"] = "hinzufügen";

	}

?>