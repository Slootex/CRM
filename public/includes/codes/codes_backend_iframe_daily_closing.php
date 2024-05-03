<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "daily_closing";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}elseif(isset($param['time']) && intval($param['time']) != 0){
	$time = intval($param['time']);
}else{
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$time = time();

$date = date("d.m.Y", $time);
$day = strtotime($date);

$order_shippings = mysqli_fetch_array(mysqli_query($conn, "	SELECT	COUNT(*) AS cnt 
															FROM	`order_orders_shipments` 
															WHERE	`order_orders_shipments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
															AND 	`order_orders_shipments`.`time`>='" . mysqli_real_escape_string($conn, intval($day)) . "' 
															AND 	`order_orders_shipments`.`time`<'" . mysqli_real_escape_string($conn, intval($day + 86400)) . "'"), MYSQLI_ASSOC);


$shipping_shippings = mysqli_fetch_array(mysqli_query($conn, "	SELECT	COUNT(*) AS cnt 
																FROM	`shipping_history` 
																WHERE	`shipping_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																AND 	`shipping_history`.`time`>='" . mysqli_real_escape_string($conn, intval($day)) . "' 
																AND 	`shipping_history`.`time`<'" . mysqli_real_escape_string($conn, intval($day + 86400)) . "'"), MYSQLI_ASSOC);

$html = 	"<table clellspacing=\"1\" cellpadding=\"1\" border=\"0\" width=\"50%\"><tr><td style=\"border-bottom: 1px solid #000000\"><h2>Sendungen Materialinventur</h2></td></tr></table><br>\n" . 
			"<table clellspacing=\"1\" cellpadding=\"1\" border=\"0\" width=\"50%\"><tr><td width=\"50%\" valign=\"top\"><b>Absender:</b></td><td valign=\"top\"><p>GZA MOTORS<br>Inh. Gazi Ahmad<br>Strausberger Platz 13<br>10243 Berlin<br>Deutschland</p></td></tr></table>\n" . 
			"<table clellspacing=\"1\" cellpadding=\"1\" border=\"0\" width=\"100%\">\n" . 
			"	<tr><td width=\"25%\" valign=\"top\">&nbsp;</td><td width=\"25%\" valign=\"top\"><b>Name:</b></td><td width=\"30%\" valign=\"top\"><b>Sendungsnummer:</b></td><td></td></tr>\n" . 
			"";

$result = mysqli_query($conn, "	SELECT 		* 
								FROM 		`shipping_history`
								WHERE  		`shipping_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								AND 		`shipping_history`.`time`>='" . mysqli_real_escape_string($conn, intval($day)) . "' AND `shipping_history`.`time`<'" . mysqli_real_escape_string($conn, intval($day + 86400)) . "'");

$i = 0;

while($row = $result->fetch_array(MYSQLI_ASSOC)){
	if($i == 0){
		$html .= "	<tr><td rowspan=\"" . ($shipping_shippings['cnt'] + $order_shippings['cnt']) . "\" width=\"25%\" valign=\"top\"><b>Empfänger / Sendungs-IDs:</b></td><td width=\"25%\" valign=\"top\" style=\"border-right: 1px solid #000000\"><span>" . $row['to_shortcut'] . "</span></td><td width=\"30%\" valign=\"top\"><span>" . $row['shipments_id'] . "</span></td><td></td></tr>\n";
	}else{
		$html .= "	<tr><td width=\"25%\" valign=\"top\" style=\"border-top: 1px solid #000000;border-right: 1px solid #000000\"><span>" . $row['to_shortcut'] . "</span></td><td width=\"30%\" valign=\"top\" style=\"border-top: 1px solid #000000\"><span>" . $row['shipments_id'] . "</span></td><td></td></tr>\n";
	}
	$i++;
}

$result = mysqli_query($conn, "	SELECT 		* 
								FROM 		`order_orders_shipments` 
								WHERE 		`order_orders_shipments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								AND 		`order_orders_shipments`.`time`>='" . $day . "' AND `order_orders_shipments`.`time`<'" . ($day + 86400) . "'");

while($row = $result->fetch_array(MYSQLI_ASSOC)){
	$html .= "	<tr><td width=\"25%\" valign=\"top\" style=\"border-top: 1px solid #000000;border-right: 1px solid #000000\"><span>" . $row['firstname'] . " " . $row['lastname'] . "</span></td><td width=\"30%\" valign=\"top\" style=\"border-top: 1px solid #000000\"><span>" . $row['shipments_id'] . "</span></td><td></td></tr>\n";
}

$html .= 	"	<tr><td><b>Anzahl Pakete:</b></td><td width=\"25%\" valign=\"top\" style=\"border-top: 1px solid #000000;border-bottom: 3px double #000000\"><span>" . ($shipping_shippings['cnt'] + $order_shippings['cnt']) . "</span></td><td width=\"30%\" valign=\"top\" style=\"border-top: 1px solid #000000\"><span>&nbsp;</span></td><td></td></tr>\n" . 
			"</table><br><br>\n" . 
			"<p>Hiermit bestätige ich die Übernahme der oben<br>aufgeführten Pakete in einem äußerlich unversehrten Zustand.</p><br><br>\n" . 
			"<table clellspacing=\"1\" cellpadding=\"1\" border=\"0\" width=\"100%\">\n" . 
			"	<tr><td width=\"40%\" valign=\"top\"><span>Berlin, " . $date . "</span></td><td width=\"40%\" valign=\"top\"><span>&nbsp;</span></td><td></td></tr>\n" . 
			"	<tr><td width=\"40%\" valign=\"top\" style=\"border-top: 1px solid #000000\"><b>Ort, Datum</b></td><td width=\"40%\" valign=\"top\" style=\"border-top: 1px solid #000000\"><b>Unterschrift/Fahrer</b></td><td></td></tr>\n" . 
			"</table><br><br>\n" . 
			"<p><b>Hinweis</b>: Bitte nehmen Sie diesen Beleg zu Ihren Unterlagen.<br>Er dient als Übergabenachweis im Schadens-bzw.Verlustfall.</p>\n";

?>