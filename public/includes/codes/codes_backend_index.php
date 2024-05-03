<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "start";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_navigation.php");

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

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

$max_orders_target = 0;

$html_status_boxes = "";

if(!isset($_POST['set_date'])){
	$_POST['admin_id'] = intval($_SESSION["admin"]["id"]);
	$_POST['set_date'] = "1 Monat";
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
}

if(isset($_POST['set_date']) && strip_tags($_POST['set_date']) == "per Monat"){
	$day_to = date("t", $time);
	$days = $day_to - 1;
}

$tr_0 = "";
$tr_1 = "";
$tr_2 = "";

$result = mysqli_query($conn, "	SELECT 		`admin`.`id` AS id, 
											`admin`.`name` AS name, 
											`admin`.`max_orders_target` AS max_orders_target, 
											`admin_roles`.`func` AS func 
								FROM 		`admin` 
								LEFT JOIN	`admin_roles` 
								ON			`admin_roles`.`id`=`admin`.`role` 
								WHERE		`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								AND 		`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								ORDER BY 	`admin`.`name` ASC");

while($row_item = $result->fetch_array(MYSQLI_ASSOC)){

	$and_0 = "AND `order_orders`.`agent_id`=" . intval($row_item['id']) . " ";
	$and_1 = "AND `order_orders`.`creator_id`=" . intval($row_item['id']) . " ";

	$td_statistic = "";

	if($row_item['func'] == 0){ // Keine

		$tr_0 .= "	<tr>\n		<td>" . $row_item['name'] . "</td>\n		<td>&nbsp;</td>\n		<td>&nbsp;</td>\n		<td>&nbsp;</td>\n		<td>&nbsp;</td>\n		<td>&nbsp;</td>\n	</tr>\n";

	}

	if($row_item['func'] == 1){ // Verkäufer
	
		$row_year = mysqli_fetch_array(mysqli_query($conn, "SELECT 		`statistic_year`.`id` AS id, 
																		`statistic_year`.`number` AS number, 
																		`statistic_year`.`month` AS month, 
		
																		(SELECT COUNT(*) FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`reg_date`>=UNIX_TIMESTAMP(CONCAT('" . $year_from . "-', '" . $month_from . "-" . $day_from . " 00:00:00')) AND `order_orders`.`reg_date`<=UNIX_TIMESTAMP(CONCAT('" . $year_to . "-', '" . $month_to . "-" . ($day_to) . "', ' 23:59:59'))) AS all_orders, 
		
																		(SELECT COUNT(*) FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`reg_date`>=UNIX_TIMESTAMP(CONCAT('" . $year_from . "-', '" . $month_from . "-" . $day_from . " 00:00:00')) AND `order_orders`.`reg_date`<=UNIX_TIMESTAMP(CONCAT('" . $year_to . "-', '" . $month_to . "-" . ($day_to) . "', ' 23:59:59')) AND (`order_orders`.`mode`='0' OR `order_orders`.`mode`='1') " . $and_0 . ") AS orders_by_interesteds, 
		
																		(SELECT COUNT(*) FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`reg_date`>=UNIX_TIMESTAMP(CONCAT('" . $year_from . "-', '" . $month_from . "-" . $day_from . " 00:00:00')) AND `order_orders`.`reg_date`<=UNIX_TIMESTAMP(CONCAT('" . $year_to . "-', '" . $month_to . "-" . ($day_to) . "', ' 23:59:59')) AND `order_orders`.`mode`='2') AS interesteds, 
		
																		(SELECT COUNT(*) FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`reg_date`>=UNIX_TIMESTAMP(CONCAT('" . $year_from . "-', '" . $month_from . "-" . $day_from . " 00:00:00')) AND `order_orders`.`reg_date`<=UNIX_TIMESTAMP(CONCAT('" . $year_to . "-', '" . $month_to . "-" . ($day_to) . "', ' 23:59:59')) AND `order_orders`.`mode`='3' " . $and_0 . ") AS interesteds_archiv 
		
															FROM 		`statistic_year` 
															WHERE 		`statistic_year`.`id`='1'"), MYSQLI_ASSOC);
	
		$tr_1 .=	"	<tr>\n" . 
					"		<td>" . $row_item['name'] . "</td>\n" . 
					"		<td align=\"center\">" . $row_year['orders_by_interesteds'] . "</td>\n" . 
					"		<td align=\"center\">" . $row_year['interesteds'] . "</td>\n" . 
					"		<td align=\"center\">" . $row_year['interesteds_archiv'] . "</td>\n" . 
					"		<td align=\"center\">" . $row_year['all_orders'] . "</td>\n" . 
					"		<td align=\"center\">" . number_format($row_item['max_orders_target'] > 0 ? 100 / $row_item['max_orders_target'] * $row_year['orders_by_interesteds'] : 0, 0, ',', '') . "%</td>\n" . 
					"	</tr>\n";

	}

	if($row_item['func'] == 2){ // Ersteller
	
		$row_year = mysqli_fetch_array(mysqli_query($conn, "SELECT 		`statistic_year`.`id` AS id, 
																		`statistic_year`.`number` AS number, 
																		`statistic_year`.`month` AS month, 
		
																		(SELECT COUNT(*) FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`reg_date`>=UNIX_TIMESTAMP(CONCAT('" . $year_from . "-', '" . $month_from . "-" . $day_from . " 00:00:00')) AND `order_orders`.`reg_date`<=UNIX_TIMESTAMP(CONCAT('" . $year_to . "-', '" . $month_to . "-" . ($day_to) . "', ' 23:59:59'))) AS all_orders, 
		
																		(SELECT COUNT(*) FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`reg_date`>=UNIX_TIMESTAMP(CONCAT('" . $year_from . "-', '" . $month_from . "-" . $day_from . " 00:00:00')) AND `order_orders`.`reg_date`<=UNIX_TIMESTAMP(CONCAT('" . $year_to . "-', '" . $month_to . "-" . ($day_to) . "', ' 23:59:59')) AND (`order_orders`.`mode`='0' OR `order_orders`.`mode`='1') " . $and_1 . ") AS orders_by_interesteds, 
		
																		(SELECT COUNT(*) FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`reg_date`>=UNIX_TIMESTAMP(CONCAT('" . $year_from . "-', '" . $month_from . "-" . $day_from . " 00:00:00')) AND `order_orders`.`reg_date`<=UNIX_TIMESTAMP(CONCAT('" . $year_to . "-', '" . $month_to . "-" . ($day_to) . "', ' 23:59:59')) AND `order_orders`.`mode`='2' " . $and_1 . ") AS interesteds, 
		
																		(SELECT COUNT(*) FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`reg_date`>=UNIX_TIMESTAMP(CONCAT('" . $year_from . "-', '" . $month_from . "-" . $day_from . " 00:00:00')) AND `order_orders`.`reg_date`<=UNIX_TIMESTAMP(CONCAT('" . $year_to . "-', '" . $month_to . "-" . ($day_to) . "', ' 23:59:59')) AND `order_orders`.`mode`='3' " . $and_1 . ") AS interesteds_archiv 
		
															FROM 		`statistic_year` 
															WHERE 		`statistic_year`.`id`='1'"), MYSQLI_ASSOC);
	
		$tr_2 .=	"	<tr>\n" . 
					"		<td>" . $row_item['name'] . "</td>\n" . 
					"		<td align=\"center\">" . $row_year['orders_by_interesteds'] . "</td>\n" . 
					"		<td align=\"center\">" . $row_year['interesteds'] . "</td>\n" . 
					"		<td align=\"center\">" . $row_year['interesteds_archiv'] . "</td>\n" . 
					"		<td align=\"center\">" . $row_year['all_orders'] . "</td>\n" . 
					"		<td align=\"center\">" . number_format($row_item['max_orders_target'] > 0 ? 100 / $row_item['max_orders_target'] * $row_year['orders_by_interesteds'] : 0, 0, ',', '') . "%</td>\n" . 
					"	</tr>\n";

	}

}

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">\n" . 
		"		<h3>Admin - Start</h3>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<p>Willkommen zurück, " . $_SESSION["admin"]["name"] . "</p>\n" . 
		"<hr />\n" . 
		"<div class=\"card-deck mb-4\">\n" . 
		"	<div class=\"card card-minimize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
		"		<div class=\"card-header\"><h4 class=\"mb-0\">ORDERGO</h4></div>\n" . 
		"		<div class=\"card-body\">\n" . 
		"			<div class=\"form-group row\">\n" . 
		"				<div class=\"col-sm-4\">\n" . 
		"					Version\n" . 
		"				</div>\n" . 
		"				<div class=\"col-sm-8\">\n" . 
		"					1.02\n" . 
		"				</div>\n" . 
		"			</div>\n" . 
		"			<div class=\"form-group row\">\n" . 
		"				<div class=\"col-sm-4\">\n" . 
		"					Telefonnummern im Notfall\n" . 
		"				</div>\n" . 
		"				<div class=\"col-sm-3\">\n" . 
		"					<strong>Gazi Ahmad</strong>\n" . 
		"				</div>\n" . 
		"				<div class=\"col-sm-5\">\n" . 
		"					0421 / 59 56 49 22\n" . 
		"				</div>\n" . 
		"			</div>\n" . 
		"			<div class=\"form-group row\">\n" . 
		"				<div class=\"col-sm-4\">\n" . 
		"					Support\n" . 
		"				</div>\n" . 
		"				<div class=\"col-sm-8\">\n" . 
		"					<a href=\"mailto: " . $maindata['email'] . "\" class=\"text-" . $_SESSION["admin"]["color_link"] . "\">" . $maindata['email'] . "</a>\n" . 
		"				</div>\n" . 
		"			</div>\n" . 
		"			<div class=\"form-group row\">\n" . 
		"				<div class=\"col-sm-4\">\n" . 
		"					Frontend\n" . 
		"				</div>\n" . 
		"				<div class=\"col-sm-8\">\n" . 
		"					<a href=\"/\" class=\"text-" . $_SESSION["admin"]["color_link"] . "\" target=\"_blank\">öffnen</a>\n" . 
		"				</div>\n" . 
		"			</div>\n" . 
		"		</div>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<div class=\"card-deck mb-4\">\n" . 
		"	<div class=\"card card-minimize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
		"		<div class=\"card-header\">\n" . 
		"			<div class=\"row\">\n" . 
		"				<div class=\"col-sm-3\">\n" . 
		"					<h4 class=\"mb-0\">Statistik</h4>\n" . 
		"				</div>\n" . 
		"				<div class=\"col-sm-9 text-right\">\n" . 
		"					<form action=\"" . $page['url'] . "\" method=\"post\" class=\"form-group row mb-0\">\n" . 
		"						<div class=\"col-sm-12 text-right\">\n" . 
		"							<button type=\"submit\" name=\"set_date\" value=\"3 Tag(e)\" class=\"btn btn-sm btn-" . (isset($_POST['set_date']) && $_POST['set_date'] == "3 Tag(e)" ? "success" : "primary") . "\">3 Tag(e) <i class=\"fa fa-calendar\" aria-hidden=\"true\"></i></button>\n" . 
		"							<button type=\"submit\" name=\"set_date\" value=\"1 Woche\" class=\"btn btn-sm btn-" . (isset($_POST['set_date']) && $_POST['set_date'] == "1 Woche" ? "success" : "primary") . "\">1 Woche <i class=\"fa fa-calendar\" aria-hidden=\"true\"></i></button>\n" . 
		"							<button type=\"submit\" name=\"set_date\" value=\"2 Wochen\" class=\"btn btn-sm btn-" . (isset($_POST['set_date']) && $_POST['set_date'] == "2 Wochen" ? "success" : "primary") . "\">2 Wochen <i class=\"fa fa-calendar\" aria-hidden=\"true\"></i></button>\n" . 
		"							<button type=\"submit\" name=\"set_date\" value=\"3 Wochen\" class=\"btn btn-sm btn-" . (isset($_POST['set_date']) && $_POST['set_date'] == "3 Wochen" ? "success" : "primary") . "\">3 Wochen <i class=\"fa fa-calendar\" aria-hidden=\"true\"></i></button>\n" . 
		"							<button type=\"submit\" name=\"set_date\" value=\"1 Monat\" class=\"btn btn-sm btn-" . (isset($_POST['set_date']) && $_POST['set_date'] == "1 Monat" ? "success" : "primary") . "\">1 Monat <i class=\"fa fa-calendar\" aria-hidden=\"true\"></i></button>\n" . 
		"						</div>\n" . 
		"					</form>\n" . 
		"				</div>\n" . 
		"			</div>\n" . 
		"		</div>\n" . 
		"		<div class=\"card-body\">\n" . 
		"			<h2>Verkäufer Statistik</h2>\n" . 
		"			<div class=\"table-responsive\">\n" . 
		"				<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
		"					<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
		"						<th width=\"160\" scope=\"col\">\n" . 
		"							<strong>Name</strong>\n" . 
		"						</th>\n" . 
		"						<th width=\"200\" scope=\"col\">\n" . 
		"							<strong>Konvertierte Aufträge</strong>\n" . 
		"						</th>\n" . 
		"						<th scope=\"col\">\n" . 
		"							<strong>Offene Interessenten</strong>\n" . 
		"						</th>\n" . 
		"						<th scope=\"col\">\n" . 
		"							<strong>Verlorene Interessenten</strong>\n" . 
		"						</th>\n" . 
		"						<th width=\"100\" scope=\"col\" class=\"text-center\">\n" . 
		"							<strong>Gesamt</strong>\n" . 
		"						</th>\n" . 
		"						<th width=\"120\" scope=\"col\" class=\"text-center\">\n" . 
		"							<strong>Aufgabe</strong>\n" . 
		"						</th>\n" . 
		"					</tr></thead>\n" . 

		$tr_1 . 

		"				</table>\n" . 
		"			</div>\n" . 
		"			<br />\n" . 
		"			<h2>Ersteller Statistik</h2>\n" . 
		"			<div class=\"table-responsive\">\n" . 
		"				<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
		"					<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
		"						<th width=\"160\" scope=\"col\">\n" . 
		"							<strong>Name</strong>\n" . 
		"						</th>\n" . 
		"						<th width=\"200\" scope=\"col\">\n" . 
		"							<strong>Erstellte Aufträge</strong>\n" . 
		"						</th>\n" . 
		"						<th scope=\"col\">\n" . 
		"							<strong>Offene Interessenten</strong>\n" . 
		"						</th>\n" . 
		"						<th scope=\"col\">\n" . 
		"							<strong>Verlorene Interessenten</strong>\n" . 
		"						</th>\n" . 
		"						<th width=\"100\" scope=\"col\" class=\"text-center\">\n" . 
		"							<strong>Gesamt</strong>\n" . 
		"						</th>\n" . 
		"						<th width=\"120\" scope=\"col\" class=\"text-center\">\n" . 
		"							<strong>Aufgabe</strong>\n" . 
		"						</th>\n" . 
		"					</tr></thead>\n" . 

		$tr_2 . 

		"				</table>\n" . 
		"			</div>\n" . 
		"		</div>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<hr />\n" . 
		"<br />\n" . 
		"<br />\n" . 
		"<br />\n";
	
?>