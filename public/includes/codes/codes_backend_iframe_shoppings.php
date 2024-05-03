<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "order_orders";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$time = time();

$inp_order_number = "";
$inp_item_number = "";
$inp_suppliers = "";
$inp_supplier = "";
$inp_description = "";
$inp_contact_emails = "";
$inp_info = "";
$inp_price = "";
$inp_radio_payment = "";
$inp_url = "";
$inp_email = "";
$inp_phonenumber = "";
$inp_faxnumber = "";
$inp_retoure_carrier = "";
$inp_shipping_id = "";

$order_number = "";
$order_id = 0;
$item_number = "";
$suppliers = 0;
$supplier = "";
$description = "";
$contact_emails = 0;
$info = "";
$price = 0.00;
$radio_payment = 0;
$url = "";
$email = "";
$phonenumber = "";
$faxnumber = "";
$retoure_carrier = 0;
$shipping_id = "";

$emsg = "";

$list = "";

$text_color = "text-secondary";

$arr_suppliers = array(
	0 => "eBAY", 
	1 => "Allegro", 
	2 => "Webseite", 
	3 => "Amazon", 
	4 => "Technik"
);

$arr_radio_payment = array(
	0 => "bezahlt per PayPal", 
	1 => "bezahlt per Kreditkarte", 
	2 => "bezahlt per Überweisung", 
	3 => "warte auf Rechnung", 
	4 => "storniert"
);

$arr_retoure_carrier = array(
	0 => "DHL", 
	1 => "UPS", 
	2 => "Hermes", 
	3 => "DPD", 
	4 => "TNT"
);

$arr_area = array('Einkauf-Aktiv', 'Einkauf-Archiv', 'Retoure-Aktiv', 'Retoure-Archiv');

$arr_edit_url = array('neue-einkaeufe', 'einkaeufe-archiv', 'neue-retouren', 'retouren-archiv');

