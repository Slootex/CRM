<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

if(strip_tags($param['password']) == $maindata['url_password']){

	$csv_data = "";

	$arr_fromthiscar = array('Nein', 'Ja');

	$arr_gender = array('Herr', 'Frau');

	$arr_differing_shipping_address = array('Nein', 'Ja');

	$arr_source = array('Anruf', 'Webseite', 'E-Mail', 'Sonstige');

	$arr_radio_shipping = array('Express', 'Standard', 'International', 'Abholung');

	$arr_radio_payment = array('Überweisung', 'Nachnahme', 'Bar');

	$arr_intern_radio_paying = array('Netto', 'Brutto');

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`order_orders` 
									WHERE 		`order_orders`.`booking`='1' 
									AND 		`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	while($row = $result->fetch_array(MYSQLI_ASSOC)){

		$row_reason = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `reasons` WHERE `reasons`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `reasons`.`id`='" . $row['component'] . "'"), MYSQLI_ASSOC);
		$row_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . mysqli_real_escape_string($conn, intval($row['country'])) . "'"), MYSQLI_ASSOC);
		$row_differing_country = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `countries` WHERE `countries`.`id`='" . mysqli_real_escape_string($conn, intval($row['differing_country'])) . "'"), MYSQLI_ASSOC);

		$csv_data .= 	($csv_data != "" ? "\r\n" : "") . 

						"\"" . $row['id'] . "\";" . 
						"\"" . $row['mode'] . "\";" . 
						"\"" . $row['order_number'] . "\";" . 
						"\"" . $row['admin_id'] . "\";" . 
						"\"" . $row['user_id'] . "\";" . 
						"\"" . $row['interested_id'] . "\";" . 
						"\"" . $row['ref_number'] . "\";" . 
						"\"" . $row['customer_number'] . "\";" . 
						"\"" . date("d.m.Y", $row['call_date']) . "\";" . 
						"\"\";" . 
						"\"0\";" . 
						"\"" . $row['machine'] . "\";" . 
						"\"" . $row['constructionyear'] . "\";" . 
						"\"" . strtoupper($row['carid']) . "\";" . 
						"\"" . $row['kw'] . "\";" . 
						"\"" . number_format(intval($row['mileage']), 0, '', '.') . " km\";" . 
						"\"" . $row_reason['name'] . "\";" . 
						"\"" . $row['manufacturer'] . "\";" . 
						"\"" . $row['serial'] . "\";" . 
						"\"" . $arr_fromthiscar[$row['fromthiscar']] . "\";" . 
						"\"" . $row['reason'] . "\";" . 
						"\"" . $row['description'] . "\";" . 
						"\"" . str_replace("\r\n", "<br>", $row['files']) . "\";" . 
						"\"" . str_replace("\r\n", "<br>", $row['audio']) . "\";" . 
						"\"" . $row['companyname'] . "\";" . 
						"\"" . $arr_gender[$row['gender']] . "\";" . 
						"\"" . $row['firstname'] . "\";" . 
						"\"" . $row['lastname'] . "\";" . 
						"\"" . $row['street'] . "\";" . 
						"\"" . $row['streetno'] . "\";" . 
						"\"" . $row['zipcode'] . "\";" . 
						"\"" . $row['city'] . "\";" . 
						"\"" . $row_country['name'] . "\";" . 
						"\"" . $row['phonenumber'] . "\";" . 
						"\"" . $row['mobilnumber'] . "\";" . 
						"\"" . $row['email'] . "\";" . 
						"\"" . $arr_differing_shipping_address[$row['differing_shipping_address']] . "\";" . 
						"\"" . $row['differing_companyname'] . "\";" . 
						"\"" . $arr_gender[$row['differing_gender']] . "\";" . 
						"\"" . $row['differing_firstname'] . "\";" . 
						"\"" . $row['differing_lastname'] . "\";" . 
						"\"" . $row['differing_street'] . "\";" . 
						"\"" . $row['differing_streetno'] . "\";" . 
						"\"" . $row['differing_zipcode'] . "\";" . 
						"\"" . $row['differing_city'] . "\";" . 
						"\"" . $row_differing_country['name'] . "\";" . 
						"\"" . $arr_source[$row['source']] . "\";" . 
						"\"0\";" . 
						"\"" . $row['pricemwst'] . "\";" . 
						"\"" . $arr_radio_shipping[$row['radio_shipping']] . "\";" . 
						"\"" . $arr_radio_payment[$row['radio_payment']] . "\";" . 
						"\"" . $row['intern_time'] . "\";" . 
						"\"" . $row['intern_conversation_partner'] . "\";" . 
						"\"" . $row['intern_price_total'] . "\";" . 
						"\"" . $arr_intern_radio_paying[$row['intern_radio_paying']] . "\";" . 
						"\"" . date("d.m.Y", intval($row['intern_birthday'])) . "\";" . 
						"\"" . str_replace("\r\n", "<br>", $row['intern_description']) . "\";" . 
						"\"" . str_replace("\r\n", "<br>", $row['intern_tech_info']) . "\";" . 
						"\"" . date("d.m.Y", $row['run_date']) . "\";" . 
						"\"" . date("d.m.Y", $row['reg_date']) . "\";" . 
						"\"" . date("d.m.Y", $row['upd_date']) . "\";" . 
						"\"1\"";

		mysqli_query($conn, "	UPDATE	`order_orders` 
								SET 	`order_orders`.`booking`=2 
								WHERE 	`order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($row['id'])) . "' 
								AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	}

	if($csv_data != ""){
		$f = fopen("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/buchhaltung/auftraege.csv", "w");
		fwrite($f, $csv_data);
		fclose($f);
	}

}else{

	header("HTTP/1.0 404 Not Found");

	echo "Fehlerhafte Anfrage!\n";

}

?>