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

$inp_radio_purpose = "";
$inp_radio_shipping = "";
$inp_shipping_free = "";
$inp_radio_payment = "";
$inp_payment_free = "";
$inp_radio_saturday = "";
$inp_price_total = "";
$inp_radio_paying = "";
$inp_payed = "";
$inp_shipping = "";

$radio_purpose = 0;
$radio_shipping = 0;
$shipping_free = 0;
$radio_payment = 0;
$payment_free = 0;
$radio_saturday = 0;
$price_total = 0.00;
$radio_paying = 0;
$payed = 0;
$shipping = 0;

$emsg = "";

if(isset($_POST['update']) && $_POST['update'] == "speichern"){

	if(strlen($_POST['radio_purpose']) < 1 || strlen($_POST['radio_purpose']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie ein Zweck aus.</small><br />\n";
		$inp_radio_purpose = " is-invalid";
	} else {
		$radio_purpose = intval($_POST['radio_purpose']);
	}

	if(strlen($_POST['radio_shipping']) < 1 || strlen($_POST['radio_shipping']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie eine Versandart aus.</small><br />\n";
		$inp_radio_shipping = " is-invalid";
	} else {
		$radio_shipping = intval($_POST['radio_shipping']);
	}

	if(strlen($_POST['shipping_free']) < 1 || strlen($_POST['shipping_free']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie ob der Versand frei sein soll.</small><br />\n";
		$inp_shipping_free = " is-invalid";
	} else {
		$shipping_free = intval($_POST['shipping_free']);
	}

	if(strlen($_POST['radio_payment']) < 1 || strlen($_POST['radio_payment']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie eine Zahlungsweise aus.</small><br />\n";
		$inp_radio_payment = " is-invalid";
	} else {
		$radio_payment = intval($_POST['radio_payment']);
	}

	if(strlen($_POST['payment_free']) < 1 || strlen($_POST['payment_free']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie ob die Zahlart frei sein soll.</small><br />\n";
		$inp_payment_free = " is-invalid";
	} else {
		$payment_free = intval($_POST['payment_free']);
	}

	if(strlen($_POST['price_total']) > 20){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Gesamtsumme ein.</small><br />\n";
		$inp_price_total = " is-invalid";
	} else {
		$_POST['price_total'] = $_POST['price_total'] == "" || $_POST['price_total'] == "0" ? "0,00" : strip_tags($_POST['price_total']);
		$price_total = str_replace(",", ".", $_POST['price_total']);
	}

	if(strlen($_POST['radio_paying']) < 1 || strlen($_POST['radio_paying']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie Netto oder Brutto aus.</small><br />\n";
		$inp_radio_paying = " is-invalid";
	} else {
		$radio_paying = intval($_POST['radio_paying']);
	}

	if(strlen($_POST['radio_saturday']) < 1 || strlen($_POST['radio_saturday']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie ob auch Samstags zugestellt werden soll aus.</small><br />\n";
		$inp_radio_saturday = " is-invalid";
	} else {
		$radio_saturday = intval($_POST['radio_saturday']);
	}

	if(strlen($_POST['payed']) < 1 || strlen($_POST['payed']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie ob schon bezahlt wurde aus.</small><br />\n";
		$inp_payed = " is-invalid";
	} else {
		$payed = intval($_POST['payed']);
	}

	if(strlen($_POST['shipping']) < 1 || strlen($_POST['shipping']) > 11){
		$emsg .= "<small class=\"error text-muted\">Bitte wählen Sie ob schon versendet wurde aus.</small><br />\n";
		$inp_shipping = " is-invalid";
	} else {
		$shipping = intval($_POST['shipping']);
	}

	if($emsg == ""){

		mysqli_query($conn, "	UPDATE 	`order_orders_payings` 
								SET 	`order_orders_payings`.`radio_purpose`='" . mysqli_real_escape_string($conn, intval($radio_purpose)) . "', 
										`order_orders_payings`.`radio_shipping`='" . mysqli_real_escape_string($conn, intval($radio_shipping)) . "', 
										`order_orders_payings`.`shipping_free`='" . mysqli_real_escape_string($conn, intval($shipping_free)) . "', 
										`order_orders_payings`.`radio_payment`='" . mysqli_real_escape_string($conn, intval($radio_payment)) . "', 
										`order_orders_payings`.`payment_free`='" . mysqli_real_escape_string($conn, intval($payment_free)) . "', 
										`order_orders_payings`.`radio_saturday`='" . mysqli_real_escape_string($conn, intval($radio_saturday)) . "', 
										`order_orders_payings`.`price_total`='" . mysqli_real_escape_string($conn, $price_total) . "', 
										`order_orders_payings`.`radio_paying_netto`='" . mysqli_real_escape_string($conn, intval($radio_paying)) . "', 
										`order_orders_payings`.`payed`='" . mysqli_real_escape_string($conn, intval($payed)) . "', 
										" . ($payed == 1 ? "`order_orders_payings`.`payed_date`='" . mysqli_real_escape_string($conn, intval($time)) . "', " : "") . " 
										`order_orders_payings`.`shipping`='" . mysqli_real_escape_string($conn, intval($shipping)) . "' 
								WHERE 	`order_orders_payings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								AND 	`order_orders_payings`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

		$emsg = "<p>Die Zahlung wurde erfolgreich geändert!</p>\n";

	}

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['delete']) && $_POST['delete'] == "entfernen"){

	mysqli_query($conn, "	DELETE FROM	`order_orders_payings` 
							WHERE 		`order_orders_payings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'
							AND 		`order_orders_payings`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

}

$radio_purposes = array(
	0 => "Angebot", 
	1 => "Gutschrift", 
	2 => "Rechnung", 
	3 => "Differenzrechnung"
);

$radio_shippings = array(
	0 => "Express<br />8,95 &euro;", 
	1 => "Standard<br />5,95 &euro;", 
	2 => "International<br />15,00 &euro;", 
	3 => "Abholung<br />0,00 &euro;"
);

$radio_payments = array(
	0 => "Überweisung<br />0,00 &euro;", 
	1 => "Nachnahme<br />8,00 &euro;", 
	2 => "Bar<br />0,00&euro;"
);

$radio_saturdays = array(
	0 => "Nein<br />0,00 &euro;", 
	1 => "Ja<br />8,30 &euro;"
);

$radio_saturdays_label = array(
	0 => "Nein;", 
	1 => "Ja"
);

$radio_payings = array(
	0 => "Netto", 
	1 => "Brutto"
);

$shipping_costs = array(
	0 =>  8.95, // Expressversand
	1 =>  5.95,  // Standardversand
	2 =>  15.00,  // International
	3 =>  0.00  // Abholung
);

$payment_costs = array(
	0 =>  0.00, // Überweisung
	1 =>  8.00, // Nachnahme
	2 =>  0.00  // Bar
);
	
$saturday_costs = array(
	0 =>  0.00, // Nein
	1 =>  8.30, // Ja
);

$amount_netto = 0.00;
$amount_mwst = 0.00;
$amount_brutto = 0.00;

$amount_shipping = 0.00;
$amount_payment = 0.00;
$amount_saturday = 0.00;

$sign = "";

$text_color = "";

$payings_infos_table_tr = "";

$result = mysqli_query($conn, "	SELECT 		`order_orders_payings`.`id` AS id, 
											`order_orders_payings`.`order_id` AS order_id, 
											`order_orders_payings`.`radio_purpose` AS radio_purpose, 
											`order_orders_payings`.`radio_shipping` AS radio_shipping, 
											`order_orders_payings`.`shipping_free` AS shipping_free, 
											`order_orders_payings`.`radio_payment` AS radio_payment, 
											`order_orders_payings`.`radio_saturday` AS radio_saturday, 
											`order_orders_payings`.`radio_paying_netto` AS radio_paying_netto, 
											`order_orders_payings`.`price_total` AS price_total, 
											`order_orders_payings`.`mwst` AS mwst, 
											`order_orders_payings`.`payed` AS payed, 
											`order_orders_payings`.`payed_date` AS payed_date, 
											`order_orders_payings`.`shipping` AS shipping, 
											`order_orders_payings`.`time` AS time 
								FROM 		`order_orders_payings` 
								WHERE		`order_orders_payings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								AND 		`order_orders_payings`.`order_id`='" . mysqli_real_escape_string($conn, intval($param['id'])) . "' 
								ORDER BY 	CAST(`order_orders_payings`.`time` AS UNSIGNED) ASC");

while($row_payings = $result->fetch_array(MYSQLI_ASSOC)){
	/*
		Angebote sollten nicht gezählt werden
		Gutschrift ist ein negativer Betrag 
		Rechnung und Differenzrechnung ist ganz normal ein normaler Betrag
	*/
	switch(intval($row_payings['radio_purpose'])){
		case 0: // Angebot 
			$text_color = "text-info";
			$sign = "";
			break;
		case 1: // Gutschrift
			$amount_netto -= ($row_payings["radio_paying_netto"] == 0 ? $row_payings["price_total"] : $row_payings["price_total"] / (100 + $row_payings['mwst']) * 100);
			$amount_mwst -= ($row_payings["radio_paying_netto"] == 0 ? $row_payings["price_total"] / 100 * $row_payings['mwst'] : $row_payings["price_total"] / (100 + $row_payings['mwst']) * $row_payings['mwst']);
			$amount_brutto -= ($row_payings["radio_paying_netto"] == 0 ? $row_payings["price_total"] / 100 * (100 + $row_payings['mwst']) : $row_payings["price_total"]);
			if($row_payings["shipping_free"] == 0){
				$amount_shipping -= $shipping_costs[$row_payings["radio_shipping"]];
			}
			if($row_payings["payment_free"] == 0){
				$amount_payment -= $payment_costs[$row_payings["radio_payment"]];
			}
			$amount_saturday -=  (intval($row_payings['radio_shipping']) < 2 ? $saturday_costs[$row_payings["radio_saturday"]] : 0.00);
			$text_color = "text-danger";
			$sign = "-";
			break;
		case 2: // Rechnung
			if($row_payings["payed"] == 0){
				$amount_netto += ($row_payings["radio_paying_netto"] == 0 ? $row_payings["price_total"] : $row_payings["price_total"] / (100 + $row_payings['mwst']) * 100);
				$amount_mwst += ($row_payings["radio_paying_netto"] == 0 ? $row_payings["price_total"] / 100 * $row_payings['mwst'] : $row_payings["price_total"] / (100 + $row_payings['mwst']) * $row_payings['mwst']);
				$amount_brutto += ($row_payings["radio_paying_netto"] == 0 ? $row_payings["price_total"] / 100 * (100 + $row_payings['mwst']) : $row_payings["price_total"]);
				if($row_payings["shipping_free"] == 0){
					$amount_shipping += $shipping_costs[$row_payings["radio_shipping"]];
				}
				if($row_payings["payment_free"] == 0){
					$amount_payment += $payment_costs[$row_payings["radio_payment"]];
				}
				$amount_saturday +=  (intval($row_payings['radio_shipping']) < 2 ? $saturday_costs[$row_payings["radio_saturday"]] : 0.00);
				$text_color = "text-success";
				$sign = "+";
			}
			break;
		case 3: // Differenzrechnung
			if($row_payings["payed"] == 0){
				$amount_netto += ($row_payings["radio_paying_netto"] == 0 ? $row_payings["price_total"] : $row_payings["price_total"] / (100 + $row_payings['mwst']) * 100);
				$amount_mwst += ($row_payings["radio_paying_netto"] == 0 ? $row_payings["price_total"] / 100 * $row_payings['mwst'] : $row_payings["price_total"] / (100 + $row_payings['mwst']) * $row_payings['mwst']);
				$amount_brutto += ($row_payings["radio_paying_netto"] == 0 ? $row_payings["price_total"] / 100 * (100 + $row_payings['mwst']) : $row_payings["price_total"]);
				if($row_payings["shipping_free"] == 0){
					$amount_shipping += $shipping_costs[$row_payings["radio_shipping"]];
				}
				if($row_payings["payment_free"] == 0){
					$amount_payment += $payment_costs[$row_payings["radio_payment"]];
				}
				$amount_saturday += (intval($row_payings['radio_shipping']) < 2 ? $saturday_costs[$row_payings["radio_saturday"]] : 0.00);
				$text_color = "text-success";
				$sign = "+";
			}
			break;
	}

	$payings_infos_table_tr .= 	"	<tr" . (isset($_POST['id']) && $_POST['id'] == $row_payings['id'] ? " class=\"bg-primary text-white\"" : "") . ">\n" . 
								"		<td width=\"74\" class=\"text-center " . (isset($_POST['id']) && $_POST['id'] == $row_payings['id'] ? "" : $text_color) . "\"><small>" . date("d.m.Y", intval($row_payings['time'])) . "</small><br /><small class=\"text-muted\">" . date("(H:i)", $row_payings['time']) . "</small></td>\n" . 
								"		<td width=\"118\" class=\"text-center " . (isset($_POST['id']) && $_POST['id'] == $row_payings['id'] ? "" : $text_color) . "\"><small>" . $radio_purposes[$row_payings['radio_purpose']] . "</small></td>\n" . 
								"		<td width=\"90\" class=\"text-center " . (isset($_POST['id']) && $_POST['id'] == $row_payings['id'] ? "" : $text_color) . "\"><small>" . $radio_shippings[$row_payings['radio_shipping']] . "</small></td>\n" . 
								"		<td width=\"90\" class=\"text-center " . (isset($_POST['id']) && $_POST['id'] == $row_payings['id'] ? "" : $text_color) . "\"><small>" . $radio_payments[$row_payings['radio_payment']] . "</small></td>\n" . 
								"		<td width=\"124\" class=\"text-center " . (isset($_POST['id']) && $_POST['id'] == $row_payings['id'] ? "" : $text_color) . "\"><small>" . (intval($row_payings['radio_shipping']) < 2 ? $radio_saturdays[$row_payings['radio_saturday']] : $radio_saturdays_label[$row_payings['radio_saturday']] . "<br />0,00 &euro;") . "</small></td>\n" . 
								"		<td width=\"58\" class=\"text-center " . (isset($_POST['id']) && $_POST['id'] == $row_payings['id'] ? "" : $text_color) . "\"><small>" . number_format($row_payings['mwst'], 2, ',', '') . " %</small></td>\n" . 
								"		<td width=\"88\" class=\"text-center " . (isset($_POST['id']) && $_POST['id'] == $row_payings['id'] ? "" : $text_color) . "\"><small>" . $sign . number_format(($row_payings["radio_paying_netto"] == 0 ? $row_payings["price_total"] : $row_payings["price_total"] / (100 + $row_payings['mwst']) * 100), 2, ',', '') . " &euro;</small></td>\n" . 
								"		<td width=\"90\" class=\"text-center " . (isset($_POST['id']) && $_POST['id'] == $row_payings['id'] ? "" : $text_color) . "\"><small>" . $sign . number_format(($row_payings["radio_paying_netto"] == 0 ? $row_payings["price_total"] / 100 * $row_payings['mwst'] : $row_payings["price_total"] / (100 + $row_payings['mwst']) * $row_payings['mwst']), 2, ',', '') . " &euro;</small></td>\n" . 
								"		<td width=\"92\" class=\"text-center " . (isset($_POST['id']) && $_POST['id'] == $row_payings['id'] ? "" : $text_color) . "\"><small>" . $sign . number_format(($row_payings["radio_paying_netto"] == 0 ? $row_payings["price_total"] / 100 * (100 + $row_payings['mwst']) : $row_payings["price_total"]), 2, ',', '') . " &euro;</small></td>\n" . 
								"		<td width=\"90\" class=\"text-center " . (isset($_POST['id']) && $_POST['id'] == $row_payings['id'] ? "" : $text_color) . "\">" . ($row_payings["payed"] == 0 ? "<i class=\"fa fa-ban\"> </i>" : "<small>" . date("d.m.Y", $row_payings["payed_date"])  . "</small><br /><small class=\"text-muted\">" . date("(H:i)", $row_payings['payed_date']) . "</small>") . "</td>\n" . 
								"		<td width=\"90\" class=\"text-center " . (isset($_POST['id']) && $_POST['id'] == $row_payings['id'] ? "" : $text_color) . "\">" . ($row_payings["shipping"] == 0 ? "<i class=\"fa fa-ban\"> </i>" : "<i class=\"fa fa-check\"> </i>") . "</td>\n" . 
								"		<td class=\"text-center\">\n" . 
								"			<form action=\"" . $page['url'] . "/" . $row_payings['order_id'] . "\" method=\"post\">\n" . 
								"				<input type=\"hidden\" name=\"id\" value=\"" . $row_payings['id'] . "\" />\n" . 
								"				<button type=\"submit\" name=\"edit\" value=\"bearbeiten\" class=\"btn btn-sm btn-success\"><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>\n" . 
								"			</form>\n" . 
								"		</td>\n" . 
								"	</tr>\n";

}

$payings_infos_table_tr .= 	"	<tr>\n" . 
							"		<td colspan=\"12\">&nbsp;</td>\n" . 
							"	</tr>\n" . 
							"	<tr>\n" . 
							"		<td colspan=\"4\">&nbsp;</td>\n" . 
							"		<td colspan=\"2\" class=\"text-right\"><b>Summe:</b></td>\n" . 
							"		<td class=\"text-center " . ($amount_netto >= 0 ? "text-success" : "text-danger") . "\"><b>" . str_replace("+", "+<u>", str_replace("-", "-<u>", number_format($amount_netto, 2, ',', ''))) . "</u> &euro;</b></td>\n" . 
							"		<td class=\"text-center " . ($amount_mwst >= 0 ? "text-success" : "text-danger") . "\"><b>" . str_replace("+", "+<u>", str_replace("-", "-<u>", number_format($amount_mwst, 2, ',', ''))) . "</u> &euro;</b></td>\n" . 
							"		<td class=\"text-center " . ($amount_brutto >= 0 ? "text-success" : "text-danger") . "\"><b>" . str_replace("+", "+<u>", str_replace("-", "-<u>", number_format($amount_brutto, 2, ',', ''))) . "</u> &euro;</b></td>\n" . 
							"		<td colspan=\"3\">&nbsp;</td>\n" . 
							"	</tr>\n" . 
							"	<tr>\n" . 
							"		<td colspan=\"12\">&nbsp;</td>\n" . 
							"	</tr>\n" . 
							"	<tr>\n" . 
							"		<td colspan=\"4\">&nbsp;</td>\n" . 
							"		<td colspan=\"2\" class=\"text-right\"><b>Versand:</b></td>\n" . 
							"		<td colspan=\"2\">&nbsp;</td>\n" . 
							"		<td class=\"text-center\"><span>+" . number_format($amount_shipping, 2, ',', '') . " &euro;</span></td>\n" . 
							"		<td colspan=\"3\">&nbsp;</td>\n" . 
							"	</tr>\n" . 
							"	<tr>\n" . 
							"		<td colspan=\"4\">&nbsp;</td>\n" . 
							"		<td colspan=\"2\" class=\"text-right\"><b>Zahlung:</b></td>\n" . 
							"		<td colspan=\"2\">&nbsp;</td>\n" . 
							"		<td class=\"text-center\"><span>+" . number_format($amount_payment, 2, ',', '') . " &euro;</span></td>\n" . 
							"		<td colspan=\"3\">&nbsp;</td>\n" . 
							"	</tr>\n" . 
							"	<tr>\n" . 
							"		<td colspan=\"4\">&nbsp;</td>\n" . 
							"		<td colspan=\"2\" class=\"text-right\"><b>Samst.:</b></td>\n" . 
							"		<td colspan=\"2\">&nbsp;</td>\n" . 
							"		<td class=\"text-center\"><span>+" . number_format($amount_saturday, 2, ',', '') . " &euro;</span></td>\n" . 
							"		<td colspan=\"3\">&nbsp;</td>\n" . 
							"	</tr>\n" . 
							"	<tr>\n" . 
							"		<td colspan=\"12\">&nbsp;</td>\n" . 
							"	</tr>\n" . 
							"	<tr>\n" . 
							"		<td colspan=\"4\">&nbsp;</td>\n" . 
							"		<td colspan=\"2\" class=\"text-right\"><b>Gesamtsumme:</b></td>\n" . 
							"		<td colspan=\"2\">&nbsp;</td>\n" . 
							"		<td class=\"text-center " . (($amount_brutto + $amount_shipping + $amount_payment + $amount_saturday) >= 0 ? "text-success" : "text-danger") . "\"><b>" . str_replace("+", "+<u>", str_replace("-", "-<u>", number_format(($amount_brutto + $amount_shipping + $amount_payment + $amount_saturday), 2, ',', ''))) . "</u> &euro;</b></td>\n" . 
							"		<td colspan=\"3\">&nbsp;</td>\n" . 
							"	</tr>\n";


$payings_infos =	"<table class=\"table table-white table-sm table-bordered table-hover mb-0\">\n" . 
					"	<tr class=\"bg-white text-primary\">\n" . 
					"		<th width=\"74\"><small><b>Datum</b></small></th>\n" . 
					"		<th width=\"118\"><small><b>Zweck</b></small></th>\n" . 
					"		<th width=\"90\"><small><b>Versand</b></small></th>\n" . 
					"		<th width=\"90\"><small><b>Zahlung</b></small></th>\n" . 
					"		<th width=\"124\"><small><b>Samstagszuschlag</b></small></th>\n" . 
					"		<th width=\"58\"><small><b>MwSt</b></small></th>\n" . 
					"		<th width=\"88\"><small><b>Nettobetrag</b></small></th>\n" . 
					"		<th width=\"90\"><small><b>MwSt-Betrag</b></small></th>\n" . 
					"		<th width=\"92\"><small><b>Bruttobetrag</b></small></th>\n" . 
					"		<th width=\"90\"><small><b>Bezahlt</b></small></th>\n" . 
					"		<th width=\"90\"><small><b>Versendet</b></small></th>\n" . 
					"		<th width=\"\" class=\"text-center\"><small><b>Aktion</b></small></th>\n" . 
					"	</tr>\n" . 
					"</table>\n" . 
					"<div class=\"table-responsive\" style=\"height: 360px\">\n" . 
					"<table class=\"table table-white table-sm table-bordered table-hover mb-0\">\n" . 
					"	<tr class=\"bg-white text-primary d-none\">\n" . 
					"		<th width=\"74\"><small><b>Datum</b></small></th>\n" . 
					"		<th width=\"118\"><small><b>Zweck</b></small></th>\n" . 
					"		<th width=\"90\"><small><b>Versand</b></small></th>\n" . 
					"		<th width=\"90\"><small><b>Zahlung</b></small></th>\n" . 
					"		<th width=\"124\"><small><b>Samstagszuschlag</b></small></th>\n" . 
					"		<th width=\"58\"><small><b>MwSt</b></small></th>\n" . 
					"		<th width=\"88\"><small><b>Nettobetrag</b></small></th>\n" . 
					"		<th width=\"90\"><small><b>MwSt-Betrag</b></small></th>\n" . 
					"		<th width=\"92\"><small><b>Bruttobetrag</b></small></th>\n" . 
					"		<th width=\"90\"><small><b>Bezahlt</b></small></th>\n" . 
					"		<th width=\"90\"><small><b>Versendet</b></small></th>\n" . 
					"		<th width=\"\" class=\"text-center\"><small><b>Aktion</b></small></th>\n" . 
					"	</tr>\n" . 

					$payings_infos_table_tr . 
	
					"</table>\n" . 
					"</div>\n";

$html = "<br />\n" . 

		$payings_infos . 

		"<br />\n";

if(isset($_POST['edit']) && $_POST['edit'] == "bearbeiten"){

	$row_paying = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders_payings` WHERE `order_orders_payings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_payings`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Bearbeiten</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "/" . intval($row_paying['order_id']) . "\" method=\"post\">\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-4 col-form-label\">Zweck</label>\n" . 
				"						<div class=\"col-sm-8 mt-2\">\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"radio_purpose1\" name=\"radio_purpose\" value=\"0\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_purpose : $row_paying["radio_purpose"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"radio_purpose1\">\n" . 
				"									Angebot\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"radio_purpose2\" name=\"radio_purpose\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_purpose : $row_paying["radio_purpose"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"radio_purpose2\">\n" . 
				"									Gutschrift\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"radio_purpose3\" name=\"radio_purpose\" value=\"2\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_purpose : $row_paying["radio_purpose"]) == 2 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"radio_purpose3\">\n" . 
				"									Rechnung\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"							<div class=\"custom-control custom-radio d-inline\">\n" . 
				"								<input type=\"radio\" id=\"radio_purpose4\" name=\"radio_purpose\" value=\"3\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_purpose : $row_paying["radio_purpose"]) == 3 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"radio_purpose4\">\n" . 
				"									Differenzrechnung\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-4 col-form-label\">Versand</label>\n" . 
				"						<div class=\"col-sm-8 mt-2\">\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"radio_shipping_standart1\" name=\"radio_shipping\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_shipping : $row_paying["radio_shipping"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label text-right\" for=\"radio_shipping_standart1\">\n" . 
				"									Standard<br /><small>5,95 &euro;</small>\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"radio_shipping_express1\" name=\"radio_shipping\" value=\"0\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_shipping : intval($row_paying["radio_shipping"])) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label text-right\" for=\"radio_shipping_express1\">\n" . 
				"									Express<br /><small>8,95 &euro;</small>\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"radio_shipping_international1\" name=\"radio_shipping\" value=\"2\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_shipping : $row_paying["radio_shipping"]) == 2 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label text-right\" for=\"radio_shipping_international1\">\n" . 
				"									International<br /><small>15,00 &euro;</small>\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"							<div class=\"custom-control custom-radio d-inline\">\n" . 
				"								<input type=\"radio\" id=\"radio_shipping_self1\" name=\"radio_shipping\" value=\"3\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_shipping : $row_paying["radio_shipping"]) == 3 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label text-right\" for=\"radio_shipping_self1\">\n" . 
				"									Abholung<br /><small>0,00 &euro;</small>\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-4 col-form-label text-right\">- Kostenlos</label>\n" . 
				"						<div class=\"col-sm-8 mt-2\">\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"shipping_free1\" name=\"shipping_free\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $shipping_free : $row_paying["shipping_free"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"shipping_free1\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"shipping_free0\" name=\"shipping_free\" value=\"0\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $shipping_free : $row_paying["shipping_free"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label text-right\" for=\"shipping_free0\">\n" . 
				"									Nein\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-4 col-form-label\">Zahlart</label>\n" . 
				"						<div class=\"col-sm-8 mt-2\">\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"radio_payment_nachnahme1\" name=\"radio_payment\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_payment : $row_paying["radio_payment"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label text-right\" for=\"radio_payment_nachnahme1\">\n" . 
				"									Nachnahme<br /><small>8,00 &euro;</small>\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"radio_payment_ueberweisung1\" name=\"radio_payment\" value=\"0\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_payment : $row_paying["radio_payment"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label text-right\" for=\"radio_payment_ueberweisung1\">\n" . 
				"									Überweisung<br /><small>0,00 &euro;</small>\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"							<div class=\"custom-control custom-radio d-inline\">\n" . 
				"								<input type=\"radio\" id=\"radio_payment_bar1\" name=\"radio_payment\" value=\"2\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_payment : $row_paying["radio_payment"]) == 2 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"radio_payment_bar1\">\n" . 
				"									Bar<br /><small>0,00 &euro;</small>\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-4 col-form-label text-right\">- Kostenlos</label>\n" . 
				"						<div class=\"col-sm-8 mt-2\">\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"payment_free1\" name=\"payment_free\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $payment_free : $row_paying["payment_free"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"payment_free1\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"payment_free0\" name=\"payment_free\" value=\"0\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $payment_free : $row_paying["payment_free"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label text-right\" for=\"payment_free0\">\n" . 
				"									Nein\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-4 col-form-label\">Samstagszuschlag</label>\n" . 
				"						<div class=\"col-sm-8 mt-2\">\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"radio_saturday1\" name=\"radio_saturday\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_saturday : $row_paying["radio_saturday"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"radio_saturday1\">\n" . 
				"									Ja<br /><small>8,30 &euro;</small>\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"radio_saturday0\" name=\"radio_saturday\" value=\"0\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_saturday : $row_paying["radio_saturday"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label text-right\" for=\"radio_saturday0\">\n" . 
				"									Nein<br /><small>0,00 &euro;</small>\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"price_total\" class=\"col-sm-4 col-form-label\">Gesamtsumme</label>\n" . 
				"						<div class=\"col-sm-3\">\n" . 
				"							<input type=\"hidden\" id=\"mwst\" name=\"mwst\" value=\"" . $maindata['mwst'] . "\" />\n" . 
				"							<div class=\"input-group\">\n" . 
				"								<input type=\"text\" id=\"price_total\" name=\"price_total\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? number_format($price_total, 2, ',', '') : number_format($row_paying["price_total"], 2, ',', '')) . "\" class=\"form-control" . $inp_price_total . "\" onkeyup=\"if(\$('#radio_paying_netto').prop('checked') == true){\$('#calculate_data').html('<div class=\'row\'><div class=\'col-sm-3\'>Nettobetrag:<br>MwSt.:<br>Bruttobetrag:<br></div><div class=\'col-sm-3 text-right\'>' + \$('#price_total').val() + ' &euro;<br>' + ((\$('#price_total').val().replace(',', '.') / 100 * \$('#mwst').val()).toFixed(2) + '').replace('.', ',') + ' &euro;<br>' + ((\$('#price_total').val().replace(',', '.') / 100 * parseInt(100 + parseInt(\$('#mwst').val()))).toFixed(2) + '').replace('.', ',') + ' &euro;<br></div></div>');}else{\$('#calculate_data').html('<div class=\'row\'><div class=\'col-sm-3\'>Nettobetrag:<br>MwSt.:<br>Bruttobetrag:<br></div><div class=\'col-sm-3 text-right\'>' + ((\$('#price_total').val().replace(',', '.') / (100 + parseInt(\$('#mwst').val())) * 100).toFixed(2) + '').replace('.', ',') + ' &euro;<br>' + ((\$('#price_total').val().replace(',', '.') / (100 + parseInt(\$('#mwst').val())) * parseInt(\$('#mwst').val())).toFixed(2) + '').replace('.', ',') + ' &euro;<br>' + \$('#price_total').val() + ' &euro;<br></div></div>');}\" />\n" . 
				"								<div class=\"input-group-append\"><span class=\"input-group-text\">&euro;</span></div>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-5 mt-1\">\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"radio_paying_netto\" name=\"radio_paying\" value=\"0\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_paying : $row_paying["radio_paying_netto"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" onclick=\"\$('#calculate_data').html('<div class=\'row\'><div class=\'col-sm-3\'>Nettobetrag:<br>MwSt.:<br>Bruttobetrag:<br></div><div class=\'col-sm-3 text-right\'>' + \$('#price_total').val() + ' &euro;<br>' + ((\$('#price_total').val().replace(',', '.') / 100 * \$('#mwst').val()).toFixed(2) + '').replace('.', ',') + ' &euro;<br>' + ((\$('#price_total').val().replace(',', '.') / 100 * parseInt(100 + parseInt(\$('#mwst').val()))).toFixed(2) + '').replace('.', ',') + ' &euro;<br></div></div>')\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"radio_paying_netto\">\n" . 
				"									Netto\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"radio_paying_brutto\" name=\"radio_paying\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $radio_paying : $row_paying["radio_paying_netto"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" onclick=\"\$('#calculate_data').html('<div class=\'row\'><div class=\'col-sm-3\'>Nettobetrag:<br>MwSt.:<br>Bruttobetrag:<br></div><div class=\'col-sm-3 text-right\'>' + ((\$('#price_total').val().replace(',', '.') / (100 + parseInt(\$('#mwst').val())) * 100).toFixed(2) + '').replace('.', ',') + ' &euro;<br>' + ((\$('#price_total').val().replace(',', '.') / (100 + parseInt(\$('#mwst').val())) * parseInt(\$('#mwst').val())).toFixed(2) + '').replace('.', ',') + ' &euro;<br>' + \$('#price_total').val() + ' &euro;<br></div></div>')\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"radio_paying_brutto\">\n" . 
				"									Brutto\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-4 col-form-label\">&nbsp;</label>\n" . 
				"						<div class=\"col-sm-8\">\n" . 
				"							<div id=\"calculate_data\">\n" . 
				"								<div class=\"row\">\n" . 
				"									<div class=\"col-sm-3\">\n" . 
				"										Nettobetrag:<br />\n" . 
				"										MwSt.:<br />\n" . 
				"										Bruttobetrag:<br />\n" . 
				"									</div>\n" . 
				"									<div class=\"col-sm-3 text-right\">\n" . 
				"										" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? number_format(($radio_paying == 0 ? $price_total : $price_total / (100 + $row_paying['mwst']) * 100), 2, ',', '') : number_format(($row_paying["radio_paying"] == 0 ? $row_paying["price_total"] : $row_paying["price_total"] / (100 + $row_paying['mwst']) * 100), 2, ',', '')) . " &euro;<br />\n" . 
				"										" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? number_format(($radio_paying == 0 ? $price_total / 100 * $row_paying['mwst'] : $price_total / (100 + $row_paying['mwst']) * $row_paying['mwst']), 2, ',', '') : number_format(($row_paying["radio_paying"] == 0 ? $row_paying["price_total"] / 100 * $row_paying['mwst'] : $row_paying["price_total"] / (100 + $row_paying['mwst']) * $row_paying['mwst']), 2, ',', '')) . " &euro;<br />\n" . 
				"										" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? number_format(($radio_paying == 0 ? $price_total / 100 * (100 + $row_paying['mwst']) : $price_total), 2, ',', '') : number_format(($row_paying["radio_paying"] == 0 ? $row_paying["price_total"] / 100 * (100 + $row_paying['mwst']) : $row_paying["price_total"]), 2, ',', '')) . " &euro;<br />\n" . 
				"									</div>\n" . 
				"							</div>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-4 col-form-label\">Bezahlt</label>\n" . 
				"						<div class=\"col-sm-8 mt-2\">\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"payed1\" name=\"payed\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $payed : $row_paying["payed"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"payed1\">\n" . 
				"									Ja<br /><small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"payed0\" name=\"payed\" value=\"0\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $payed : $row_paying["payed"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"payed0\">\n" . 
				"									Nein<br /><small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-4 col-form-label\">Versendet</label>\n" . 
				"						<div class=\"col-sm-8 mt-2\">\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"shipping1\" name=\"shipping\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $shipping : $row_paying["shipping"]) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"shipping1\">\n" . 
				"									Ja<br /><small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"shipping0\" name=\"shipping\" value=\"0\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? $shipping : $row_paying["shipping"]) == 0 ? " checked=\"checked\"" : "") . " class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"shipping0\">\n" . 
				"									Nein<br /><small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

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