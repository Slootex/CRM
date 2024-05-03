<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

if($_SESSION["user"]["id"] < 1){
	header("Location: " . $systemdata['unuser_index']);
	exit();
}

include('includes/class_page_number.php');

$company_id = 1;

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'"), MYSQLI_ASSOC);

$row_admin = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `admin`.`id`='" . intval($maindata['admin_id']) . "'"), MYSQLI_ASSOC);

$tab = "";
$link = "auftrag-archiv";

if(isset($_POST["extra_search"])){$_SESSION["user_orders"]["extra_search"] = strip_tags($_POST["extra_search"]);}
if(isset($_POST["rows"])){$_SESSION["user_orders"]["rows"] = intval($_POST["rows"]);}
if(isset($_POST["sorting_field"])){$_SESSION["user_orders"]["sorting_field"] = intval($_POST["sorting_field"]);}
if(isset($_POST["sorting_direction"])){$_SESSION["user_orders"]["sorting_direction"] = intval($_POST["sorting_direction"]);}
if(isset($_POST["keyword"])){$_SESSION["user_orders"]["keyword"] = str_replace(" ", "", strip_tags($_POST["keyword"]));}

$sorting = array();
$sorting[] = array(
	"name" => "Status", 
	"value" => "`status_name`"
);
$sorting[] = array(
	"name" => "Aktualisierungsdatum", 
	"value" => "CAST(`order_orders`.`upd_date` AS UNSIGNED)"
);
$sorting[] = array(
	"name" => "Aktualisierungsdatum", 
	"value" => "CAST(`order_orders`.`upd_date` AS UNSIGNED)"
);
$sorting[] = array(
	"name" => "Erstelldatum", 
	"value" => "CAST(`order_orders`.`reg_date` AS UNSIGNED)"
);
$sorting[] = array(
	"name" => "Auftragsnummer", 
	"value" => "`order_orders`.`order_number`"
);

$sorting_field_name = isset($_SESSION["user_orders"]["sorting_field"]) ? $sorting[$_SESSION["user_orders"]["sorting_field"]]["value"] : $sorting[0]["value"];
$sorting_field_value = isset($_SESSION["user_orders"]["sorting_field"]) ? $_SESSION["user_orders"]["sorting_field"] : 0;

$sorting_field_options = "";
foreach($sorting as $k => $v){
	$sorting_field_options .= "<option value=\"" . $k . "\"" . ($sorting_field_value == $k ? " selected=\"selected\"" : "") . ">" . $v["name"] . "</option>\n";
}

$directions = array(0 => "ASC", 1 => "DESC");

$sorting_direction_name = isset($_SESSION["user_orders"]["sorting_direction"]) ? $directions[$_SESSION["user_orders"]["sorting_direction"]] : "ASC";
$sorting_direction_value = isset($_SESSION["user_orders"]["sorting_direction"]) ? $_SESSION["user_orders"]["sorting_direction"] : 0;

$amount_rows = 500;
if(!isset($param['pos'])){
	$pos = 0;
}else{
	$pos = intval($param['pos']);
}

$pageNumberlist = new pageList();

$emsg = "";

if(isset($_POST['id']) && $_POST['id'] > 0){

	$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `order_orders`.`user_id`='" . mysqli_real_escape_string($conn, intval($_SESSION['user']['id']))  . "' AND `order_orders`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

}

