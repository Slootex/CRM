<?php

class payings {

	protected $value = 0.00;

	protected $payings = 0;

	function __construct($conn, $order_id) {

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

		$result = mysqli_query($conn, "	SELECT 		`order_orders_payings`.`id` AS id, 
													`order_orders_payings`.`radio_purpose` AS radio_purpose, 
													`order_orders_payings`.`radio_shipping` AS radio_shipping, 
													`order_orders_payings`.`shipping_free` AS shipping_free, 
													`order_orders_payings`.`radio_payment` AS radio_payment, 
													`order_orders_payings`.`radio_saturday` AS radio_saturday, 
													`order_orders_payings`.`radio_paying_netto` AS radio_paying_netto, 
													`order_orders_payings`.`price_total` AS price_total, 
													`order_orders_payings`.`payed` AS payed, 
													`order_orders_payings`.`mwst` AS mwst 
										FROM 		`order_orders_payings` 
										WHERE		`order_orders_payings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
										AND 		`order_orders_payings`.`order_id`='" . mysqli_real_escape_string($conn, intval($order_id)) . "' 
										ORDER BY 	CAST(`order_orders_payings`.`time` AS UNSIGNED) ASC");

		while($row_payings = $result->fetch_array(MYSQLI_ASSOC)){
			/*
				Angebote sollten nicht gezählt werden
				Gutschrift ist ein negativer Betrag 
				Rechnung und Differenzrechnung ist ganz normal ein normaler Betrag
			*/
			switch(intval($row_payings['radio_purpose'])){
				case 0: // Angebot 
					break;
				case 1: // Gutschrift
					$amount_netto -= ($row_payings["radio_paying_netto"] == 0 ? $row_payings["price_total"] : $row_payings["price_total"] / (100 + $row_payings['mwst']) * 100);
					$amount_mwst -= ($row_payings["radio_paying_netto"] == 0 ? $row_payings["price_total"] / 100 * $row_payings['mwst'] : $row_payings["price_total"] / (100 + $row_payings['mwst']) * $row_payings['mwst']);
					$amount_brutto -= ($row_payings["radio_paying_netto"] == 0 ? $row_payings["price_total"] / 100 * (100 + $row_payings['mwst']) : $row_payings["price_total"]);
					if($row_payings["shipping_free"] == 0){
						$amount_shipping -= $shipping_costs[$row_payings["radio_shipping"]];
					}
					$amount_payment -= $payment_costs[$row_payings["radio_payment"]];
					$amount_saturday -= (intval($row_payings['radio_shipping']) < 2 ? $saturday_costs[$row_payings["radio_saturday"]] : 0.00);
					break;
				case 2: // Rechnung
					if($row_payings["payed"] == 0){
						$amount_netto += ($row_payings["radio_paying_netto"] == 0 ? $row_payings["price_total"] : $row_payings["price_total"] / (100 + $row_payings['mwst']) * 100);
						$amount_mwst += ($row_payings["radio_paying_netto"] == 0 ? $row_payings["price_total"] / 100 * $row_payings['mwst'] : $row_payings["price_total"] / (100 + $row_payings['mwst']) * $row_payings['mwst']);
						$amount_brutto += ($row_payings["radio_paying_netto"] == 0 ? $row_payings["price_total"] / 100 * (100 + $row_payings['mwst']) : $row_payings["price_total"]);
						if($row_payings["shipping_free"] == 0){
							$amount_shipping += $shipping_costs[$row_payings["radio_shipping"]];
						}
						$amount_payment += $payment_costs[$row_payings["radio_payment"]];
						$amount_saturday += (intval($row_payings['radio_shipping']) < 2 ? $saturday_costs[$row_payings["radio_saturday"]] : 0.00);
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
						$amount_payment += $payment_costs[$row_payings["radio_payment"]];
						$amount_saturday += (intval($row_payings['radio_shipping']) < 2 ? $saturday_costs[$row_payings["radio_saturday"]] : 0.00);
					}
					break;
			}
			$this->payings++;

		}

		$this->value = $amount_brutto + $amount_shipping + $amount_payment + $amount_saturday;

    }

	public function getSum() {

		return $this->value;

	}

	public function getSignSum() {

		return ($this->value >= 0 ? "+" : "-") . number_format($this->value, 2, ',', '');

	}

	public function getPoint() {

		if($this->payings == 0){
			return "fa fa-ban text-warning";
		}else{
			return $this->value > 0 ? "fa fa-ban text-danger" : "fa fa-check text-success";
		}

	}

}

?>