<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "interested_archive";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_condition.php");

include("includes/class_navigation.php");

include('includes/class_page_number.php');

include("includes/get_ups_status.php");

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$time = time();

$parameter = array();

$parameter['tab'] = "edit";
$parameter['link'] = "interessenten-archiv";

$order_session = "interesteds";
$order_action = "/crm/interessenten-archiv";
$order_table = "interested_interesteds";
$order_id_field = "interested_id";
$order_mode = 2;
$order_archiv_mode = 3;
$order_hash = "order_hash";
$order_templates_type = 4;
$order_right = "interested_archive";
$order_name = "Archiv-Interessent";

$tabs = array();

$show_autocomplete_script = 0;

$countryToId = "";

if(isset($_POST["extra_search"])){$_SESSION[$order_session]["extra_search"] = strip_tags($_POST["extra_search"]);}
if(isset($_POST["order_extra_search"])){$_SESSION[$order_session]["order_extra_search"] = strip_tags($_POST["order_extra_search"]);}
if(isset($_POST["user_extra_search"])){$_SESSION[$order_session]["user_extra_search"] = strip_tags($_POST["user_extra_search"]);}
if(isset($_POST["rows"])){$_SESSION[$order_session]["rows"] = intval($_POST["rows"]);}
if(isset($_POST["sorting_field"])){$_SESSION[$order_session]["sorting_field"] = intval($_POST["sorting_field"]);}
if(isset($_POST["sorting_direction"])){$_SESSION[$order_session]["sorting_direction"] = intval($_POST["sorting_direction"]);}
if(isset($_POST["keyword"])){$_SESSION[$order_session]["keyword"] = str_replace(" ", "", strip_tags($_POST["keyword"]));}
if(isset($_POST["user_keyword"])){$_SESSION[$order_session]["user_keyword"] = str_replace(" ", "", strip_tags($_POST["user_keyword"]));}
if(isset($_POST["email_template"])){$_SESSION["email_template"]["id"] = strip_tags($_POST["email_template"]);}

if(isset($_POST['set_search_defaults']) && $_POST['set_search_defaults'] == "OK"){
	unset($_SESSION[$order_session]);
}

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
	"name" => "Erstelldatum", 
	"value" => "CAST(`order_orders`.`reg_date` AS UNSIGNED)"
);
$sorting[] = array(
	"name" => "Auftragsnummer", 
	"value" => "`order_orders`.`order_number`"
);
$sorting[] = array(
	"name" => "Rückruf", 
	"value" => "IF (`order_orders`.`recall_date` <> '', 0, 1) ASC, CAST(`order_orders`.`recall_date` AS UNSIGNED)"
);

$sorting_field_name = isset($_SESSION[$order_session]["sorting_field"]) ? $sorting[$_SESSION[$order_session]["sorting_field"]]["value"] : $sorting[2]["value"];
$sorting_field_value = isset($_SESSION[$order_session]["sorting_field"]) ? $_SESSION[$order_session]["sorting_field"] : 2;

$sorting_field_options = "";
foreach($sorting as $k => $v){
	$sorting_field_options .= "<option value=\"" . $k . "\"" . ($sorting_field_value == $k ? " selected=\"selected\"" : "") . ">" . $v["name"] . "</option>\n";
}

$directions = array(0 => "ASC", 1 => "DESC");

$sorting_direction_name = isset($_SESSION[$order_session]["sorting_direction"]) ? $directions[$_SESSION[$order_session]["sorting_direction"]] : "DESC";
$sorting_direction_value = isset($_SESSION[$order_session]["sorting_direction"]) ? $_SESSION[$order_session]["sorting_direction"] : 1;

// ----- Global Search -----

$global_sorting = array();
$global_sorting[] = array(
	"name" => "Bereich", 
	"value" => "CAST(`order_orders`.`mode` AS UNSIGNED)"
);
$global_sorting[] = array(
	"name" => "Aktualisierungsdatum", 
	"value" => "CAST(`order_orders`.`upd_date` AS UNSIGNED)"
);
$global_sorting[] = array(
	"name" => "Erstelldatum", 
	"value" => "CAST(`order_orders`.`reg_date` AS UNSIGNED)"
);
$global_sorting[] = array(
	"name" => "Auftragsnummer", 
	"value" => "`order_orders`.`order_number`"
);

$global_sorting_field_name = isset($_SESSION["global"]["sorting_field"]) ? $global_sorting[$_SESSION["global"]["sorting_field"]]["value"] : $global_sorting[2]["value"];
$global_sorting_field_value = isset($_SESSION["global"]["sorting_field"]) ? $_SESSION["global"]["sorting_field"] : 2;

$global_sorting_field_options = "";
foreach($global_sorting as $k => $v){
	$global_sorting_field_options .= "<option value=\"" . $k . "\"" . ($global_sorting_field_value == $k ? " selected=\"selected\"" : "") . ">" . $v["name"] . "</option>\n";
}

$global_sorting_direction_name = isset($_SESSION["global"]["sorting_direction"]) ? $directions[$_SESSION["global"]["sorting_direction"]] : "DESC";
$global_sorting_direction_value = isset($_SESSION["global"]["sorting_direction"]) ? $_SESSION["global"]["sorting_direction"] : 1;