if(isset($_POST['delete']) && $_POST['delete'] == "entfernen"){

	$arr_files = explode("\r\n", $row_order['files']);

	for($i = 0;$i < count($arr_files);$i++){
		@unlink("uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/document/" . $arr_files[$i]);
	}

	$arr_files = explode("\r\n", $row_order['audio']);

	for($i = 0;$i < count($arr_files);$i++){
		@unlink("uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/audio/" . $arr_files[$i]);
	}

	// delete order_orders
	mysqli_query($conn, "	DELETE FROM	`order_orders` 
							WHERE 		`order_orders`.`id`='" . intval($_POST['id']) . "' 
							AND 		`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

	// delete order_orders_*
	mysqli_query($conn, "	DELETE FROM	`order_orders_statuses` 
							WHERE 		`order_orders_statuses`.`order_id`='" . intval($_POST['id']) . "' 
							AND 		`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

	mysqli_query($conn, "	DELETE FROM	`order_orders_emails` 
							WHERE 		`order_orders_emails`.`order_id`='" . intval($_POST['id']) . "' 
							AND 		`order_orders_emails`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

	mysqli_query($conn, "	DELETE FROM	`order_orders_history` 
							WHERE 		`order_orders_history`.`order_id`='" . intval($_POST['id']) . "' 
							AND 		`order_orders_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

	mysqli_query($conn, "	DELETE FROM	`order_orders_customer_messages` 
							WHERE 		`order_orders_customer_messages`.`order_id`='" . intval($_POST['id']) . "' 
							AND 		`order_orders_customer_messages`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

	mysqli_query($conn, "	DELETE FROM	`order_orders_shipments` 
							WHERE 		`order_orders_shipments`.`order_id`='" . intval($_POST['id']) . "' 
							AND 		`order_orders_shipments`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

	mysqli_query($conn, "	DELETE FROM	`order_orders_events` 
							WHERE 		`order_orders_events`.`order_id`='" . intval($_POST['id']) . "' 
							AND 		`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

	// delete interested_interesteds_*
	mysqli_query($conn, "	DELETE FROM	`interested_interesteds_statuses` 
							WHERE 		`interested_interesteds_statuses`.`interested_id`='" . intval($_POST['id']) . "' 
							AND 		`interested_interesteds_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

	mysqli_query($conn, "	DELETE FROM	`interested_interesteds_emails` 
							WHERE 		`interested_interesteds_emails`.`interested_id`='" . intval($_POST['id']) . "' 
							AND 		`interested_interesteds_emails`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

	mysqli_query($conn, "	DELETE FROM	`interested_interesteds_history` 
							WHERE 		`interested_interesteds_history`.`interested_id`='" . intval($_POST['id']) . "' 
							AND 		`interested_interesteds_history`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

	mysqli_query($conn, "	DELETE FROM	`interested_interesteds_customer_messages` 
							WHERE 		`interested_interesteds_customer_messages`.`interested_id`='" . intval($_POST['id']) . "' 
							AND 		`interested_interesteds_customer_messages`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

	mysqli_query($conn, "	DELETE FROM	`interested_interesteds_events` 
							WHERE 		`interested_interesteds_events`.`interested_id`='" . intval($_POST['id']) . "' 
							AND 		`interested_interesteds_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

	$result = mysqli_query($conn, "SELECT * FROM `order_orders_files` WHERE `order_orders_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `order_orders_files`.`order_id`='" . intval($_POST['id']) . "'");

	while($row_file = $result->fetch_array(MYSQLI_ASSOC)){
		@unlink("uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/userdata/" . $row_file['file']);
		@unlink("uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/document/" . $row_file['file']);
		@unlink("uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/audio/" . $row_file['file']);
	}

	@unlink("uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/userdata/.htaccess");
	@rmdir("uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/userdata");
	@unlink("uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/document/.htaccess");
	@rmdir("uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/document");
	@unlink("uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/audio/.htaccess");
	@rmdir("uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number'] . "/audio");
	@rmdir("uploads/company/" . intval($company_id) . "/order/" . $row_order['order_number']);

	mysqli_query($conn, "	DELETE FROM	`order_orders_files` 
							WHERE 		`order_orders_files`.`order_id`='" . intval($_POST['id']) . "' 
							AND 		`order_orders_files`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "'");

}

if(isset($_POST['move']) && $_POST['move'] == "Zu Aufträge"){

	$time = time();

	mysqli_query($conn, "	UPDATE	`order_orders` 
							SET 	`order_orders`.`mode`='0' 
							WHERE 	`order_orders`.`id`=" . mysqli_real_escape_string($conn, intval($_POST['id'])) . " 
							AND 	`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
							AND 	`order_orders`.`user_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["user"]["id"])) . "'");

	mysqli_query($conn, "	INSERT 	`order_orders_events` 
							SET 	`order_orders_events`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "', 
									`order_orders_events`.`admin_id`='" . mysqli_real_escape_string($conn, intval($maindata['admin_id'])) . "', 
									`order_orders_events`.`order_id`='" . mysqli_real_escape_string($conn, intval($_POST["id"])) . "', 
									`order_orders_events`.`type`='" . mysqli_real_escape_string($conn, 1) . "', 
									`order_orders_events`.`message`='" . mysqli_real_escape_string($conn, "Auftrag, zu Aufträge verschoben, ID [#" . intval($_POST["id"]) . "]") . "', 
									`order_orders_events`.`subject`='" . mysqli_real_escape_string($conn, "Auftrag, zu Aufträge verschoben, ID [#" . intval($_POST["id"]) . "]") . "', 
									`order_orders_events`.`body`='" . mysqli_real_escape_string($conn, "") . "', 
									`order_orders_events`.`time`='" . mysqli_real_escape_string($conn, $time) . "'");

}

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$list = "";

$where = 	isset($_SESSION["user_orders"]["keyword"]) && $_SESSION["user_orders"]["keyword"] != "" ? 
			"WHERE 	(`order_orders`.`id` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`order_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`machine` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`constructionyear` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`carid` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`mileage` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`component` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`manufacturer` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`serial` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`fromthiscar` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`reason` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`description` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`files` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`companyname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`firstname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`lastname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`street` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`streetno` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`zipcode` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`city` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`country` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`phonenumber` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`mobilnumber` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`email` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`differing_shipping_address` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`differing_companyname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`differing_firstname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`differing_lastname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`differing_street` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`differing_streetno` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`differing_zipcode` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`differing_city` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%' 
			OR		`order_orders`.`differing_country` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION["user_orders"]["keyword"]) . "%') " : 
			"";

$and = $where == "" ? "WHERE `order_orders`.`mode`=1 " : " AND `order_orders`.`mode`=1 ";
$and .= "AND `order_orders`.`user_id`='" . $_SESSION['user']['id'] . "' ";
$and .= isset($_SESSION["user_orders"]["extra_search"]) && $_SESSION["user_orders"]["extra_search"] > 0 ? "AND (SELECT 	(SELECT `statuses`.`id` AS id FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `statuses`.`id`=`order_orders_statuses`.`status_id`) AS id FROM `order_orders_statuses` WHERE `order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `order_orders_statuses`.`order_id`=`order_orders`.`id` ORDER BY CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC limit 0, 1)=" . $_SESSION["user_orders"]["extra_search"] : "";

$query = 	"	SELECT 		`order_orders`.`id` AS id, 
							`order_orders`.`order_number` AS order_number, 
							`order_orders`.`companyname` AS companyname, 
							`order_orders`.`firstname` AS firstname, 
							`order_orders`.`lastname` AS lastname, 
							`order_orders`.`upd_date` AS time, 

							(SELECT `admin`.`name` AS name FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `admin`.`id`=`order_orders`.`admin_id`) AS admin_name, 

							(SELECT 	(SELECT `statuses`.`name` AS name FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `statuses`.`id`=`order_orders_statuses`.`status_id`) AS name 
								FROM 	`order_orders_statuses` 
								WHERE 	`order_orders_statuses`.`order_id`=`order_orders`.`id` 
								AND 	`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
								ORDER BY CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_name, 

							(SELECT 	(SELECT `statuses`.`color` AS color FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `statuses`.`id`=`order_orders_statuses`.`status_id`) AS color 
								FROM 	`order_orders_statuses` 
								WHERE 	`order_orders_statuses`.`order_id`=`order_orders`.`id` 
								AND 	`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
								ORDER BY CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_color, 

							(SELECT 	(SELECT `statuses`.`extra_search` AS extra_search FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `statuses`.`id`=`order_orders_statuses`.`status_id`) AS extra_search 
								FROM 	`order_orders_statuses` 
								WHERE 	`order_orders_statuses`.`order_id`=`order_orders`.`id` 
								AND 	`order_orders_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
								ORDER BY CAST(`order_orders_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_extra_search, 

							`order_orders`.`admin_id` AS admin_id 
							
				FROM 		`order_orders` 
				" . $where . $and . " 
				AND 		`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' 
				ORDER BY 	" . $sorting_field_name . " " . $sorting_direction_name;

$result = mysqli_query($conn, $query);

$rows = $result->num_rows;

$pageNumberlist->setParam(	array(	"page" 		=> "Seite", 
									"of" 		=> "von", 
									"start" 	=> "|&lt;&lt;", 
									"next" 		=> "Weiter", 
									"back" 		=> "Zur&uuml;ck", 
									"end" 		=> "&gt;&gt;|", 
									"seperator" => "| "), 
									$rows, 
									$pos, 
									$amount_rows, 
									"/pos", 
									$page['url'], 
									$getParam="", 
									10, 
									1);

$query .= " limit " . $pos . ", " . $amount_rows;

$result = mysqli_query($conn, $query);

if($rows > 0){

	while($row_item = $result->fetch_array(MYSQLI_ASSOC)){

		$list .= 	"<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
					"	<tr" . (isset($_POST['id']) && $_POST['id'] == $row_item['id'] ? " class=\"bg-primary text-white\"" : "") . ">\n" . 
					"		<td scope=\"row\">\n" . 
					"			<small>" . $row_item['order_number'] . "</small>\n" . 
					"		</td>\n" . 
					"		<td>\n" . 
					"			<small>" . date("d.m.Y", $row_item['time']) . "</small> <small class=\"text-muted\">" . date("(H:i)", $row_item['time']) . "</small>\n" . 
					"		</td>\n" . 
					"		<td>\n" . 
					"			<small>" . $row_item['admin_name'] . "</small>\n" . 
					"		</td>\n" . 
					"		<td align=\"center\">\n" . 
					"			<span class=\"badge badge-pill\" style=\"background-color: " . $row_item['status_color'] . "\">" . $row_item['status_name'] . "</span>\n" . 
					"		</td>\n" . 
					"		<td>\n" . 
					"			<small>" . ($row_item['companyname'] != "" ? $row_item['companyname'] . ", " : "") . $row_item['firstname'] . " " . $row_item['lastname'] . "</small>\n" . 
					"		</td>\n" . 
					"		<td align=\"center\">\n" . 
					"			<input type=\"hidden\" name=\"id\" value=\"" . $row_item['id'] . "\" />\n" . 
					"		</td>\n" . 
					"	</tr>\n" . 
					"</form>\n";

	}

}else{

	$list = isset($_POST['search']) && $_POST['search'] == "suchen" ? "<script>alert('Es wurden keine mit Ihrer Suchanfrage - " . $_SESSION["user_orders"]["keyword"] . " - übereinstimmende Aufträge gefunden.')</script>\n" : "";

}

$result_statuses = mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($company_id)) . "' AND `statuses`.`type`=1 AND `statuses`.`extra_search`=1 ORDER BY CAST(`statuses`.`id` AS UNSIGNED) ASC");

$extra_search_options = "						<option value=\"0\"" . (isset($_SESSION['user_orders']['extra_search']) && $_SESSION['user_orders']['extra_search'] == 0 ? " selected=\"selected\"" : "") . ">Alle Vorgänge</option>\n";

while($row = $result_statuses->fetch_array(MYSQLI_ASSOC)){
	$extra_search_options .= "						<option value=\"" . $row['id'] . "\"" . (isset($_SESSION['user_orders']['extra_search']) && $_SESSION['user_orders']['extra_search'] == $row['id'] ? " selected=\"selected\"" : "") . ">" . $row['name'] . "</option>\n";
}

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">\n" . 
		"		<h3>Archiv</h3>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<hr />\n" . 
		"<div class=\"row\">\n" . 
		"	<div class=\"col-sm-7\">\n" . 
		"		<ul class=\"nav nav-pills\">\n" . 
		"			<li class=\"nav-item\"><a href=\"/kunden/auftraege\" class=\"nav-link\">Aufträge</a></li>\n" . 
		"			<li class=\"nav-item\"><a href=\"/kunden/auftraege-archiv\" class=\"nav-link active\">Archiv</a></li>\n" . 
		"			<li class=\"nav-item\"><a href=\"/kunden/auftraege/neuer-auftrag\" class=\"nav-link\">Neuer Auftrag</a></li>\n" . 
		"		</ul>\n" . 
		"	</div>\n" . 
		"	<div class=\"col-sm-5 text-right\">\n" . 
		"		<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"			<div class=\"form-group row mb-0\">\n" . 
		"				<div class=\"col-sm-12\">\n" . 
		"					<div class=\"btn-group\">\n" . 
		"						<input type=\"text\" id=\"keyword\" name=\"keyword\" value=\"" . (isset($_SESSION['user_orders']['keyword']) && $_SESSION['user_orders']['keyword'] != "" ? $_SESSION['user_orders']['keyword'] : "") . "\" placeholder=\"Suchbegriff / Barcode\" aria-label=\"Suchbegriff / Barcode\" class=\"form-control bg-" . $row_admin["bgcolor_select"] . " text-" . $row_admin["color_select"] . " border border-" . $row_admin["border_select"] . "\" style=\"border-radius: .25rem 0 0 .25rem\" />\n" . 
		"						<button type=\"submit\" name=\"search\" value=\"suchen\" class=\"btn btn-primary\"><i class=\"fa fa-search\" aria-hidden=\"true\"></i></button>\n" . 
		"						<button type=\"button\" class=\"btn btn-secondary dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" onclick=\"$('.my-dropdown-menu').slideToggle(0)\"></button>\n" . 
		"						<div class=\"my-dropdown-menu bg-white rounded-bottom border border-primary p-3\" style=\"position: absolute;top: 40px;right: 0px;display: none;box-shadow: 0 0 4px #000;z-Index: 1000\">\n" . 
		"							<h6 class=\"text-left\">Einträge&nbsp;pro&nbsp;Seite</h6>\n" . 
		"							<select id=\"rows\" name=\"rows\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 
		"								<option value=\"10\"" . ($amount_rows == 10 ? " selected=\"selected\"" : "") . ">10</option>\n" . 
		"								<option value=\"20\"" . ($amount_rows == 20 ? " selected=\"selected\"" : "") . ">20</option>\n" . 
		"								<option value=\"40\"" . ($amount_rows == 40 ? " selected=\"selected\"" : "") . ">40</option>\n" . 
		"								<option value=\"50\"" . ($amount_rows == 50 ? " selected=\"selected\"" : "") . ">50</option>\n" . 
		"								<option value=\"60\"" . ($amount_rows == 60 ? " selected=\"selected\"" : "") . ">60</option>\n" . 
		"								<option value=\"80\"" . ($amount_rows == 80 ? " selected=\"selected\"" : "") . ">80</option>\n" . 
		"								<option value=\"100\"" . ($amount_rows == 100 ? " selected=\"selected\"" : "") . ">100</option>\n" . 
		"								<option value=\"200\"" . ($amount_rows == 200 ? " selected=\"selected\"" : "") . ">200</option>\n" . 
		"								<option value=\"400\"" . ($amount_rows == 400 ? " selected=\"selected\"" : "") . ">400</option>\n" . 
		"								<option value=\"500\"" . ($amount_rows == 500 ? " selected=\"selected\"" : "") . ">500</option>\n" . 
		"							</select>\n" . 
		"							<h6 class=\"text-left mt-2\">Sortierfeld</h6>\n" . 
		"							<select id=\"sorting_field\" name=\"sorting_field\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 

		$sorting_field_options . 

		"							</select>\n" . 
		"							<h6 class=\"text-left mt-2\">Sortierrichtung</h6>\n" . 
		"							<select id=\"sorting_direction\" name=\"sorting_direction\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 
		"								<option value=\"0\"" . ($sorting_direction_value == 0 ? " selected=\"selected\"" : "") . ">Aufsteigend</option>\n" . 
		"								<option value=\"1\"" . ($sorting_direction_value == 1 ? " selected=\"selected\"" : "") . ">Absteigend</option>\n" . 
		"							</select>\n" . 
		"							<hr />\n" . 
		"							<select id=\"extra_search\" name=\"extra_search\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 

		$extra_search_options . 

		"							</select>\n" . 
		"						</div>\n" . 
		"					</div>\n" . 
		"				</div>\n" . 
		"			</div>\n" . 
		"		</form>\n" . 
		"	</div>\n" . 
		"</div>\n";

if(!isset($_POST['ever'])){

	$html .= 	"<hr />\n" . 

				$pageNumberlist->getInfo() . 

				"<br />\n" . 

				$pageNumberlist->getNavi() . 

				"<div class=\"table-responsive\">\n" . 
				"	<table class=\"table table-" . $row_admin["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
				"		<thead><tr class=\"bg-" . $row_admin["bgcolor_table_head"] . " text-" . $row_admin["color_table_head"] . "\">\n" . 
				"			<th width=\"110\" scope=\"col\">\n" . 
				"				<strong>Auftrags Nr.</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"130\" scope=\"col\">\n" . 
				"				<strong>Letzter Status</strong>\n" . 
				"			</th>\n" . 
				"			<th scope=\"col\">\n" . 
				"				<strong>Mitarbeiter</strong>\n" . 
				"			</th>\n" . 
				"			<th scope=\"col\">\n" . 
				"				<strong>Status</strong>\n" . 
				"			</th>\n" . 
				"			<th scope=\"col\">\n" . 
				"				<strong>Kunde</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"220\" align=\"center\" scope=\"col\" class=\"text-center\">\n" . 
				"				<strong>Aktion</strong>\n" . 
				"			</th>\n" . 
				"		</tr></thead>\n" . 

				$list . 

				"	</table>\n" . 
				"</div>\n" . 
				"<br />\n" . 

				$pageNumberlist->getNavi();

}

?>