<?php 

function getRow($time, $conn){

	$date = date("d.m.Y", $time);
	$day = strtotime($date);

	$order_shippings = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM `order_orders_shipments` WHERE `order_orders_shipments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_shipments`.`time`>='" . $day . "' AND `order_orders_shipments`.`time`<'" . ($day + 86400) . "'"), MYSQLI_ASSOC);

	$shipping_shippings = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM `shipping_history` WHERE `shipping_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `shipping_history`.`time`>='" . $day . "' AND `shipping_history`.`time`<'" . ($day + 86400) . "'"), MYSQLI_ASSOC);

	return "<tr><td>" . $date . "</td><td class='text-center'>" . $order_shippings['cnt'] . "</td><td class='text-center'>" . $shipping_shippings['cnt'] . "</td><td class='text-center'>" . ($order_shippings['cnt'] + $shipping_shippings['cnt']) . "</td></tr>\n";

}

$t = time();

$time_month = mktime(0, 0, 0, intval(date("n", $t)), 1, intval(date("Y", $t)));

$_POST['year_month'] = isset($_POST['year_month']) ? intval($_POST['year_month']) : $time_month;

$time = isset($_POST['set_date']) && strip_tags($_POST['set_date']) == "per Monat" ? intval($_POST['year_month']) : $t;

$year_from = date("Y", $time);
$month_from = date("n", $time);
$day_from = date("j", $time);

$year_to = date("Y", $time);
$month_to = date("n", $time);
$day_to = date("j", $time);

$days = 0;

$counter = 0;

$admin_name = "";
$admin_input = "";

$max_orders_target = 0;

$html_status_boxes = "";

if(!isset($_POST['set_date'])){
	$_POST['admin_id'] = intval($_SESSION["admin"]["id"]);
	$_POST['set_date'] = "Heute";
}

if(isset($_POST['set_date']) && $_POST['set_date'] == "Heute"){
	$time = $t;

	$year_from = date("Y", $time);
	$month_from = date("n", $time);
	$day_from = date("j", $time);

	$year_to = date("Y", $time);
	$month_to = date("n", $time);
	$day_to = date("j", $time + (24 * 60 * 60));

	$counter = 1;
}

if(isset($_POST['set_date']) && $_POST['set_date'] == "1 Tag"){
	$time = $t - (24 * 60 * 60);

	$year_from = date("Y", $time);
	$month_from = date("n", $time);
	$day_from = date("j", $time);

	$year_to = date("Y", $time);
	$month_to = date("n", $time);
	$day_to = date("j", $time);

	if($day_to > 0){
		$day_from = $day_to - 0;
	}else{
		if($month_from == 1){
			$month_from = 12;
			$year_from--;
		}else{
			$month_from--;
		}
		$month_days_from = date("t", mktime(0, 0, 0, $month_from, 1, $year_from));
		$day_from = $month_days_from - (0 - $day_to);
	}
	$days = 0;
	$counter = 2;
}

if(isset($_POST['set_date']) && $_POST['set_date'] == "2 Tag(e)"){
	$time = $t - (24 * 60 * 60);

	$year_from = date("Y", $time);
	$month_from = date("n", $time);
	$day_from = date("j", $time);

	$year_to = date("Y", $time);
	$month_to = date("n", $time);
	$day_to = date("j", $time);

	if($day_to > 1){
		$day_from = $day_to - 1;
	}else{
		if($month_from == 1){
			$month_from = 12;
			$year_from--;
		}else{
			$month_from--;
		}
		$month_days_from = date("t", mktime(0, 0, 0, $month_from, 1, $year_from));
		$day_from = $month_days_from - (1 - $day_to);
	}
	$days = 1;
	$counter = 3;
}

if(isset($_POST['set_date']) && $_POST['set_date'] == "3 Tag(e)"){
	$time = $t - (24 * 60 * 60);

	$year_from = date("Y", $time);
	$month_from = date("n", $time);
	$day_from = date("j", $time);

	$year_to = date("Y", $time);
	$month_to = date("n", $time);
	$day_to = date("j", $time);

	if($day_to > 2){
		$day_from = $day_to - 2;
	}else{
		if($month_from == 1){
			$month_from = 12;
			$year_from--;
		}else{
			$month_from--;
		}
		$month_days_from = date("t", mktime(0, 0, 0, $month_from, 1, $year_from));
		$day_from = $month_days_from - (2 - $day_to);
	}
	$days = 2;
	$counter = 4;
}

if(isset($_POST['set_date']) && $_POST['set_date'] == "1 Woche"){
	$time = $t - (24 * 60 * 60);

	$year_from = date("Y", $time);
	$month_from = date("n", $time);
	$day_from = date("j", $time);

	$year_to = date("Y", $time);
	$month_to = date("n", $time);
	$day_to = date("j", $time);

	if($day_to > 6){
		$day_from = $day_to - 6;
	}else{
		if($month_from == 1){
			$month_from = 12;
			$year_from--;
		}else{
			$month_from--;
		}
		$month_days_from = date("t", mktime(0, 0, 0, $month_from, 1, $year_from));
		$day_from = $month_days_from - (6 - $day_to);
	}
	$days = 6;
	$counter = 8;
}

if(isset($_POST['set_date']) && $_POST['set_date'] == "2 Wochen"){
	$time = $t - (24 * 60 * 60);

	$year_from = date("Y", $time);
	$month_from = date("n", $time);
	$day_from = date("j", $time);

	$year_to = date("Y", $time);
	$month_to = date("n", $time);
	$day_to = date("j", $time);

	if($day_to > 13){
		$day_from = $day_to - 13;
	}else{
		if($month_from == 1){
			$month_from = 12;
			$year_from--;
		}else{
			$month_from--;
		}
		$month_days_from = date("t", mktime(0, 0, 0, $month_from, 1, $year_from));
		$day_from = $month_days_from - (13 - $day_to);
	}
	$days = 13;
	$counter = 15;
}

if(isset($_POST['set_date']) && $_POST['set_date'] == "3 Wochen"){
	$time = $t - (24 * 60 * 60);

	$year_from = date("Y", $time);
	$month_from = date("n", $time);
	$day_from = date("j", $time);

	$year_to = date("Y", $time);
	$month_to = date("n", $time);
	$day_to = date("j", $time);

	if($day_to > 17){
		$day_from = $day_to - 17;
	}else{
		if($month_from == 1){
			$month_from = 12;
			$year_from--;
		}else{
			$month_from--;
		}
		$month_days_from = date("t", mktime(0, 0, 0, $month_from, 1, $year_from));
		$day_from = $month_days_from - (17 - $day_to);
	}
	$days = 17;
	$counter = 19;
}

if(isset($_POST['set_date']) && $_POST['set_date'] == "1 Monat"){
	$time = $t;

	$year_from = date("Y", $time);
	$month_from = date("n", $time);
	$day_from = date("j", $time);

	$time = $t - (24 * 60 * 60);

	$year_to = date("Y", $time);
	$month_to = date("n", $time);
	$day_to = date("j", $time);

	if($month_from == 1){
		$month_from = 12;
		$year_from--;
	}else{
		$month_from--;
	}
	$days = date("t", mktime(0, 0, 0, $month_from, 1, $year_from)) - 1;
	$counter = 32;
}

if(isset($_POST['set_date']) && $_POST['set_date'] == "2 Monate"){
	$time = $t;

	$year_from = date("Y", $time);
	$month_from = date("n", $time);
	$day_from = date("j", $time);

	$time = $t - (24 * 60 * 60);

	$year_to = date("Y", $time);
	$month_to = date("n", $time);
	$day_to = date("j", $time);

	$days1 = 0;
	$days2 = 0;
	if($month_from == 1){
		$month_from = 11;
		$year_from--;
		$days1 = date("t", mktime(0, 0, 0, $month_from, 1, $year_from));
		$days2 = date("t", mktime(0, 0, 0, ($month_from + 1), 1, $year_from));
	}elseif($month_from == 2){
		$days1 = date("t", mktime(0, 0, 0, ($month_from - 1), 1, $year_from));
		$month_from = 12;
		$year_from--;
		$days2 = date("t", mktime(0, 0, 0, ($month_from - 1), 1, $year_from));
	}else{
		$month_from--;
		$days1 = date("t", mktime(0, 0, 0, ($month_from - 1), 1, $year_from));
		$month_from--;
		$days2 = date("t", mktime(0, 0, 0, ($month_from - 1), 1, $year_from));
	}
	$days = $days1 + $days2;
	$counter = 63;
}

if(isset($_POST['set_date']) && strip_tags($_POST['set_date']) == "per Monat"){
	$day_to = date("t", $time);
	$days = $day_to - 1;
}

$admin_input = "<div class=\"col-sm-7 text-right\"><input type=\"hidden\" name=\"admin_id\" value=\"" . intval($_SESSION["admin"]["id"]) . "\" />\n";

$row_year = mysqli_fetch_array(mysqli_query($conn, "SELECT 		`statistic_year`.`id` AS id, 
																`statistic_year`.`number` AS number, 
																`statistic_year`.`month` AS month, 

																(SELECT COUNT(*) FROM `order_orders` WHERE `order_orders`.`mode`='0' AND `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "') AS all_orders, 

																(
																	SELECT 		COUNT(*) 
																	FROM 		`order_orders` 
																	WHERE		`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																	AND 		`order_orders`.`mode`='0' 
																	AND 		(
																					SELECT		`statuses`.`id` AS id 
																					FROM		`order_orders_statuses` 
																					LEFT JOIN	`statuses` 
																					ON			`statuses`.`id`=`order_orders_statuses`.`status_id` 
																					WHERE		`order_orders_statuses`.`order_id`=`order_orders`.`id` 
																					AND 		`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																					AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																					AND 		`statuses`.`public`>='0' 
																					ORDER BY CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC limit 0, 1
																				)='" . mysqli_real_escape_string($conn, intval($maindata['order_status'])) . "' 
																) AS statusses_new_orders, 

																(
																	SELECT 		COUNT(*) 
																	FROM 		`order_orders` 
																	WHERE		`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																	AND 		`order_orders`.`mode`='0' 
																	AND 		(
																					SELECT		`statuses`.`id` AS id 
																					FROM		`order_orders_statuses` 
																					LEFT JOIN	`statuses` 
																					ON			`statuses`.`id`=`order_orders_statuses`.`status_id` 
																					WHERE		`order_orders_statuses`.`order_id`=`order_orders`.`id` 
																					AND 		`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																					AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																					AND 		`statuses`.`public`>='0' 
																					ORDER BY CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC limit 0, 1
																				)='" . mysqli_real_escape_string($conn, intval($maindata['order_in_checkout_status'])) . "' 
																) AS statusses_in_checkout, 

																(
																	SELECT 	COUNT(*) 
																	FROM 	`order_orders_shipments` 
																	WHERE 	`order_orders_shipments`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																	AND 	`order_orders_shipments`.`time`>=UNIX_TIMESTAMP(CONCAT('" . $year_from . "-', '" . $month_from . "-" . $day_from . " 00:00:00')) 
																	AND 	`order_orders_shipments`.`time`<=UNIX_TIMESTAMP(CONCAT('" . $year_to . "-', '" . $month_to . "-" . ($day_to) . "', ' 23:59:59')) 
																) AS statusses_shipments, 


																(
																	SELECT 	COUNT(*) 
																	FROM 	`shipping_history` 
																	WHERE 	`shipping_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																	AND 	`shipping_history`.`time`>=UNIX_TIMESTAMP(CONCAT('" . $year_from . "-', '" . $month_from . "-" . $day_from . " 00:00:00')) 
																	AND 	`shipping_history`.`time`<=UNIX_TIMESTAMP(CONCAT('" . $year_to . "-', '" . $month_to . "-" . ($day_to) . "', ' 23:59:59')) 
																) AS statusses_shipping_history, 


																(
																	SELECT 		COUNT(*) 
																	FROM 		`order_orders` 
																	WHERE 		`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																	AND 		`order_orders`.`mode`='0' 
																	AND 		(
																					SELECT		`statuses`.`id` AS id 
																					FROM		`order_orders_statuses` 
																					LEFT JOIN	`statuses` 
																					ON			`statuses`.`id`=`order_orders_statuses`.`status_id` 
																					WHERE		`order_orders_statuses`.`order_id`=`order_orders`.`id` 
																					AND 		`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																					AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																					AND 		`statuses`.`public`>='0' 
																					ORDER BY CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC limit 0, 1
																				)='" . mysqli_real_escape_string($conn, intval($maindata['order_extra_evaluation_status'])) . "' 
																) AS statusses_extra_evaluation, 

																(
																	SELECT 		COUNT(*) 
																	FROM 		`order_orders` 
																	WHERE 		`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																	AND 		`order_orders`.`mode`='0' 
																	AND 		(
																					SELECT		`statuses`.`id` AS id 
																					FROM		`order_orders_statuses` 
																					LEFT JOIN	`statuses` 
																					ON			`statuses`.`id`=`order_orders_statuses`.`status_id` 
																					WHERE		`order_orders_statuses`.`order_id`=`order_orders`.`id` 
																					AND 		`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																					AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																					AND 		`statuses`.`public`>='0' 
																					ORDER BY CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC limit 0, 1
																				)='" . mysqli_real_escape_string($conn, intval($maindata['order_inspection_process_status'])) . "' 
																) AS statusses_inspection_process, 

																(
																	SELECT 		COUNT(*) 
																	FROM 		`order_orders` 
																	WHERE 		`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																	AND 		`order_orders`.`mode`='0' 
																	AND 		(
																					SELECT		`statuses`.`id` AS id 
																					FROM		`order_orders_statuses` 
																					LEFT JOIN	`statuses` 
																					ON			`statuses`.`id`=`order_orders_statuses`.`status_id` 
																					WHERE		`order_orders_statuses`.`order_id`=`order_orders`.`id` 
																					AND 		`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																					AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																					AND 		`statuses`.`public`>='0' 
																					ORDER BY CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC limit 0, 1
																				)='" . mysqli_real_escape_string($conn, intval($maindata['order_extra_verification_status'])) . "' 
																) AS statusses_extra_verification, 

																(
																	SELECT 		COUNT(*) 
																	FROM 		`order_orders` 
																	WHERE 		`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																	AND 		`order_orders`.`mode`='0' 
																	AND 		(
																					SELECT		`statuses`.`id` AS id 
																					FROM		`order_orders_statuses` 
																					LEFT JOIN	`statuses` 
																					ON			`statuses`.`id`=`order_orders_statuses`.`status_id` 
																					WHERE		`order_orders_statuses`.`order_id`=`order_orders`.`id` 
																					AND 		`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																					AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																					AND 		`statuses`.`public`>='0' 
																					ORDER BY CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC limit 0, 1
																				)='" . mysqli_real_escape_string($conn, intval($maindata['order_extra_edit_status'])) . "' 
																) AS statusses_extra_edit, 

																(
																	SELECT 		COUNT(*) 
																	FROM 		`order_orders` 
																	WHERE 		`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																	AND 		`order_orders`.`mode`='0' 
																	AND 		(
																					SELECT		`statuses`.`id` AS id 
																					FROM		`order_orders_statuses` 
																					LEFT JOIN	`statuses` 
																					ON			`statuses`.`id`=`order_orders_statuses`.`status_id` 
																					WHERE		`order_orders_statuses`.`order_id`=`order_orders`.`id` 
																					AND 		`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																					AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
																					AND 		`statuses`.`public`>='0' 
																					ORDER BY CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC limit 0, 1
																				)='" . mysqli_real_escape_string($conn, intval($maindata['order_extra_checkout_status'])) . "' 
																) AS statusses_extra_checkout
 
													FROM 		`statistic_year` 
													WHERE 		`statistic_year`.`id`='1'"), MYSQLI_ASSOC);

$admin_infos_table_tr = "";

$result = mysqli_query($conn, "	SELECT 		`admin`.`id` AS id, 
											`admin`.`name` AS name, 
											(
												SELECT	COUNT(*) 
												FROM	`order_orders_statuses` 
												WHERE	`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
												AND 	`order_orders_statuses`.`time`>=UNIX_TIMESTAMP(CONCAT('" . $year_from . "-', '" . $month_from . "-" . $day_from . " 00:00:00')) 
												AND 	`order_orders_statuses`.`time`<=UNIX_TIMESTAMP(CONCAT('" . $year_to . "-', '" . $month_to . "-" . ($day_to) . "', ' 23:59:59')) 
												AND 	`order_orders_statuses`.`admin_id`=`admin`.`id` 
												AND 	`order_orders_statuses`.`status_id`='" . mysqli_real_escape_string($conn, intval($maindata['order_recall_status'])) . "'
											) AS recall, 
											(
												SELECT	COUNT(*) 
												FROM	`order_orders_statuses` 
												WHERE	`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
												AND 	`order_orders_statuses`.`time`>=UNIX_TIMESTAMP(CONCAT('" . $year_from . "-', '" . $month_from . "-" . $day_from . " 00:00:00')) 
												AND 	`order_orders_statuses`.`time`<=UNIX_TIMESTAMP(CONCAT('" . $year_to . "-', '" . $month_to . "-" . ($day_to) . "', ' 23:59:59')) 
												AND 	`order_orders_statuses`.`admin_id`=`admin`.`id` 
												AND 	`order_orders_statuses`.`status_id`='" . mysqli_real_escape_string($conn, intval($maindata['order_claim_status'])) . "'
											) AS claim 
								FROM 		`admin` 
								WHERE		`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								ORDER BY 	recall DESC");

while($row_admin = $result->fetch_array(MYSQLI_ASSOC)){
	if($row_admin['recall'] > 0 || $row_admin['claim'] > 0){
		$admin_infos_table_tr .= "	<tr class='text-light'><td><b>" . $row_admin['name'] . "</b></td><td class='text-center'>" . $row_admin['recall'] . "</td><td class='text-center'>" . $row_admin['claim'] . "</td></tr>\n";
	}
}

$admin_infos =	"<table class='table table-white table-sm table-bordered text-white m-0'>\n" . 
				"	<tr><th><b>Name</b></th><th><b>Rückruf</b></th><th><b>Reklamation</b></th></tr>\n" . 
				$admin_infos_table_tr . 
				"</table>";

$time = time();

$shipping_infos =	"<table class='table table-white table-sm table-bordered text-white m-0'>\n" . 
					"	<tr><th><b>Datum</b></th><th><b>Auftrag/Sendungen</b></th><th><b>Versand/Sendungen</b></th><th><b>Gesamt</b></th></tr>\n";

for($r = 0;$r < $counter;$r++){
	if($r == 0 && $counter == 1){
		$shipping_infos .=  getRow($time - (86400 * $r), $conn);
	}
	if($r > 0){
		$shipping_infos .=  getRow($time - (86400 * $r), $conn);
	}
}

$shipping_infos .= "</table>";



$html_status_boxes =	"<div class=\"card_lb_success bg-white text-left shadow\">\n" . 
						"	<div class=\"card_lb_content\">\n" . 
						"		<span class=\"card_lb_title text-success\">Neuaufträge</span><span class=\"card_lb_percent\">" . intval($row_year['all_orders'] > 0 ? 100 / $row_year['all_orders'] * ($row_year['statusses_new_orders'] + $row_year['statusses_in_checkout']) : 0) . "%</span><br />\n" . 
						"		<span class=\"card_lb_value\">" . ($row_year['statusses_new_orders'] + $row_year['statusses_in_checkout']) . " von " . $row_year['all_orders'] . "</span>\n" . 
						"	</div>\n" . 
						"	<div class=\"card_lb_logo text-center mt-1\">\n" . 
						"		<i class=\"fa fa-cart-arrow-down fa_icon card_lb_logo_size text-light\"></i>\n" . 
						"	</div>\n" . 
						"</div>\n" . 
						"<div class=\"card_lb_danger bg-white text-left shadow\">\n" . 
						"	<div class=\"card_lb_content\">\n" . 
						"		<span class=\"card_lb_title text-danger\">Prüfungen</span><span class=\"card_lb_percent\">" . intval($row_year['all_orders'] > 0 ? 100 / $row_year['all_orders'] * ($row_year['statusses_extra_evaluation'] + $row_year['statusses_inspection_process'] + $row_year['statusses_extra_verification'] + $row_year['statusses_extra_edit'] + $row_year['statusses_extra_checkout']) : 0) . "%</span><br />\n" . 
						"		<span class=\"card_lb_value\">" . ($row_year['statusses_extra_evaluation'] + $row_year['statusses_inspection_process'] + $row_year['statusses_extra_verification'] + $row_year['statusses_extra_edit'] + $row_year['statusses_extra_checkout']) . " von " . $row_year['all_orders'] . "</span>\n" . 
						"	</div>\n" . 
						"	<div class=\"card_lb_logo text-center mt-1\">\n" . 
						"		<i class=\"fa fa-check-square fa_icon card_lb_logo_size text-light\"></i>\n" . 
						"	</div>\n" . 
						"</div>\n" . 
						"<div class=\"card_lb_warning bg-white text-left shadow\">\n" . 
						"	<div class=\"card_lb_content\">\n" . 
						"		<span class=\"card_lb_title text-warning\">Versand</span><span class=\"card_lb_percent\"></span><br />\n" . 
						"		<span class=\"card_lb_value\"><a href=\"#\" data-toggle=\"tooltip\" data-html=\"true\" data-placement=\"top\" title=\"" . $shipping_infos . "\">" . ($row_year['statusses_shipments'] + $row_year['statusses_shipping_history']) . "</a></span>\n" . 
						"	</div>\n" . 
						"	<div class=\"card_lb_logo text-center mt-1\">\n" . 
						"		<i class=\"fa fa-truck fa_icon card_lb_logo_size text-light\"></i>\n" . 
						"	</div>\n" . 
						"</div>\n" . 
						"<div class=\"card_lb_info bg-white text-left shadow\">\n" . 
						"	<div class=\"card_lb_content\">\n" . 
						"		<span class=\"card_lb_title text-info\">Zentrale</span><span class=\"card_lb_percent\">&nbsp;</span><br />\n" . 
						"		<div class=\"card_lb_value_div\"><div class=\"card_lb_value_content\"><span class=\"card_lb_value\"><a href=\"#\" data-toggle=\"tooltip\" data-html=\"true\" data-placement=\"top\" title=\"" . $admin_infos . "\">ansehen</a></span></div></div>\n" . 
						"	</div>\n" . 
						"	<div class=\"card_lb_logo text-center mt-1\">\n" . 
						"		<i class=\"fa fa-list fa_icon card_lb_logo_size text-light\"></i>\n" . 
						"	</div>\n" . 
						"</div>\n";

$months = array(1 => 'Januar', 2 => 'Februar', 3 => 'März', 4 => 'April', 5 => 'Mai', 6 => 'Juni', 7 => 'Juli', 8 => 'August', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Dezember');

$m = intval(date("n", $t));

$y = intval(date("Y", $t));

$options_month = " <optgroup label=\"" . $y . "\">\n";

$max = 12 * 10;

for($i = 0;$i < $max;$i++){

	if($m == 12 && $i > 0 && $i < $max){

		$options_month .= " <optgroup label=\"" . $y . "\">\n";

	}

	$options_month .= "	<option value=\"" . mktime(0, 0, 0, $m, 1, $y) . "\"" . (mktime(0, 0, 0, $m, 1, $y) == (isset($_POST['year_month']) && intval($_POST['year_month']) > 0 ? intval($_POST['year_month']) : $time_month) ? " selected=\"selected\"" : "") . ">" . $months[$m] . "</option>\n";

	if($m == 1){

		$options_month .= " </optgroup>\n";

		$y--;

		$m = 12;

	}else{

		$m--;

	}

	if($i == $max){

		$options_month .= " </optgroup>\n";

	}

}

$html_status_boxes =	$html_status_boxes == "" ? 
							"" 
						: 
							"<style>\n" . 
							".card_lb_success {\n" . 
							"	display: inline-block;\n" . 
							"	width: calc(25% - 10px);\n" . 
							"	border-top: 1px solid rgba(0,0,0,0.125);\n" . 
							"	border-right: 1px solid rgba(0,0,0,0.125);\n" . 
							"	border-bottom: 1px solid rgba(0,0,0,0.125);\n" . 
							"	border-left: 4px solid var(--success);\n" . 
							"	border-radius: .35rem;\n" . 
							"	padding: 18px 10px 18px 20px;\n" . 
							"	margin: 0 10px 0 0;\n" . 
							"}\n" . 
							".card_lb_warning {\n" . 
							"	display: inline-block;\n" . 
							"	width: calc(25% - 20px);\n" . 
							"	border-top: 1px solid rgba(0,0,0,0.125);\n" . 
							"	border-right: 1px solid rgba(0,0,0,0.125);\n" . 
							"	border-bottom: 1px solid rgba(0,0,0,0.125);\n" . 
							"	border-left: 4px solid var(--warning);\n" . 
							"	border-radius: .35rem;\n" . 
							"	padding: 18px 10px 18px 20px;\n" . 
							"	margin: 0 10px;\n" . 
							"}\n" . 
							".card_lb_danger {\n" . 
							"	display: inline-block;\n" . 
							"	width: calc(25% - 20px);\n" . 
							"	border-top: 1px solid rgba(0,0,0,0.125);\n" . 
							"	border-right: 1px solid rgba(0,0,0,0.125);\n" . 
							"	border-bottom: 1px solid rgba(0,0,0,0.125);\n" . 
							"	border-left: 4px solid var(--danger);\n" . 
							"	border-radius: .35rem;\n" . 
							"	padding: 18px 10px 18px 20px;\n" . 
							"	margin: 0 10px;\n" . 
							"}\n" . 
							".card_lb_info {\n" . 
							"	display: inline-block;\n" . 
							"	width: calc(24% - 10px);\n" . 
							"	border-top: 1px solid rgba(0,0,0,0.125);\n" . 
							"	border-right: 1px solid rgba(0,0,0,0.125);\n" . 
							"	border-bottom: 1px solid rgba(0,0,0,0.125);\n" . 
							"	border-left: 4px solid var(--info);\n" . 
							"	border-radius: .35rem;\n" . 
							"	padding: 18px 10px 18px 20px;\n" . 
							"	margin: 0 0 0 10px;\n" . 
							"}\n" . 
							".card_lb_content {\n" . 
							"	float: left;\n" . 
							"	width: calc(100% - 60px);\n" . 
							"}\n" . 
							".card_lb_title {\n" . 
							"	font-size: 11pt;\n" . 
							"	font-weight: 600;\n" . 
							"}\n" . 
							".card_lb_percent {\n" . 
							"	font-size: 13pt;\n" . 
							"	font-weight: 600;\n" . 
							"	margin: 0 0 0 30px;\n" . 
							"}\n" . 
							".card_lb_value_div {\n" . 
							"	display: block;\n" . 
							"}\n" . 
							".card_lb_value_content {\n" . 
							"	display: inline-block;\n" . 
							"}\n" . 
							".card_lb_value {\n" . 
							"	font-size: 18pt;\n" . 
							"}\n" . 
							".card_lb_progress {\n" . 
							"	display: inline-block;\n" . 
							"	height: 8px;\n" . 
							"	background-color: var(--light);\n" . 
							"	width: 80%;\n" . 
							//"	border: 1px solid var(--primary);\n" . 
							"	border-radius: 5px;\n" . 
							"	padding: 1px;\n" . 
							"	margin: 0 0 4px 8px;\n" . 
							"}\n" . 
							".card_lb_progress_bar {\n" . 
							"	float: left;\n" . 
							"	height: 6px;\n" . 
							"	background-color: var(--info);\n" . 
							"	border-radius: 4px;\n" . 
							"	padding: 0;\n" . 
							"	margin: 0 0 2px 0;\n" . 
							"}\n" . 
							".card_lb_logo {\n" . 
							"	width: 60px;\n" . 
							"	float: left;\n" . 
							"}\n" . 
							".card_lb_logo_size {\n" . 
							"	font-size: 48px;\n" . 
							"}\n" . 
							".cursor-pointer {\n" . 
							"	cursor: pointer;\n" . 
							"}\n" . 
							"</style>\n" . 

							"<div>\n" . 
							"		<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
							"			<div class=\"text-right mb-3\">\n" . 
							"				<div class=\"form-group row mb-0\">\n" . 
							"					<div class=\"col-sm-5 text-left\">\n" . 
							"						<h2>Persönliche Übersicht</h2>\n" . 
							"					</div>\n" . 

							$admin_input . 
					
							"						<button type=\"submit\" name=\"set_date\" value=\"Heute\" class=\"btn btn-sm btn-" . (isset($_POST['set_date']) && $_POST['set_date'] == "Heute" ? "success" : "primary") . "\">Heute <i class=\"fa fa-calendar\" aria-hidden=\"true\"></i></button>\n" . 
							"						<button type=\"submit\" name=\"set_date\" value=\"1 Tag\" class=\"btn btn-sm btn-" . (isset($_POST['set_date']) && $_POST['set_date'] == "1 Tag" ? "success" : "primary") . "\">1 Tag <i class=\"fa fa-calendar\" aria-hidden=\"true\"></i></button>\n" . 
							"						<button type=\"submit\" name=\"set_date\" value=\"2 Tag(e)\" class=\"btn btn-sm btn-" . (isset($_POST['set_date']) && $_POST['set_date'] == "2 Tag(e)" ? "success" : "primary") . "\">2 Tag(e) <i class=\"fa fa-calendar\" aria-hidden=\"true\"></i></button>\n" . 
							"						<button type=\"submit\" name=\"set_date\" value=\"3 Tag(e)\" class=\"btn btn-sm btn-" . (isset($_POST['set_date']) && $_POST['set_date'] == "3 Tag(e)" ? "success" : "primary") . "\">3 Tag(e) <i class=\"fa fa-calendar\" aria-hidden=\"true\"></i></button>\n" . 
							"						<button type=\"submit\" name=\"set_date\" value=\"1 Woche\" class=\"btn btn-sm btn-" . (isset($_POST['set_date']) && $_POST['set_date'] == "1 Woche" ? "success" : "primary") . "\">1 Woche <i class=\"fa fa-calendar\" aria-hidden=\"true\"></i></button>\n" . 
							"						<button type=\"submit\" name=\"set_date\" value=\"2 Wochen\" class=\"btn btn-sm btn-" . (isset($_POST['set_date']) && $_POST['set_date'] == "2 Wochen" ? "success" : "primary") . "\">2 Wochen <i class=\"fa fa-calendar\" aria-hidden=\"true\"></i></button>\n" . 
							"						<button type=\"submit\" name=\"set_date\" value=\"3 Wochen\" class=\"btn btn-sm btn-" . (isset($_POST['set_date']) && $_POST['set_date'] == "3 Wochen" ? "success" : "primary") . "\">3 Wochen <i class=\"fa fa-calendar\" aria-hidden=\"true\"></i></button>\n" . 
							"						<button type=\"submit\" name=\"set_date\" value=\"1 Monat\" class=\"btn btn-sm btn-" . (isset($_POST['set_date']) && $_POST['set_date'] == "1 Monat" ? "success" : "primary") . "\">1 Monat <i class=\"fa fa-calendar\" aria-hidden=\"true\"></i></button>\n" . 
							"					</div>\n" . 
							"				</div>\n" . 
							"			</div>\n" . 
							"		</form>\n" . 
							"	<div>\n" . 

							$html_status_boxes . 

							"	</div>\n" . 
							"</div>\n";

?>