$global_amount_rows = isset($_SESSION["global"]["rows"]) && $_SESSION["global"]["rows"] > 0 ? $_SESSION["global"]["rows"] : 200;

if(isset($param['add']) && $param['add'] == "add"){
	$_POST['add'] = "hinzufügen";
}

$amount_rows = isset($_SESSION[$order_session]["rows"]) && $_SESSION[$order_session]["rows"] > 0 ? $_SESSION[$order_session]["rows"] : 500;
if(!isset($param['pos'])){
	$pos = 0;
}else{
	$pos = intval($param['pos']);
}

$pageNumberlist = new pageList();

$user_amount_rows = 10;
if(!isset($param['userpage'])){
	$userpage = 0;
}else{
	$userpage = intval($param['userpage']);
}

$userNumberlist = new pageList();

$emsg = "";
$emsg_shipment = "";
$emsg_files = "";
$emsg_audio = "";
$emsg_shipping_cancel = "";

$inp_companyname = "";
$inp_firstname = "";
$inp_lastname = "";
$inp_street = "";
$inp_streetno = "";
$inp_zipcode = "";
$inp_city = "";
$inp_country = "";
$inp_phonenumber = "";
$inp_mobilnumber = "";
$inp_email = "";
$inp_differing_shipping_address = "";
$inp_differing_companyname = "";
$inp_differing_firstname = "";
$inp_differing_lastname = "";
$inp_differing_street = "";
$inp_differing_streetno = "";
$inp_differing_zipcode = "";
$inp_differing_city = "";
$inp_differing_country = "";

$inp_from_companyname = "";
$inp_from_firstname = "";
$inp_from_lastname = "";
$inp_from_street = "";
$inp_from_streetno = "";
$inp_from_zipcode = "";
$inp_from_city = "";
$inp_from_country = "";
$inp_from_email = "";
$inp_from_phonenumber = "";
$inp_from_mobilnumber = "";

$inp_to_companyname = "";
$inp_to_firstname = "";
$inp_to_lastname = "";
$inp_to_street = "";
$inp_to_streetno = "";
$inp_to_zipcode = "";
$inp_to_city = "";
$inp_to_country = "";
$inp_to_email = "";
$inp_to_phonenumber = "";
$inp_to_mobilnumber = "";

$inp_carriers_service = "";

$inp_pricemwst = "";
$inp_radio_shipping = "";
$inp_radio_payment = "";
$inp_amount = "";
$inp_radio_saturday = "";
$inp_mail_with_pdf = "";
$inp_admin_mail = "";

$inp_package_template = "";

$inp_user_ip = "";

$inp_machine = "";
$inp_model = "";
$inp_constructionyear = "";
$inp_carid = "";
$inp_kw = "";
$inp_mileage = "";
$inp_mechanism = "";
$inp_fuel = "";

$inp_component = "";
$inp_manufacturer = "";
$inp_serial = "";
$inp_additional_numbers = "";
$inp_fromthiscar = "";
$inp_open_by_user = "";
$inp_reason = "";
$inp_description = "";
$inp_note_to_the_technician = "";

$inp_ref_number = "";
$inp_customer_number = "";
$inp_call_date = "";
// ----- New Email
$inp_new_email_name = "";
$inp_new_email_email = "";
$inp_new_email_subject = "";
$inp_new_email_body = "";
// ----- Customer Message
$inp_message = "";
$inp_customer = "";

$inp_intern_time = "";
$inp_intern_acceptance_agreement_1 = 0;
$inp_intern_verbal_contract = "";
$inp_intern_conversation_partner = "";
$inp_intern_shipping_after_paying = "";
$inp_intern_price_total = "";
$inp_intern_radio_paying = "";
$inp_intern_release_price = "";
$inp_intern_redemption_instruction = "";
$inp_intern_exchange_instruction = "";
$inp_intern_birthday = "";
$inp_intern_acceptance_agreement_2 = "";
$inp_intern_description = "";
$inp_intern_tech_info = "";
$inp_intern_note = "";
$inp_intern_allocation = "";
$inp_intern_info = "";
$inp_intern_compare_text = "";
$inp_intern_compare_price = "";

$inp_recall_date = "";

$companyname = "";
$firstname = "";
$lastname = "";
$street = "";
$streetno = "";
$zipcode = "";
$city = "";
$country = 1;
$phonenumber = "";
$mobilnumber = "";
$email = "";
$differing_shipping_address = 0;
$differing_companyname = "";
$differing_firstname = "";
$differing_lastname = "";
$differing_street = "";
$differing_streetno = "";
$differing_zipcode = "";
$differing_city = "";
$differing_country = 0;

$from_companyname = "";
$from_firstname = "";
$from_lastname = "";
$from_street = "";
$from_streetno = "";
$from_zipcode = "";
$from_city = "";
$from_country = 0;
$from_email = "";
$from_mobilnumber = "";
$from_phonenumber = "";

$to_companyname = "";
$to_firstname = "";
$to_lastname = "";
$to_street = "";
$to_streetno = "";
$to_zipcode = "";
$to_city = "";
$to_country = 0;
$to_email = "";
$to_mobilnumber = "";
$to_phonenumber = "";


