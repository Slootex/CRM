<?php 

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

$admin_name = "";
$admin_input = "";

$max_orders_target = 0;

$html_status_boxes = "";

if(!isset($_POST['set_date'])){
	$_POST['admin_id'] = intval($_SESSION["admin"]["id"]);
	$_POST['set_date'] = "1 Monat";
}

if(isset($_POST['set_date']) && $_POST['set_date'] == "Heute"){
	$time = $t;

	$year_from = date("Y", $time);
	$month_from = date("n", $time);
	$day_from = date("j", $time);

	$year_to = date("Y", $time);
	$month_to = date("n", $time);
	$day_to = date("j", $time + (24 * 60 * 60));

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

$and_0 = "";
$and_1 = "";

switch($_SESSION["admin"]["roles"]["searchresult_rights"]){

	// Nur eigene Datensätze
	case 0:
		$and_0 .= "AND `order_orders`.`agent_id`=" . intval($_SESSION["admin"]["id"]) . " ";
		$and_1 .= "AND `order_orders`.`creator_id`=" . intval($_SESSION["admin"]["id"]) . " ";
		$row_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin` WHERE id='" . intval($_SESSION["admin"]["id"]) . "' AND company_id='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);
		$admin_name = $row_admin['name'];
		$max_orders_target = $row_admin['max_orders_target'];
		$admin_input = "<div class=\"col-sm-7 text-right\"><input type=\"hidden\" name=\"admin_id\" value=\"" . intval($_SESSION["admin"]["id"]) . "\" />\n";
		break;

	// Eigene und Dummy Datensätze
	case 1:
		$and_0 .= "AND (`order_orders`.`agent_id`=" . intval($_SESSION["admin"]["id"]) . " OR `order_orders`.`agent_id`=" . $maindata['admin_id'] . ") ";
		$and_1 .= "AND (`order_orders`.`creator_id`=" . intval($_SESSION["admin"]["id"]) . " OR `order_orders`.`creator_id`=" . $maindata['admin_id'] . ") ";
		$admin_name = "Eigene und Dummy";
		$max_orders_target = $_SESSION["admin"]["max_orders_target"];
		$admin_input = "<div class=\"col-sm-7 text-right\"><input type=\"hidden\" name=\"admin_id\" value=\"" . intval($_SESSION["admin"]["id"]) . "\" />\n";
		break;

	// Alle Datensätze
	case 2:
		$and_0 .= "AND `order_orders`.`agent_id`=" . (isset($_POST['admin_id']) && intval($_POST['admin_id']) > 0 ? intval($_POST['admin_id']) : intval($_SESSION["admin"]["id"])) . " ";
		$and_1 .= "AND `order_orders`.`creator_id`=" . (isset($_POST['admin_id']) && intval($_POST['admin_id']) > 0 ? intval($_POST['admin_id']) : intval($_SESSION["admin"]["id"])) . " ";
		$row_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin` WHERE id='" . (isset($_POST['admin_id']) && intval($_POST['admin_id']) > 0 ? intval($_POST['admin_id']) : intval($_SESSION["admin"]["id"])) . "' AND company_id='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);
		$admin_name = $row_admin['name'];
		$max_orders_target = $row_admin['max_orders_target'];
		$result = mysqli_query($conn, "	SELECT 		* 
										FROM 		`admin` 
										WHERE 		`admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
										ORDER BY 	CAST(`admin`.`role` AS UNSIGNED) ASC, CAST(`admin`.`id` AS UNSIGNED) ASC");
		while($row_admin = $result->fetch_array(MYSQLI_ASSOC)){
			$admin_input .= "	<option value=\"" . $row_admin['id'] . "\"" . ($row_admin['id'] == (isset($_POST['admin_id']) && intval($_POST['admin_id']) > 0 ? intval($_POST['admin_id']) : intval($_SESSION["admin"]["id"])) ? " selected=\"selected\"" : "") . ">" . $row_admin['name'] . "</option>\n";
		}
		$admin_input = "<div class=\"col-sm-1\"></div><div class=\"col-sm-1 text-right\"><select name=\"admin_id\" class=\"custom-select custom-select-sm d-none\">" . $admin_input . "</select></div><div class=\"col-sm-5 text-right\">\n";
		break;

}

// Year
if($_SESSION["admin"]["roles"]["func"] == 2){

	$row_year = mysqli_fetch_array(mysqli_query($conn, "SELECT 		`statistic_year`.`id` AS id, 
																	`statistic_year`.`number` AS number, 
																	`statistic_year`.`month` AS month, 
	
																	(SELECT COUNT(*) FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`reg_date`>=UNIX_TIMESTAMP(CONCAT('" . $year_from . "-', '" . $month_from . "-" . $day_from . " 00:00:00')) AND `order_orders`.`reg_date`<=UNIX_TIMESTAMP(CONCAT('" . $year_to . "-', '" . $month_to . "-" . ($day_to) . "', ' 23:59:59'))) AS all_orders, 
	
																	(SELECT COUNT(*) FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`reg_date`>=UNIX_TIMESTAMP(CONCAT('" . $year_from . "-', '" . $month_from . "-" . $day_from . " 00:00:00')) AND `order_orders`.`reg_date`<=UNIX_TIMESTAMP(CONCAT('" . $year_to . "-', '" . $month_to . "-" . ($day_to) . "', ' 23:59:59')) AND (`order_orders`.`mode`='0' OR `order_orders`.`mode`='1') " . $and_1 . ") AS orders_by_interesteds, 
	
																	(SELECT COUNT(*) FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`reg_date`>=UNIX_TIMESTAMP(CONCAT('" . $year_from . "-', '" . $month_from . "-" . $day_from . " 00:00:00')) AND `order_orders`.`reg_date`<=UNIX_TIMESTAMP(CONCAT('" . $year_to . "-', '" . $month_to . "-" . ($day_to) . "', ' 23:59:59')) AND `order_orders`.`mode`='2' " . $and_1 . ") AS interesteds, 
	
																	(SELECT COUNT(*) FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`reg_date`>=UNIX_TIMESTAMP(CONCAT('" . $year_from . "-', '" . $month_from . "-" . $day_from . " 00:00:00')) AND `order_orders`.`reg_date`<=UNIX_TIMESTAMP(CONCAT('" . $year_to . "-', '" . $month_to . "-" . ($day_to) . "', ' 23:59:59')) AND `order_orders`.`mode`='3' " . $and_1 . ") AS interesteds_archiv 
	
														FROM 		`statistic_year` 
														WHERE 		`statistic_year`.`id`='1'"), MYSQLI_ASSOC);

	$html_status_boxes =	"<div class=\"card_lb_success bg-white text-left shadow\">\n" . 
							"	<div class=\"card_lb_content\">\n" . 
							"		<span class=\"card_lb_title text-success\">Erstellte Aufträge</span><span class=\"card_lb_percent\">" . intval(100 / $row_year['all_orders'] * $row_year['orders_by_interesteds']) . "%</span><br />\n" . 
							"		<span class=\"card_lb_value\">" . $row_year['orders_by_interesteds'] . " von " . $row_year['all_orders'] . "</span>\n" . 
							"	</div>\n" . 
							"	<div class=\"card_lb_logo text-center mt-1\">\n" . 
							"		<i class=\"fa fa-cart-arrow-down fa_icon card_lb_logo_size text-light\"></i>\n" . 
							"	</div>\n" . 
							"</div>\n" . 
							"<div class=\"card_lb_warning bg-white text-left shadow\">\n" . 
							"	<div class=\"card_lb_content\">\n" . 
							"		<span class=\"card_lb_title text-warning\">Offene Interessenten</span><span class=\"card_lb_percent\">" . intval(100 / $row_year['all_orders'] * $row_year['interesteds']) . "%</span><br />\n" . 
							"		<span class=\"card_lb_value\">" . $row_year['interesteds'] . " von " . $row_year['all_orders'] . "</span>\n" . 
							"	</div>\n" . 
							"	<div class=\"card_lb_logo text-center mt-1\">\n" . 
							"		<i class=\"fa fa-phone fa_icon card_lb_logo_size text-light\"></i>\n" . 
							"	</div>\n" . 
							"</div>\n" . 
							"<div class=\"card_lb_danger bg-white text-left shadow\">\n" . 
							"	<div class=\"card_lb_content\">\n" . 
							"		<span class=\"card_lb_title text-danger\">Verlorene Interessenten</span><span class=\"card_lb_percent\">" . intval(100 / $row_year['all_orders'] * $row_year['interesteds_archiv']) . "%</span><br />\n" . 
							"		<span class=\"card_lb_value\">" . $row_year['interesteds_archiv'] . " von " . $row_year['all_orders'] . "</span>\n" . 
							"	</div>\n" . 
							"	<div class=\"card_lb_logo text-center mt-1\">\n" . 
							"		<i class=\"fa fa-user fa_icon card_lb_logo_size text-light\"></i>\n" . 
							"	</div>\n" . 
							"</div>\n" . 
							"<div class=\"card_lb_info bg-white text-left shadow\">\n" . 
							"	<div class=\"card_lb_content\">\n" . 
							"		<span class=\"card_lb_title text-info\">TASKS</span><span class=\"card_lb_percent\">&nbsp;</span><br />\n" . 
							"		<div class=\"card_lb_value_div\"><div class=\"card_lb_value_content\"><span class=\"card_lb_value\">" . number_format($max_orders_target > 0 ? 100 / $max_orders_target * $row_year['orders_by_interesteds'] : 0, 0, ',', '') . "%</span></div><div class=\"card_lb_progress\"><div class=\"card_lb_progress_bar\" style=\"width: " . number_format($max_orders_target > 0 ? 100 / $max_orders_target * $row_year['orders_by_interesteds'] : 0, 0, ',', '') . "%\"></div></div></div>\n" . 
							"	</div>\n" . 
							"	<div class=\"card_lb_logo text-center mt-1\">\n" . 
							"		<i class=\"fa fa-tasks fa_icon card_lb_logo_size text-light\"></i>\n" . 
							"	</div>\n" . 
							"</div>\n";

}


if($_SESSION["admin"]["roles"]["func"] == 1){

	$row_year = mysqli_fetch_array(mysqli_query($conn, "SELECT 		`statistic_year`.`id` AS id, 
																	`statistic_year`.`number` AS number, 
																	`statistic_year`.`month` AS month, 
	
																	(SELECT COUNT(*) FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`reg_date`>=UNIX_TIMESTAMP(CONCAT('" . $year_from . "-', '" . $month_from . "-" . $day_from . " 00:00:00')) AND `order_orders`.`reg_date`<=UNIX_TIMESTAMP(CONCAT('" . $year_to . "-', '" . $month_to . "-" . ($day_to) . "', ' 23:59:59'))) AS all_orders, 
	
																	(SELECT COUNT(*) FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`reg_date`>=UNIX_TIMESTAMP(CONCAT('" . $year_from . "-', '" . $month_from . "-" . $day_from . " 00:00:00')) AND `order_orders`.`reg_date`<=UNIX_TIMESTAMP(CONCAT('" . $year_to . "-', '" . $month_to . "-" . ($day_to) . "', ' 23:59:59')) AND (`order_orders`.`mode`='0' OR `order_orders`.`mode`='1') " . $and_0 . ") AS orders_by_interesteds, 
	
																	(SELECT COUNT(*) FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`reg_date`>=UNIX_TIMESTAMP(CONCAT('" . $year_from . "-', '" . $month_from . "-" . $day_from . " 00:00:00')) AND `order_orders`.`reg_date`<=UNIX_TIMESTAMP(CONCAT('" . $year_to . "-', '" . $month_to . "-" . ($day_to) . "', ' 23:59:59')) AND `order_orders`.`mode`='2') AS interesteds, 
	
																	(SELECT COUNT(*) FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`reg_date`>=UNIX_TIMESTAMP(CONCAT('" . $year_from . "-', '" . $month_from . "-" . $day_from . " 00:00:00')) AND `order_orders`.`reg_date`<=UNIX_TIMESTAMP(CONCAT('" . $year_to . "-', '" . $month_to . "-" . ($day_to) . "', ' 23:59:59')) AND `order_orders`.`mode`='3' " . $and_0 . ") AS interesteds_archiv 
	
														FROM 		`statistic_year` 
														WHERE 		`statistic_year`.`id`='1'"), MYSQLI_ASSOC);

	$html_status_boxes =	"<div class=\"card_lb_success bg-white text-left shadow\">\n" . 
							"	<div class=\"card_lb_content\">\n" . 
							"		<span class=\"card_lb_title text-success\">Konvertierte Aufträge</span><span class=\"card_lb_percent\">" . ($row_year['orders_by_interesteds'] > 0 ? intval(100 / $row_year['all_orders'] * $row_year['orders_by_interesteds']) : 0) . "%</span><br />\n" . 
							"		<span class=\"card_lb_value\">" . $row_year['orders_by_interesteds'] . " von " . $row_year['all_orders'] . "</span>\n" . 
							"	</div>\n" . 
							"	<div class=\"card_lb_logo text-center mt-1\">\n" . 
							"		<i class=\"fa fa-cart-arrow-down fa_icon card_lb_logo_size text-light\"></i>\n" . 
							"	</div>\n" . 
							"</div>\n" . 
							"<div class=\"card_lb_warning bg-white text-left shadow\">\n" . 
							"	<div class=\"card_lb_content\">\n" . 
							"		<span class=\"card_lb_title text-warning\">Offene Interessenten</span><span class=\"card_lb_percent\">" . ($row_year['interesteds'] > 0 ? intval(100 / $row_year['all_orders'] * $row_year['interesteds']) : 0) . "%</span><br />\n" . 
							"		<span class=\"card_lb_value\">" . $row_year['interesteds'] . " von " . $row_year['all_orders'] . "</span>\n" . 
							"	</div>\n" . 
							"	<div class=\"card_lb_logo text-center mt-1\">\n" . 
							"		<i class=\"fa fa-phone fa_icon card_lb_logo_size text-light\"></i>\n" . 
							"	</div>\n" . 
							"</div>\n" . 
							"<div class=\"card_lb_danger bg-white text-left shadow\">\n" . 
							"	<div class=\"card_lb_content\">\n" . 
							"		<span class=\"card_lb_title text-danger\">Verlorene Interessenten</span><span class=\"card_lb_percent\">" . ($row_year['interesteds_archiv'] > 0 ? intval(100 / $row_year['all_orders'] * $row_year['interesteds_archiv']) : 0) . "%</span><br />\n" . 
							"		<span class=\"card_lb_value\">" . $row_year['interesteds_archiv'] . " von " . $row_year['all_orders'] . "</span>\n" . 
							"	</div>\n" . 
							"	<div class=\"card_lb_logo text-center mt-1\">\n" . 
							"		<i class=\"fa fa-user fa_icon card_lb_logo_size text-light\"></i>\n" . 
							"	</div>\n" . 
							"</div>\n" . 
							"<div class=\"card_lb_info bg-white text-left shadow\">\n" . 
							"	<div class=\"card_lb_content\">\n" . 
							"		<span class=\"card_lb_title text-info\">TASKS</span><span class=\"card_lb_percent\">&nbsp;</span><br />\n" . 
							"		<div class=\"card_lb_value_div\"><div class=\"card_lb_value_content\"><span class=\"card_lb_value\">" . number_format($max_orders_target > 0 ? 100 / $max_orders_target * $row_year['orders_by_interesteds'] : 0, 0, ',', '') . "%</span></div><div class=\"card_lb_progress\"><div class=\"card_lb_progress_bar\" style=\"width: " . number_format($max_orders_target > 0 ? 100 / $max_orders_target * $row_year['orders_by_interesteds'] : 0, 0, ',', '') . "%\"></div></div></div>\n" . 
							"	</div>\n" . 
							"	<div class=\"card_lb_logo text-center mt-1\">\n" . 
							"		<i class=\"fa fa-tasks fa_icon card_lb_logo_size text-light\"></i>\n" . 
							"	</div>\n" . 
							"</div>\n";

}

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