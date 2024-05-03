<?php 

	$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

	if(strlen($_POST['intern_price_total']) < 1 && strlen($_POST['intern_price_total']) > 20){
		$emsg .= "<small class=\"error text-muted\">Bitte geben Sie eine Gesamtsumme ein.</small><br />\n";
		$inp_intern_price_total = " is-invalid";
	} else {
		$intern_price_total = number_format($_POST['intern_price_total'], 2, '.', '');
	}

	if($emsg == ""){

		mysqli_query($conn, "	INSERT 	`order_orders_payings` 
								SET 	`order_orders_payings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`order_orders_payings`.`admin_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["id"])) . "', 
										`order_orders_payings`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
										`order_orders_payings`.`radio_purpose`='" . mysqli_real_escape_string($conn, intval($_POST["intern_radio_purpose"])) . "', 
										`order_orders_payings`.`radio_shipping`='" . mysqli_real_escape_string($conn, intval($_POST["radio_shipping"])) . "', 
										`order_orders_payings`.`radio_payment`='" . mysqli_real_escape_string($conn, intval($_POST["radio_payment"])) . "', 
										`order_orders_payings`.`radio_saturday`='" . mysqli_real_escape_string($conn, intval($_POST["intern_radio_saturday"])) . "', 
										`order_orders_payings`.`radio_paying_netto`='" . mysqli_real_escape_string($conn, intval($_POST["intern_radio_paying"])) . "', 
										`order_orders_payings`.`price_total`='" . mysqli_real_escape_string($conn, $intern_price_total) . "', 
										`order_orders_payings`.`mwst`='" . mysqli_real_escape_string($conn, $maindata['mwst']) . "', 
										`order_orders_payings`.`payed`='0', 
										`order_orders_payings`.`payed_date`='0', 
										`order_orders_payings`.`shipping`='0', 
										`order_orders_payings`.`time`='" . mysqli_real_escape_string($conn, intval(time())) . "'");

	}

	$_POST['edit'] = "bearbeiten";

?>