$carriers_service = "11";

$pricemwst = 0.00;
$radio_shipping = 1;
$radio_payment = 0;
$amount = 0.00;
$radio_saturday = 0;
$mail_with_pdf = 0;
$admin_mail = 0;

$package_template = 1;

$user_ip = "";

$machine = "";
$model = "";
$constructionyear = "";
$carid = "";
$kw = "";
$mileage = 0;
$mechanism = 0;
$fuel = 0;

$component = 0;
$manufacturer = "";
$serial = "";
$additional_numbers = "";
$fromthiscar = 1;
$open_by_user = 0;
$reason = "";
$description = "";
$note_to_the_technician = "";

$ref_number = "";
$customer_number = "";
$call_date = 0;

$intern_time = 0;
$intern_acceptance_agreement_1 = 0;
$intern_verbal_contract = 0;
$intern_conversation_partner = "";
$intern_shipping_after_paying = 0;
$intern_price_total = 0.00;
$intern_radio_paying = 0;
$intern_release_price = 0;
$intern_redemption_instruction = 0;
$intern_exchange_instruction = 0;
$intern_birthday = 0;
$intern_acceptance_agreement_2 = 0;
$intern_description = "";
$intern_tech_info = "";
$intern_note = "";
$intern_allocation = 0;
$intern_info = "";
$intern_compare_text = "";
$intern_compare_price = 0.00;

$recall_date = 0;

// ----- New Email
$new_email_name = "";
$new_email_email = "";
$new_email_subject = "";
$new_email_body = "";
// ----- Customer Message
$message = "";
$customer = "";
// ----- Shipping Quotes
$shipping_quotes_shippingcost = 0.00;

$length = 0;
$width = 0;
$height = 0;
$weight = 0.0;

$html_new_email = "";
$html_new_status = "";
$html_new_shipping = "";
$html_new_shipping_options = "";
$html_new_shipping_result = "";
$html_add_user = "";

$document_open = "";

if(isset($param['edit']) && strip_tags($param['edit']) == "bearbeiten" && isset($param['id']) && intval($param['id']) > 0){

	$parameter['tab'] = "edit";
	$parameter['link'] = "interessenten-archiv";

	$_POST['id'] = intval($param['id']);
	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['multi_status']) && $_POST['multi_status'] == "durchführen" && isset($_POST['status']) && intval($_POST['status']) > 0){

	include("includes/condition/admin_order_multi_status.php");

}

if(isset($_POST['device_new']) && $_POST['device_new'] == "neu"){

	$parameter['tab'] = "order_data";
	$parameter['link'] = "interessenten-archiv";

	include("includes/condition/admin_order_new_device_neu.php");

}

if(isset($_POST['id']) && $_POST['id'] > 0){

	$row_order = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `order_orders` WHERE `order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders`.`id`='" . intval($_POST['id']) . "'"), MYSQLI_ASSOC);

}