if(isset($_POST['update']) && $_POST['update'] == "speichern"){

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
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Artikelnummer ein. (max. 20 Zeichen)</small><br />\n";
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

		if(isset($_FILES['file_image']['name'])){
			move_uploaded_file($_FILES["file_image"]["tmp_name"], "uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/shopping/url_" . intval($_POST['id']) . ".pdf");
		}

		$emsg = "<p>Der/die Einkauf/Retoure wurde erfolgreich geändert!</p>\n";

	}

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['delete']) && $_POST['delete'] == "entfernen"){

	mysqli_query($conn, "	DELETE FROM	`shopping_shoppings` 
							WHERE 		`shopping_shoppings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'
							AND 		`shopping_shoppings`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	mysqli_query($conn, "	DELETE FROM	`shopping_shoppings_emails` 
							WHERE 		`shopping_shoppings_emails`.`shopping_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 		`shopping_shoppings_emails`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`shopping_shoppings_events` 
							WHERE 		`shopping_shoppings_events`.`shopping_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 		`shopping_shoppings_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`shopping_shoppings_statuses` 
							WHERE 		`shopping_shoppings_statuses`.`shopping_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 		`shopping_shoppings_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`shopping_retoures_emails` 
							WHERE 		`shopping_retoures_emails`.`shopping_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 		`shopping_retoures_emails`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`shopping_retoures_events` 
							WHERE 		`shopping_retoures_events`.`shopping_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 		`shopping_retoures_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	mysqli_query($conn, "	DELETE FROM	`shopping_retoures_statuses` 
							WHERE 		`shopping_retoures_statuses`.`shopping_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
							AND 		`shopping_retoures_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

	@unlink("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/shopping/url_" . intval($_POST['id']) . ".pdf");

}

$result = mysqli_query($conn, "	SELECT 		`shopping_shoppings`.`id` AS id, 
											`shopping_shoppings`.`mode` AS mode, 
											`shopping_shoppings`.`creator_id` AS creator_id, 
											`shopping_shoppings`.`order_id` AS order_id, 
											`shopping_shoppings`.`shopping_number` AS shopping_number, 
											`shopping_shoppings`.`order_number` AS order_number, 
											`shopping_shoppings`.`item_number` AS item_number, 
											`shopping_shoppings`.`suppliers` AS suppliers, 
											`shopping_shoppings`.`supplier` AS supplier, 
											`shopping_shoppings`.`description` AS description, 
											`shopping_shoppings`.`contact_emails` AS contact_emails, 
											`shopping_shoppings`.`info` AS info, 
											`shopping_shoppings`.`price` AS price, 
											`shopping_shoppings`.`radio_payment` AS radio_payment, 
											`shopping_shoppings`.`url` AS url, 
											`shopping_shoppings`.`email` AS email, 
											`shopping_shoppings`.`phonenumber` AS phonenumber, 
											`shopping_shoppings`.`faxnumber` AS faxnumber, 
											`shopping_shoppings`.`retoure_carrier` AS retoure_carrier, 
											`shopping_shoppings`.`shipping_id` AS shipping_id, 
											`shopping_shoppings`.`run_date` AS run_date, 
											`shopping_shoppings`.`reg_date` AS reg_date, 
											`shopping_shoppings`.`cpy_date` AS cpy_date, 
											`shopping_shoppings`.`upd_date` AS upd_date, 

											`shopping_shoppings`.`admin_id` AS admin_id 

								FROM 		`shopping_shoppings` 
								WHERE 		`shopping_shoppings`.`order_id`='" . mysqli_real_escape_string($conn, intval($param['id'])) . "' 
								AND 		`shopping_shoppings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								ORDER BY 	CAST(`shopping_shoppings`.`reg_date` AS UNSIGNED) ASC");

while($row_shoppings = $result->fetch_array(MYSQLI_ASSOC)){

	$list .= 	"	<tr" . (isset($_POST['id']) && $_POST['id'] == $row_shoppings['id'] ? " class=\"bg-primary text-white\"" : "") . ">\n" . 
				"		<td width=\"74\" class=\"text-center " . (isset($_POST['id']) && $_POST['id'] == $row_shoppings['id'] ? "" : $text_color) . "\"><small>" . date("d.m.Y", intval($row_shoppings['reg_date'])) . "</small><br /><small class=\"text-muted\">" . date("(H:i)", $row_shoppings['reg_date']) . "</small></td>\n" . 
				"		<td width=\"108\" class=\"text-center " . (isset($_POST['id']) && $_POST['id'] == $row_shoppings['id'] ? "" : $text_color) . "\"><small>" . $row_shoppings['shopping_number'] . "</small></td>\n" . 
				"		<td width=\"118\" class=\"text-center " . (isset($_POST['id']) && $_POST['id'] == $row_shoppings['id'] ? "" : $text_color) . "\"><small><a href=\"/crm/" . $arr_edit_url[$row_shoppings['mode']] . "/bearbeiten/" . $row_shoppings['id'] . "\" class=\"" . (isset($_POST['id']) && $_POST['id'] == $row_shoppings['id'] ? "text-white" : $text_color) . "\" target=\"_blank\">" . $arr_area[$row_shoppings['mode']] . "</a></small></td>\n" . 
				"		<td width=\"150\" class=\"text-center " . (isset($_POST['id']) && $_POST['id'] == $row_shoppings['id'] ? "" : $text_color) . "\"><small>" . $row_shoppings['item_number'] . "</small></td>\n" . 
				"		<td width=\"120\" class=\"text-center " . (isset($_POST['id']) && $_POST['id'] == $row_shoppings['id'] ? "" : $text_color) . "\"><small>" . $arr_suppliers[$row_shoppings['suppliers']] . "</small></td>\n" . 
				"		<td width=\"\" class=\"text-center " . (isset($_POST['id']) && $_POST['id'] == $row_shoppings['id'] ? "" : $text_color) . "\"><small>" . $row_shoppings['supplier'] . "</small></td>\n" . 
				"		<td width=\"60\" class=\"text-center " . (isset($_POST['id']) && $_POST['id'] == $row_shoppings['id'] ? "" : $text_color) . "\"><div style=\"width: 50px;white-space: nowrap;overflow-x: hidden\"><small>" . $row_shoppings['description'] . "</small></div></td>\n" . 
				"		<td width=\"78\" class=\"text-center " . (isset($_POST['id']) && $_POST['id'] == $row_shoppings['id'] ? "" : $text_color) . "\"><small>" . $row_shoppings['contact_emails'] . "</small></td>\n" . 
				"		<td width=\"70\" class=\"text-center " . (isset($_POST['id']) && $_POST['id'] == $row_shoppings['id'] ? "" : $text_color) . "\"><div style=\"width: 60px;white-space: nowrap;overflow-x: hidden\"><small>" . $row_shoppings['info'] . "</small></div></td>\n" . 
				"		<td width=\"92\" class=\"text-center " . (isset($_POST['id']) && $_POST['id'] == $row_shoppings['id'] ? "" : $text_color) . "\"><small>" . number_format($row_shoppings['price'], 2, ',', '') . " &euro;</small></td>\n" . 
				"		<td width=\"50\" class=\"text-center\">\n" . 
				"			<form action=\"" . $page['url'] . "/" . $row_shoppings['order_id'] . "\" method=\"post\">\n" . 
				"				<input type=\"hidden\" name=\"id\" value=\"" . $row_shoppings['id'] . "\" />\n" . 
				"				<button type=\"submit\" name=\"edit\" value=\"bearbeiten\" class=\"btn btn-sm btn-success\"><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>\n" . 
				"			</form>\n" . 
				"		</td>\n" . 
				"	</tr>\n";

}

$shoppings_infos =	"<table class=\"table table-white table-sm table-bordered table-hover mb-0\">\n" . 
					"	<tr class=\"bg-white text-primary\">\n" . 
					"		<th width=\"74\"><small><b>Datum</b></small></th>\n" . 
					"		<th width=\"108\"><small><b>Bestellnummer</b></small></th>\n" . 
					"		<th width=\"118\"><small><b>Bereich</b></small></th>\n" . 
					"		<th width=\"150\"><small><b>Ext. Auftragsnummer</b></small></th>\n" . 
					"		<th width=\"120\"><small><b>Lieferanten</b></small></th>\n" . 
					"		<th width=\"\"><small><b>Lieferant</b></small></th>\n" . 
					"		<th width=\"60\"><small><b>Beschreib.</b></small></th>\n" . 
					"		<th width=\"78\"><small><b>Angeschr.</b></small></th>\n" . 
					"		<th width=\"70\"><small><b>Info</b></small></th>\n" . 
					"		<th width=\"92\"><small><b>Preis</b></small></th>\n" . 
					"		<th width=\"50\" class=\"text-center\"><small><b>Aktion</b></small></th>\n" . 
					"	</tr>\n" . 
					"</table>\n" . 
					"<div class=\"table-responsive\" style=\"height: 360px\">\n" . 
					"<table class=\"table table-white table-sm table-bordered table-hover mb-0\">\n" . 
					"	<tr class=\"bg-white text-primary d-none\">\n" . 
					"		<th width=\"74\"><small><b>Datum</b></small></th>\n" . 
					"		<th width=\"108\"><small><b>Bestellnummer</b></small></th>\n" . 
					"		<th width=\"118\"><small><b>Bereich</b></small></th>\n" . 
					"		<th width=\"150\"><small><b>Ext. Auftragsnummer</b></small></th>\n" . 
					"		<th width=\"120\"><small><b>Lieferanten</b></small></th>\n" . 
					"		<th width=\"\"><small><b>Lieferant</b></small></th>\n" . 
					"		<th width=\"60\"><small><b>Beschreib.</b></small></th>\n" . 
					"		<th width=\"78\"><small><b>Angeschr.</b></small></th>\n" . 
					"		<th width=\"70\"><small><b>Info</b></small></th>\n" . 
					"		<th width=\"92\"><small><b>Preis</b></small></th>\n" . 
					"		<th width=\"50\" class=\"text-center\"><small><b>Aktion</b></small></th>\n" . 
					"	</tr>\n" . 

					$list . 
	
					"</table>\n" . 
					"</div>\n";

$html = "<br />\n" . 

		$shoppings_infos . 

		"<br />\n";

if(isset($_POST['edit']) && $_POST['edit'] == "bearbeiten"){

	$row_shopping = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `shopping_shoppings` WHERE `shopping_shoppings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `shopping_shoppings`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Bearbeiten</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "/" . intval($row_shopping['order_id']) . "\" method=\"post\">\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\" for=\"order_number\">Auftragsnummer</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<input type=\"text\" id=\"order_number\" name=\"order_number\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $order_number : $row_shopping["order_number"]) . "\" class=\"form-control" . $inp_order_number . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\" for=\"item_number\">Externe Auftragsnummer</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<input type=\"text\" id=\"item_number\" name=\"item_number\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $item_number : $row_shopping["item_number"]) . "\" class=\"form-control" . $inp_item_number . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\">Lieferanten</label>\n" . 
				"								<div class=\"col-sm-8 mt-2\">\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"suppliers_0\" name=\"suppliers\" value=\"0\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $_POST['suppliers'] : $row_shopping["suppliers"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"suppliers_0\">\n" . 
				"											eBAY\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"suppliers_1\" name=\"suppliers\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $_POST['suppliers'] : $row_shopping["suppliers"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"suppliers_1\">\n" . 
				"											Allegro\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"suppliers_2\" name=\"suppliers\" value=\"2\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $_POST['suppliers'] : $row_shopping["suppliers"]) == 2 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"suppliers_2\">\n" . 
				"											Webseite\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"suppliers_3\" name=\"suppliers\" value=\"3\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $_POST['suppliers'] : $row_shopping["suppliers"]) == 3 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"suppliers_3\">\n" . 
				"											Amazon\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"suppliers_4\" name=\"suppliers\" value=\"4\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $_POST['suppliers'] : $row_shopping["suppliers"]) == 4 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"suppliers_4\">\n" . 
				"											Technik\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\" for=\"supplier\">Lieferant</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<input type=\"text\" id=\"supplier\" name=\"supplier\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $supplier : $row_shopping["supplier"]) . "\" class=\"form-control" . $inp_supplier . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\" for=\"description\">Beschreibung</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<input type=\"text\" id=\"description\" name=\"description\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $description : $row_shopping["description"]) . "\" class=\"form-control" . $inp_description . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\" for=\"contact_emails\">Angeschrieben</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<input type=\"number\" id=\"contact_emails\" name=\"contact_emails\" min=\"0\" max=\"100000\" step=\"1\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $contact_emails : $row_shopping["contact_emails"]) . "\" class=\"form-control" . $inp_contact_emails . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\" for=\"info\">Info</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<input type=\"text\" id=\"info\" name=\"info\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $info : $row_shopping["info"]) . "\" class=\"form-control" . $inp_info . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\" for=\"price\">Preis</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<div class=\"input-group\">\n" . 
				"										<input type=\"text\" id=\"price\" name=\"price\" value=\"" . number_format(isset($_POST['update']) && $_POST['update'] == "speichern" ? $price : $row_shopping["price"], 2, ',', '') . "\" class=\"form-control" . $inp_price . "\" />\n" . 
				"										<div class=\"input-group-append\"><span class=\"input-group-text\">&euro;</span></div>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\">Zahlart</label>\n" . 
				"								<div class=\"col-sm-8 mt-2\">\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"radio_payment_0\" name=\"radio_payment\" value=\"0\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $_POST['radio_payment'] : $row_shopping["radio_payment"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"radio_payment_0\">\n" . 
				"											PayPal\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"radio_payment_1\" name=\"radio_payment\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $_POST['radio_payment'] : $row_shopping["radio_payment"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"radio_payment_1\">\n" . 
				"											Kreditkarte\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"radio_payment_2\" name=\"radio_payment\" value=\"2\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $_POST['radio_payment'] : $row_shopping["radio_payment"]) == 2 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"radio_payment_2\">\n" . 
				"											Überweisung\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"radio_payment_3\" name=\"radio_payment\" value=\"3\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $_POST['radio_payment'] : $row_shopping["radio_payment"]) == 3 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"radio_payment_3\">\n" . 
				"											Warte auf Rechnung\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"radio_payment_4\" name=\"radio_payment\" value=\"4\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $_POST['radio_payment'] : $row_shopping["radio_payment"]) == 4 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"radio_payment_4\">\n" . 
				"											Storniert\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\" for=\"url\">Link</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<input type=\"text\" id=\"url\" name=\"url\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $url : $row_shopping["url"]) . "\" class=\"form-control" . $inp_url . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\" for=\"file_image\">Screenshot (*.pdf)</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<input type=\"file\" id=\"file_image\" name=\"file_image\" accept=\".pdf\" class=\"form-control\" onchange=\"var sumsize=0;for(var i=0;i<this.files.length;i++){sumsize+=this.files[i].size;}if(sumsize>(" . (int)ini_get("upload_max_filesize") . "*1024*1024)){alert('Die upload Datengröße ist zu hoch. Es sind nur " . (int)ini_get("upload_max_filesize") . "MB insgesammt erlaubt!');}\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\">&nbsp;</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									" . (file_exists("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/shopping/url_" . $row_shopping["id"] . ".pdf") ? "<a href=\"/uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/shopping/url_" . $row_shopping["id"] . ".pdf\" target=\"_blank\">Gespeichert am: " . date("d.m.Y H:i", filemtime("uploads/company/" . intval($_SESSION["admin"]["company_id"]) . "/shopping/url_" . $row_shopping["id"] . ".pdf")) . " Uhr - Screenshot öffnen <i class=\"fa fa-external-link\"> </i></a>\n" : "Datei nicht vorhanden!\n") . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\" for=\"email\">Lieferant E-Mail</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<input type=\"text\" id=\"email\" name=\"email\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $email : $row_shopping["email"]) . "\" class=\"form-control" . $inp_email . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\" for=\"phonenumber\">Lieferant Telefon</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<input type=\"text\" id=\"phonenumber\" name=\"phonenumber\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $phonenumber : $row_shopping["phonenumber"]) . "\" class=\"form-control" . $inp_phonenumber . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\" for=\"faxnumber\">Lieferant Fax</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<input type=\"text\" id=\"faxnumber\" name=\"faxnumber\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $faxnumber : $row_shopping["faxnumber"]) . "\" class=\"form-control" . $inp_faxnumber . "\" />\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\">Retoure Versand</label>\n" . 
				"								<div class=\"col-sm-8 mt-2\">\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"retoure_carrier_0\" name=\"retoure_carrier\" value=\"0\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $_POST['retoure_carrier'] : $row_shopping["retoure_carrier"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"retoure_carrier_0\">\n" . 
				"											DHL\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"retoure_carrier_1\" name=\"retoure_carrier\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $_POST['retoure_carrier'] : $row_shopping["retoure_carrier"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"retoure_carrier_1\">\n" . 
				"											UPS\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"retoure_carrier_2\" name=\"retoure_carrier\" value=\"2\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $_POST['retoure_carrier'] : $row_shopping["retoure_carrier"]) == 2 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"retoure_carrier_2\">\n" . 
				"											Hermes\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"retoure_carrier_3\" name=\"retoure_carrier\" value=\"3\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $_POST['retoure_carrier'] : $row_shopping["retoure_carrier"]) == 3 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"retoure_carrier_3\">\n" . 
				"											DPD\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"									<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"										<input type=\"radio\" id=\"retoure_carrier_4\" name=\"retoure_carrier\" value=\"4\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $_POST['retoure_carrier'] : $row_shopping["retoure_carrier"]) == 4 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"										<label class=\"custom-control-label\" for=\"retoure_carrier_4\">\n" . 
				"											TNT\n" . 
				"										</label>\n" . 
				"									</div>\n" . 
				"								</div>\n" . 
				"							</div>\n" . 

				"							<div class=\"form-group row\">\n" . 
				"								<label class=\"col-sm-4 col-form-label\" for=\"shipping_id\">Sendungsnummer</label>\n" . 
				"								<div class=\"col-sm-8\">\n" . 
				"									<input type=\"text\" id=\"shipping_id\" name=\"shipping_id\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $shipping_id : $row_shopping["shipping_id"]) . "\" class=\"form-control" . $inp_shipping_id . "\" />\n" . 
				"								</div>\n" . 
						"							</div>\n" . 

				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
				"							<button type=\"submit\" name=\"update\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"							<button type=\"submit\" name=\"delete\" value=\"entfernen\" onclick=\"return confirm('Wollen Sie den Eintrag wircklich entfernen?')\" class=\"btn btn-danger\">entfernen <i class=\"fa fa-ban\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br />\n";

}

?>