$result_tabs = mysqli_query($conn, "SELECT 		* 
									FROM 		`rights` 
									WHERE 		`rights`.`parent_id`=(SELECT `rights`.`id` AS id FROM `rights` WHERE `rights`.`authorization`='" . $order_right . "') 
									ORDER BY 	CAST(`rights`.`pos` AS UNSIGNED) ASC");

while($row_tab = $result_tabs->fetch_array(MYSQLI_ASSOC)){

	if(isset($_SESSION["admin"]["roles"][$row_tab['authorization']]) && $_SESSION["admin"]["roles"][$row_tab['authorization']] == 1){

		$tabs[] = $row_tab;

		$processings = explode("\r\n", $row_tab['processings']);

		for($i = 0;$i < count($processings);$i++){

		$condition = new condition();

		if($condition->parse($processings[$i]) == true){

			foreach($condition->parameter() as $key => $val){

				$parameter[$key] = $val;

			}

			$option = $condition->option();

			if(isset($option['radio_payment'])){

				$radio_payment = $row_order['radio_payment'];

			}

			include("includes/condition/" . $condition->phpFile());

		}

	}

	}

}

if(isset($_POST['move']) && $_POST['move'] == "Zu Interessenten"){

	$parameter['archive_to_interested_status'] = "archive_to_interested_status";

	include("includes/condition/admin_order_move_zu_interessenten.php");

}

if(isset($_POST['move_order']) && $_POST['move_order'] == "Zu Aufträge"){

	$parameter['link'] = "neue-interessenten";

	$interested_to_order_status = "interested_to_order_status";

	$order_table = "order_orders";

	$order_id_field = "order_id";

	include("includes/condition/admin_interested_move_order_zu_auftraege.php");

}

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$list = "";

$where = 	isset($_SESSION[$order_session]["keyword"]) && $_SESSION[$order_session]["keyword"] != "" ? 
			"WHERE 	(`order_orders`.`id` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`order_orders`.`order_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`order_orders`.`ref_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`order_orders`.`customer_number` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`order_orders`.`call_date` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`order_orders`.`machine` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`order_orders`.`model` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`order_orders`.`constructionyear` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`order_orders`.`carid` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`order_orders`.`mileage` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`order_orders`.`reason` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`order_orders`.`description` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`order_orders`.`companyname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`order_orders`.`firstname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`order_orders`.`lastname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`order_orders`.`street` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`order_orders`.`streetno` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`order_orders`.`zipcode` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`order_orders`.`city` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`order_orders`.`country` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`order_orders`.`phonenumber` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`order_orders`.`mobilnumber` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`order_orders`.`email` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`order_orders`.`differing_shipping_address` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`order_orders`.`differing_companyname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`order_orders`.`differing_firstname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`order_orders`.`differing_lastname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`order_orders`.`differing_street` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`order_orders`.`differing_streetno` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`order_orders`.`differing_zipcode` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`order_orders`.`differing_city` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`order_orders`.`differing_country` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%') " : 
			"";

$and = $where == "" ? "WHERE `order_orders`.`mode`=3 " : " AND `order_orders`.`mode`=3 ";
$and .= isset($_SESSION[$order_session]["extra_search"]) && $_SESSION[$order_session]["extra_search"] > 0 ? "AND (SELECT `statuses`.`id` AS id FROM `" . $order_table . "_statuses` LEFT JOIN `statuses` ON `statuses`.`id`=`" . $order_table . "_statuses`.`status_id` WHERE `" . $order_table . "_statuses`.`" . $order_id_field . "`=`order_orders`.`id` AND `" . $order_table . "_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`public`='1' ORDER BY CAST(`" . $order_table . "_statuses`.`time` AS UNSIGNED) DESC limit 0, 1)=" . $_SESSION[$order_session]["extra_search"] : "";

switch($_SESSION["admin"]["roles"]["searchresult_rights"]){

	case 0:
		$and .= "AND `order_orders`.`admin_id`=" . $_SESSION["admin"]["id"] . " ";
		break;

	case 1:
		$and .= "AND (`order_orders`.`admin_id`=" . $_SESSION["admin"]["id"] . " OR `order_orders`.`admin_id`=" . $maindata['admin_id'] . ") ";
		break;
	
}

$query = 	"	SELECT 		`order_orders`.`id` AS id, 
							`order_orders`.`creator_id` AS creator_id, 
							`order_orders`.`order_number` AS order_number, 
							`order_orders`.`status_counter` AS status_counter, 
							`order_orders`.`companyname` AS companyname, 
							`order_orders`.`firstname` AS firstname, 
							`order_orders`.`lastname` AS lastname, 
							`order_orders`.`phonenumber` AS phonenumber, 
							`order_orders`.`mobilnumber` AS mobilnumber, 
							`order_orders`.`call_date` AS call_date, 
							`order_orders`.`intern_time` AS intern_time, 
							`order_orders`.`recall_date` AS recall_date, 
							`order_orders`.`run_date` AS run_date, 
							`order_orders`.`reg_date` AS reg_date, 
							`order_orders`.`cpy_date` AS cpy_date, 
							`order_orders`.`upd_date` AS time, 

							(SELECT COUNT(*) AS a_c FROM `order_orders_audios` WHERE `order_orders_audios`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `order_orders_audios`.`order_id`=`order_orders`.`id`) AS audio_count, 

							(SELECT `admin`.`name` AS name FROM `admin` WHERE `admin`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `admin`.`id`=`order_orders`.`admin_id`) AS admin_name, 

							(SELECT 		`statuses`.`name` AS name 
								FROM 		`" . $order_table . "_statuses` 
								LEFT JOIN 	`statuses` 
								ON 			`statuses`.`id`=`" . $order_table . "_statuses`.`status_id` 
								WHERE 		`" . $order_table . "_statuses`.`" . $order_id_field . "`=`order_orders`.`id` 
								AND 		`" . $order_table . "_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								AND 		`statuses`.`public`='1' 
								ORDER BY 	CAST(`" . $order_table . "_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_name, 

							(SELECT 		`statuses`.`color` AS color 
								FROM 		`" . $order_table . "_statuses` 
								LEFT JOIN 	`statuses` 
								ON 			`statuses`.`id`=`" . $order_table . "_statuses`.`status_id` 
								WHERE 		`" . $order_table . "_statuses`.`" . $order_id_field . "`=`order_orders`.`id` 
								AND 		`" . $order_table . "_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								AND 		`statuses`.`public`='1' 
								ORDER BY 	CAST(`" . $order_table . "_statuses`.`time` AS UNSIGNED) DESC limit 0, 1) AS status_color, 

							(SELECT 		`" . $order_table . "_statuses`.`email_reads` AS email_reads 
								FROM 		`" . $order_table . "_statuses` 
								LEFT JOIN 	`statuses` 
								ON 			`statuses`.`id`=`" . $order_table . "_statuses`.`status_id` 
								WHERE 		`" . $order_table . "_statuses`.`" . $order_id_field . "`=`order_orders`.`id` 
								AND 		`" . $order_table . "_statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								AND 		`statuses`.`public`>='0' 
								ORDER BY 	CAST(`" . $order_table . "_statuses`.`time` AS UNSIGNED) ASC limit 0, 1) AS status_email_reads, 

							(SELECT 		`" . $order_table . "_customer_messages`.`message` AS message 
								FROM 		`" . $order_table . "_customer_messages` `" . $order_table . "_customer_messages` 
								WHERE 		`" . $order_table . "_customer_messages`.`" . $order_id_field . "`=`order_orders`.`id` 
								AND 		`" . $order_table . "_customer_messages`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								ORDER BY 	CAST(`" . $order_table . "_customer_messages`.`time` AS UNSIGNED) DESC limit 0, 1) AS message, 

							`order_orders`.`admin_id` AS admin_id 
							
				FROM 		`order_orders` 
				" . $where . $and . " 
				AND 		`order_orders`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
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
									$order_action, 
									$getParam="", 
									10, 
									1);

$query .= " limit " . $pos . ", " . $amount_rows;

$result = mysqli_query($conn, $query);

if(!isset($_POST['edit']) && !isset($_POST['update']) && (!isset($_POST['id']) || (isset($_POST['id']) && intval($_POST['id']) == 0))){

	if($rows > 0){

		while($row_orders = $result->fetch_array(MYSQLI_ASSOC)){

			$date_str = "";

			$date_days = 0;

			if(intval($row_orders['call_date']) > 0){

				$date_to = $row_orders['call_date'] + ($row_orders['intern_time'] * 86400);

				if($date_to >= $time){
					$date_days = intval(($date_to - $time) / 86400);
					if($date_days == 0){
						$date_str = "0";
					}else{
						$date_str = "+" . $date_days;
					}
				}else{
					$date_days = intval(($time - $date_to) / 86400);
					if($date_days == 0){
						$date_str = "0";
					}else{
						$date_str = "-" . $date_days;
					}
				}

			}else{
				$date_str = "NAN";
			}

			$list .= 	"<form action=\"" . $order_action . "\" method=\"post\">\n" . 
						"	<tr" . (isset($_POST['id']) && $_POST['id'] == $row_orders['id'] ? " class=\"bg-primary text-white interesteds_archiv_menu\"" : " class=\"interesteds_archiv_menu\"") . " onclick=\"if(\$(this).hasClass('active')){\$(this).removeClass('active');}else{\$(this).addClass('active');}$('#order_list_" . $row_orders['id'] . "').prop('checked', !$('#order_list_" . $row_orders['id'] . "').prop('checked'))\" data-id=\"" . $row_orders['id'] . "\" data-order_number=\"" . $row_orders['order_number'] . "\">\n" . 
						"		<td scope=\"row\">\n" . 
						"			<div class=\"custom-control custom-checkbox mt-1 ml-2\">\n" . 
						"				<input type=\"checkbox\" id=\"order_list_" . $row_orders['id'] . "\" data-id=\"" . $row_orders['id'] . "\" class=\"custom-control-input order-list\" onclick=\"if(\$(this).closest('tr').hasClass('active')){\$(this).closest('tr').removeClass('active');}else{\$(this).closest('tr').addClass('active');}\" />\n" . 
						"				<label class=\"custom-control-label\" for=\"order_list_" . $row_orders['id'] . "\"></label>\n" . 
						"			</div>\n" . 
						"		</td>\n" . 
						"		<td scope=\"row\" align=\"center\">\n" . 
						"			" . $date_str . "\n" . 
						"		</td>\n" . 
						"		<td class=\"text-nowrap\">\n" . 
						"			<small>" . date("d.m.Y", $row_orders['reg_date']) . "</small> <small class=\"text-muted\">" . date("(H:i)", $row_orders['reg_date']) . "</small>\n" . 
						"		</td>\n" . 
						"		<td scope=\"row\">\n" . 
						"			" . ($row_orders['audio_count'] > 0 ? "<div style=\"width: 40px;height: 30px;font-size: 1rem\" class=\"text-primary text-center pt-1\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"" . $row_orders['audio_count'] . " Stück\" title=\"\"><i class=\"fa fa-music\"> </i></div>" : "<div style=\"width: 40px;height: 30px;font-size: 1rem\" class=\"text-primary text-center pt-1\"><i class=\"fa fa-ban\"> </i></div>") . "\n" . 
						"		</td>\n" . 
						"		<td scope=\"row\" align=\"center\">\n" . 
						"			<small>" . $row_orders['order_number'] . "</small>\n" . 
						"		</td>\n" . 
						"		<td>\n" . 
						"			<div style=\"width: 250px;white-space: nowrap;overflow-x: hidden\"><small>" . ($row_orders['companyname'] != "" ? $row_orders['companyname'] . ", " : "") . $row_orders['firstname'] . " " . $row_orders['lastname'] . "</small></div>\n" . 
						"		</td>\n" . 
						"		<td align=\"center\">\n" . 
						"			<span class=\"badge badge-pill\" style=\"background-color: " . $row_orders['status_color'] . "\">" . $row_orders['status_name'] . "<sup>" . $row_orders['status_counter'] . "</sup></span>\n" . 
						"		</td>\n" . 
						"		<td scope=\"row\" align=\"center\">\n" . 
						"			<small>" . $row_orders['status_email_reads'] . "</small>\n" . 
						"		</td>\n" . 
						"		<td class=\"text-nowrap\">\n" . 
						"			<small>" . date("d.m.Y", $row_orders['time']) . "</small> <small class=\"text-muted\">" . date("(H:i)", $row_orders['time']) . "</small>\n" . 
						"		</td>\n" . 
						"		<td" . ($row_orders['creator_id'] == $maindata['admin_id'] ? " class=\"text-danger\"" : "") . ">\n" . 
						"			<div style=\"width: 120px;white-space: nowrap;overflow-x: hidden\"><small>" . $row_orders['admin_name'] . "</small></div>\n" . 
						"		</td>\n" . 
						"		<td>\n" . 
						"			<small>" . ($row_orders['recall_date'] != "" ? date("d.m.Y - H:i", $row_orders['recall_date']) : "") . "</small>\n" . 
						"		</td>\n" . 
						"		<td>\n" . 
						"			<small>" . ($row_orders['mobilnumber'] != "" ? $row_orders['mobilnumber'] : $row_orders['phonenumber']) . "</small>\n" . 
						"		</td>\n" . 
						"		<td align=\"center\">\n" . 
						"			<div style=\"white-space: nowrap\">\n" . 
						"				<input type=\"hidden\" name=\"id\" value=\"" . $row_orders['id'] . "\" />\n" . 
						"				<button type=\"submit\" name=\"edit\" value=\"bearbeiten\" class=\"btn btn-sm btn-success\">bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>\n" . 
						"			</div>\n" . 
						"		</td>\n" . 
						"	</tr>\n" . 
						"</form>\n";

		}

	}else{

		$list = isset($_POST['search']) && $_POST['search'] == "suchen" ? "<script>alert('Es wurden keine mit deiner Suchanfrage - " . $_SESSION[$order_session]["keyword"] . " - übereinstimmende Interessenten gefunden.')</script>\n" : "";

	}

}

$result_statuses = mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses`.`type`='4' AND `statuses`.`extra_search`='1' ORDER BY CAST(`statuses`.`id` AS UNSIGNED) ASC");

$extra_search_options = "						<option value=\"0\"" . (isset($_SESSION[$order_session]['extra_search']) && $_SESSION[$order_session]['extra_search'] == 0 ? " selected=\"selected\"" : "") . ">Alle Vorgänge</option>\n";

while($row = $result_statuses->fetch_array(MYSQLI_ASSOC)){
	$extra_search_options .= "						<option value=\"" . $row['id'] . "\"" . (isset($_SESSION[$order_session]['extra_search']) && $_SESSION[$order_session]['extra_search'] == $row['id'] ? " selected=\"selected\"" : "") . ">" . $row['name'] . "</option>\n";
}

$result_statuses = mysqli_query($conn, "	SELECT 		* 
											FROM 		`statuses` 
											WHERE 		`statuses`.`type`='" . $order_templates_type . "' 
											AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
											AND 		`statuses`.`multi_status`='1' 
											ORDER BY 	CAST(`statuses`.`id` AS UNSIGNED) ASC");

$multi_search_options = "";

while($row = $result_statuses->fetch_array(MYSQLI_ASSOC)){

	$multi_search_options .= "						<option value=\"" . $row['id'] . "\">" . $row['name'] . "</option>\n";

}

$navigation = new navigation($conn, 5, ($parameter['link'] == "neue-interessenten" ? "interested_interesteds" : ($parameter['link'] == "interessenten-archiv" ? "interested_archive" : ($parameter['link'] == "neuen-interessent" ? "interested_new" : ""))));
$navigation->options['main_href_link_normal'] = "			<li class=\"nav-item\">\n				<a href=\"[href]\" class=\"nav-link\">[name]</a>\n			</li>\n";
$navigation->options['main_href_link_active'] = "			<li class=\"nav-item\">\n				<a href=\"[href]\" class=\"nav-link active\">[name]</a>\n			</li>\n";

if(!isset($_POST['add']) && !isset($_POST['edit']) && !isset($_POST['save']) && !isset($_POST['update'])){
	include("includes/codes/codes_backend_status.php");
}

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-7 col-md-7 col-sm-7 col-xs-7\">\n" . 
		"		<ul class=\"nav nav-pills\">\n" . 

		$navigation->show() . 

		"		</ul>\n" . 
		"	</div>\n" . 
		"	<div class=\"col-sm-5 text-right\">\n" . 
		"		<form action=\"/crm/globale-suche\" method=\"post\">\n" . 
		"			<div class=\"form-group row mb-1\">\n" . 
		"				<div class=\"col-sm-12\">\n" . 
		"					<div class=\"btn-group\">\n" . 
		"						<input type=\"text\" id=\"global_keyword\" name=\"global_keyword\" value=\"" . (isset($_SESSION['global_orders']['keyword']) && $_SESSION['global_orders']['keyword'] != "" ? $_SESSION['global_orders']['keyword'] : "") . "\" placeholder=\"Suchbegriff / Barcode\" aria-label=\"Suchbegriff / Barcode\" class=\"form-control bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" style=\"border-radius: .25rem 0 0 .25rem\" />\n" . 
		"						<button type=\"submit\" name=\"search\" value=\"suchen\" class=\"btn btn-primary\"><i class=\"fa fa-search\" aria-hidden=\"true\"></i></button>\n" . 
		"					</div>\n" . 
		"					<button type=\"button\" class=\"btn btn-secondary dropdown-toggle d-none\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" onclick=\"$('.global-dropdown-menu').slideToggle(0)\" onfocus=\"this.blur()\"></button>\n" . 
		"					<div class=\"global-dropdown-menu bg-white rounded-bottom border border-primary p-3\" style=\"position: absolute;top: 40px;right: 0px;display: none;box-shadow: 0 0 4px #000;z-Index: 1000\">\n" . 
		"						<h6 class=\"text-left\">Einträge&nbsp;pro&nbsp;Seite</h6>\n" . 
		"						<select id=\"global_rows\" name=\"global_rows\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 
		"							<option value=\"10\"" . ($global_amount_rows == 10 ? " selected=\"selected\"" : "") . ">10</option>\n" . 
		"							<option value=\"20\"" . ($global_amount_rows == 20 ? " selected=\"selected\"" : "") . ">20</option>\n" . 
		"							<option value=\"40\"" . ($global_amount_rows == 40 ? " selected=\"selected\"" : "") . ">40</option>\n" . 
		"							<option value=\"50\"" . ($global_amount_rows == 50 ? " selected=\"selected\"" : "") . ">50</option>\n" . 
		"							<option value=\"60\"" . ($global_amount_rows == 60 ? " selected=\"selected\"" : "") . ">60</option>\n" . 
		"							<option value=\"80\"" . ($global_amount_rows == 80 ? " selected=\"selected\"" : "") . ">80</option>\n" . 
		"							<option value=\"100\"" . ($global_amount_rows == 100 ? " selected=\"selected\"" : "") . ">100</option>\n" . 
		"							<option value=\"200\"" . ($global_amount_rows == 200 ? " selected=\"selected\"" : "") . ">200</option>\n" . 
		"							<option value=\"400\"" . ($global_amount_rows == 400 ? " selected=\"selected\"" : "") . ">400</option>\n" . 
		"							<option value=\"500\"" . ($global_amount_rows == 500 ? " selected=\"selected\"" : "") . ">500</option>\n" . 
		"						</select>\n" . 
		"						<h6 class=\"text-left mt-2\">Sortierfeld</h6>\n" . 
		"						<select id=\"global_sorting_field\" name=\"global_sorting_field\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 

		$global_sorting_field_options . 

		"						</select>\n" . 
		"						<h6 class=\"text-left mt-2\">Sortierrichtung</h6>\n" . 
		"						<select id=\"sorting_direction\" name=\"sorting_direction\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 
		"							<option value=\"0\"" . ($global_sorting_direction_value == 0 ? " selected=\"selected\"" : "") . ">Aufsteigend</option>\n" . 
		"							<option value=\"1\"" . ($global_sorting_direction_value == 1 ? " selected=\"selected\"" : "") . ">Absteigend</option>\n" . 
		"						</select>\n" . 
		"					</div>\n" . 
		"				</div>\n" . 
		"			</div>\n" . 
		"		</form>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<hr />\n" . 
		($html_status_boxes != "" && !isset($_POST['add']) && !isset($_POST['edit']) && !isset($_POST['save']) && !isset($_POST['update']) ? 
			"<div class=\"row\">\n" . 
			"	<div class=\"col-12 text-center\">\n" . 
			$html_status_boxes . 
			"	</div>\n" . 
			"</div>\n" . 
			"<hr />\n"
		: 
			""
		) . 
		"<div class=\"row\">\n" . 
		"	<div class=\"col-7\">\n" . 
		"		" . (!isset($_POST['delete']) && isset($_POST['id']) && intval($_POST['id']) > 0 ? "<h3>Interessentenarchiv-Auftragsnummer: " . $row_order['order_number'] . "</h3><p id=\"user_info\" class=\"mb-0\">" . ($row_order['companyname'] != "" ? "Firma: " . $row_order['companyname'] . ", " : "") . "Name: " . ($row_order['gender'] == 1 ? "Frau" : "Herr") . " " . $row_order['firstname'] . " " . $row_order['lastname'] . "</p>" : (isset($_POST['add']) && $_POST['add'] == "hinzufügen" ? "<h3>Neuer Interessent</h3>" : "<h3>Interessentenarchiv</h3>")) . "\n" . 
		"	</div>\n" . 
		"	<div class=\"col-lg-5 col-md-5 col-sm-5 col-xs-5 text-right\">\n" . 
		"		" . 

		(
			!isset($_POST['delete']) && isset($_POST['id']) && intval($_POST['id']) > 0 ? 
			"		<form action=\"" . $order_action . "\" method=\"post\">\n" . 
			"			<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
			"			<button type=\"submit\" name=\"move\" value=\"Zu Interessenten\" class=\"btn btn-danger\" onclick=\"return confirm('Wollen Sie den Eintrag wircklich nach Interessenten verschieben?')\">zu Interessenten <i class=\"fa fa-table\" aria-hidden=\"true\"></i></button>\n" . 
			"			<button type=\"submit\" name=\"move_order\" value=\"Zu Aufträge\" class=\"btn btn-danger\" onclick=\"return confirm('Wollen Sie den Eintrag wircklich nach Aufträge verschieben?')\">zu Aufträge <i class=\"fa fa-list\" aria-hidden=\"true\"></i></button>\n" . 
			"		</form>\n" : 

			(
				isset($_POST['add']) && $_POST['add'] == "hinzufügen" ? 
				"" : 
				"		<form id=\"order_search\" action=\"" . $order_action . "\" method=\"post\">\n" . 
				"			<div class=\"form-group row mb-1\">\n" . 
				"				<div class=\"col-sm-12\">\n" . 
				"					<input type=\"hidden\" id=\"keyword\" name=\"keyword\" value=\"" . (isset($_SESSION[$order_session]['keyword']) && $_SESSION[$order_session]['keyword'] != "" ? $_SESSION[$order_session]['keyword'] : "") . "\" placeholder=\"Suchbegriff / Barcode\" aria-label=\"Suchbegriff / Barcode\" class=\"form-control bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" style=\"border-radius: .25rem 0 0 .25rem\" />\n" . 
				"					<button type=\"submit\" name=\"search\" value=\"suchen\" class=\"btn btn-primary d-none\"><i class=\"fa fa-search\" aria-hidden=\"true\"></i></button>\n" . 
				"					<div class=\"btn-group\">\n" . 
				"						<button type=\"submit\" name=\"set_search_defaults\" value=\"OK\" class=\"btn btn-primary\">Löschen <i class=\"fa fa-eraser\" aria-hidden=\"true\"></i></button>\n" . 
				"						<button type=\"button\" class=\"btn btn-secondary dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" onclick=\"$('.my-dropdown-menu').slideToggle(0)\" onfocus=\"this.blur()\">Filter</button>\n" . 
				"					</div>\n" . 
				"					<div class=\"my-dropdown-menu bg-white rounded-bottom border border-primary p-3 mr-3\" style=\"position: absolute;top: 40px;right: 0px;margin-bottom: 30px;width: 200px;display: none;box-shadow: 0 0 4px #000;z-Index: 1000\">\n" . 
				"						<h6 class=\"text-left\">Einträge&nbsp;pro&nbsp;Seite</h6>\n" . 
				"						<select id=\"rows\" name=\"rows\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 
				"							<option value=\"10\"" . ($amount_rows == 10 ? " selected=\"selected\"" : "") . ">10</option>\n" . 
				"							<option value=\"20\"" . ($amount_rows == 20 ? " selected=\"selected\"" : "") . ">20</option>\n" . 
				"							<option value=\"40\"" . ($amount_rows == 40 ? " selected=\"selected\"" : "") . ">40</option>\n" . 
				"							<option value=\"50\"" . ($amount_rows == 50 ? " selected=\"selected\"" : "") . ">50</option>\n" . 
				"							<option value=\"60\"" . ($amount_rows == 60 ? " selected=\"selected\"" : "") . ">60</option>\n" . 
				"							<option value=\"80\"" . ($amount_rows == 80 ? " selected=\"selected\"" : "") . ">80</option>\n" . 
				"							<option value=\"100\"" . ($amount_rows == 100 ? " selected=\"selected\"" : "") . ">100</option>\n" . 
				"							<option value=\"200\"" . ($amount_rows == 200 ? " selected=\"selected\"" : "") . ">200</option>\n" . 
				"							<option value=\"400\"" . ($amount_rows == 400 ? " selected=\"selected\"" : "") . ">400</option>\n" . 
				"							<option value=\"500\"" . ($amount_rows == 500 ? " selected=\"selected\"" : "") . ">500</option>\n" . 
				"						</select>\n" . 
				"						<h6 class=\"text-left mt-2\">Sortierfeld</h6>\n" . 
				"						<select id=\"sorting_field\" name=\"sorting_field\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 

				$sorting_field_options . 

				"						</select>\n" . 
				"						<h6 class=\"text-left mt-2\">Sortierrichtung</h6>\n" . 
				"						<select id=\"sorting_direction\" name=\"sorting_direction\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 
				"							<option value=\"0\"" . ($sorting_direction_value == 0 ? " selected=\"selected\"" : "") . ">Aufsteigend</option>\n" . 
				"							<option value=\"1\"" . ($sorting_direction_value == 1 ? " selected=\"selected\"" : "") . ">Absteigend</option>\n" . 
				"						</select>\n" . 
				"						<hr />\n" . 
				"						<select id=\"extra_search\" name=\"extra_search\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 

				$extra_search_options . 

				"						</select>\n" . 
				"					</div>\n" . 
				"				</div>\n" . 
				"			</div>\n" . 
				"		</form>\n"
			)

		) . "\n" . 

		"	</div>\n" . 
		"</div>\n";

if(!isset($_POST['add']) && !isset($_POST['edit']) && !isset($_POST['save']) && !isset($_POST['update'])){

	$parameter['checkbox_to_archiv'] = "";

	include("includes/condition/admin_interested_not_add_not_edit_not_save_not_update.php");

}

if(isset($_POST['edit']) && $_POST['edit'] == "bearbeiten"){

	include("includes/condition/admin_order_edit_bearbeiten.php");

}

?>