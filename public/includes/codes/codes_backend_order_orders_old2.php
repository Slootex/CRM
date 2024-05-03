<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "order_orders_old";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

$host2 = "127.0.0.1:3307";
$username2 = "root";
$password2 = "6b2uf&25A2w*";
$dbName2 = "backend_old";

$con2 = mysqli_connect($host2, $username2, $password2, $dbName2);

mysqli_query($conn, "SET NAMES 'utf8'");

mb_internal_encoding("UTF-8");

date_default_timezone_set("Europe/Berlin");

include("includes/class_navigation.php");

include('includes/class_page_number.php');

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$time = time();

$order_session = "orders_old";
$order_action = "/crm/alte-auftraege2";
$order_table = "order_orders";
$order_mode = 0;
$order_archiv_mode = 1;
$order_right = "order_orders";
$order_name = "Auftrag";

if(isset($_POST["extra_search"])){$_SESSION[$order_session]["extra_search"] = strip_tags($_POST["extra_search"]);}
if(isset($_POST["user_extra_search"])){$_SESSION[$order_session]["user_extra_search"] = strip_tags($_POST["user_extra_search"]);}
if(isset($_POST["rows"])){$_SESSION[$order_session]["rows"] = intval($_POST["rows"]);}
if(isset($_POST["sorting_field"])){$_SESSION[$order_session]["sorting_field"] = intval($_POST["sorting_field"]);}
if(isset($_POST["sorting_direction"])){$_SESSION[$order_session]["sorting_direction"] = intval($_POST["sorting_direction"]);}
if(isset($_POST["keyword"])){$_SESSION[$order_session]["keyword"] = str_replace(" ", "", strip_tags($_POST["keyword"]));}
if(isset($_POST["user_keyword"])){$_SESSION[$order_session]["user_keyword"] = str_replace(" ", "", strip_tags($_POST["user_keyword"]));}
if(isset($_POST["email_template"])){$_SESSION["email_template"]["id"] = strip_tags($_POST["email_template"]);}

$amount_rows = 200;
if(!isset($param['pos'])){
	$pos = 0;
}else{
	$pos = intval($param['pos']);
}

$pageNumberlist = new pageList();

if(isset($_POST['id']) && $_POST['id'] > 0){

	$row_order = mysqli_fetch_array(mysqli_query($con2, "	SELECT 		`wnm_csv`.`rma` AS id, 
																		`wnm_csv`.`rma` AS rma, 
																		`wnm_csv`.`auftragsnummer` AS auftragsnummer, 
																		`wnm_csv`.`shipping_companyname` AS companyname, 
																		`wnm_csv`.`firstname` AS firstname, 
																		`wnm_csv`.`lastname` AS lastname, 
																		`wnm_csv`.`street` AS street, 
																		`wnm_csv`.`zipcode` AS zipcode, 
																		`wnm_csv`.`city` AS city, 
																		`wnm_csv`.`country` AS country, 
																		`wnm_csv`.`email` AS email, 
																		`wnm_csv`.`erstellungsdatum` AS erstellungsdatum 
															FROM 		`wnm_csv` 
															WHERE 		`wnm_csv`.`rma`='" . intval($_POST['id']) . "'"), MYSQLI_ASSOC);

}

$list = "";

$where = 	isset($_SESSION[$order_session]["keyword"]) && $_SESSION[$order_session]["keyword"] != "" ? 
			"WHERE 	(`wnm_csv2`.`rma` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`wnm_csv2`.`shipping_companyname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`wnm_csv2`.`firstname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`wnm_csv2`.`lastname` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`wnm_csv2`.`street` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`wnm_csv2`.`zipcode` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`wnm_csv2`.`city` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`wnm_csv2`.`country` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%' 
			OR		`wnm_csv2`.`email` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$order_session]["keyword"]) . "%') " : 
			"";

$and = $where == "" ? "WHERE 		`wnm_entry`.`wnmkey`>0 " : " AND 		`wnm_entry`.`wnmkey`>0 ";

$query = 	"	SELECT 		`wnm_entry`.`wnmkey` AS id, 
							(
								SELECT 	`wnm_value`.`attrvalue` AS attrvalue_rma 
								FROM 	`wnm_value` 
								WHERE 	`wnm_value`.`attrname`='RMA' 
								AND 	`wnm_value`.`wnmkey`=`wnm_entry`.`wnmkey` 
								limit 	0, 1
							) AS order_number, 
							(
								SELECT 	`wnm_value`.`attrvalue` AS attrvalue_createtime 
								FROM 	`wnm_value` 
								WHERE 	`wnm_value`.`attrname`='CREATETIME' 
								AND 	`wnm_value`.`wnmkey`=`wnm_entry`.`wnmkey` 
								limit 	0, 1
							) AS reg_date, 
							(
								SELECT 	`wnm_value`.`attrvalue` AS attrvalue_companyname 
								FROM 	`wnm_value` 
								WHERE 	`wnm_value`.`attrname`='COMPANYNAME' 
								AND 	`wnm_value`.`wnmkey`=`wnm_entry`.`wnmkey` 
								limit 	0, 1
							) AS companyname, 
							(
								SELECT 	`wnm_csv2`.`firstname` AS csv_firstname 
								FROM 	`wnm_csv2` 
								WHERE 	`wnm_csv2`.`rma`=order_number 
								limit 	0, 1
							) AS firstname, 
							(
								SELECT 	`wnm_csv2`.`lastname` AS csv_lastname 
								FROM 	`wnm_csv2` 
								WHERE 	`wnm_csv2`.`rma`=order_number 
								limit 	0, 1
							) AS lastname, 
							(
								SELECT 	`wnm_csv2`.`street` AS csv_street 
								FROM 	`wnm_csv2` 
								WHERE 	`wnm_csv2`.`rma`=order_number 
								limit 	0, 1
							) AS street, 
							(
								SELECT 	`wnm_csv2`.`zipcode` AS csv_zipcode 
								FROM 	`wnm_csv2` 
								WHERE 	`wnm_csv2`.`rma`=order_number 
								limit 	0, 1
							) AS zipcode, 
							(
								SELECT 	`wnm_csv2`.`city` AS csv_city 
								FROM 	`wnm_csv2` 
								WHERE 	`wnm_csv2`.`rma`=order_number 
								limit 	0, 1
							) AS city, 
							(
								SELECT 	`wnm_csv2`.`country` AS csv_country 
								FROM 	`wnm_csv2` 
								WHERE 	`wnm_csv2`.`rma`=order_number 
								limit 	0, 1
							) AS country, 
							(
								SELECT 	`wnm_csv2`.`email` AS csv_email 
								FROM 	`wnm_csv2` 
								WHERE 	`wnm_csv2`.`rma`=order_number 
								limit 	0, 1
							) AS email 
				FROM 		`wnm_entry` 
				" . $where . $and . " 
				AND 		`wnm_entry`.`entrytype`='RMA'";

$result = mysqli_query($con2, $query);

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

$result = mysqli_query($con2, $query);

if(!isset($_POST['edit']) && (!isset($_POST['id']) || (isset($_POST['id']) && intval($_POST['id']) == 0))){

	if($rows > 0){

		while($row_orders = $result->fetch_array(MYSQLI_ASSOC)){

			$list .= 	"<form action=\"" . $order_action . "\" method=\"post\">\n" . 
						"	<tr" . (isset($_POST['id']) && $_POST['id'] == $row_orders['id'] ? " class=\"bg-primary text-white orders_menu\"" : " class=\"orders_menu\"") . " onclick=\"if(\$(this).hasClass('active')){\$(this).removeClass('active');}else{\$(this).addClass('active');}$('#order_list_" . $row_orders['id'] . "').prop('checked', !$('#order_list_" . $row_orders['id'] . "').prop('checked'))\" data-id=\"" . $row_orders['id'] . "\" data-order_number=\"" . $row_orders['order_number'] . "\">\n" . 
						"		<td scope=\"row\">\n" . 
						"			<div class=\"custom-control custom-checkbox mt-1 ml-2\">\n" . 
						"				<input type=\"checkbox\" id=\"order_list_" . $row_orders['id'] . "\" data-id=\"" . $row_orders['id'] . "\" class=\"custom-control-input order-list\" onclick=\"if(\$(this).closest('tr').hasClass('active')){\$(this).closest('tr').removeClass('active');}else{\$(this).closest('tr').addClass('active');}\" />\n" . 
						"				<label class=\"custom-control-label\" for=\"order_list_" . $row_orders['id'] . "\"></label>\n" . 
						"			</div>\n" . 
						"		</td>\n" . 
						"		<td class=\"text-nowrap\">\n" . 
						"			<small>" . $row_orders['reg_date'] . "</small>\n" . 
						"		</td>\n" . 
						"		<td scope=\"row\" align=\"center\">\n" . 
						"			<small>" . $row_orders['order_number'] . "</small>\n" . 
						"		</td>\n" . 
						"		<td>\n" . 
						"			<small>" . ($row_orders['companyname'] != "" ? $row_orders['companyname'] . ", " : "") . $row_orders['firstname'] . " " . $row_orders['lastname'] . "</small>\n" . 
						"		</td>\n" . 
						"		<td>\n" . 
						"			<small><a href=\"mailto: " . $row_orders['email'] . "\">" . $row_orders['email'] . "</a></small>\n" . 
						"		</td>\n" . 
						"		<td align=\"center\">\n" . 
						"			<input type=\"hidden\" name=\"id\" value=\"" . $row_orders['id'] . "\" />\n" . 
						"			<button type=\"submit\" name=\"edit\" value=\"bearbeiten\" class=\"btn btn-sm btn-success\"" . (!isset($row_wnm['wnmkey']) ? " disabled=\"disabled\"" : "") . ">bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>\n" . 
						"		</td>\n" . 
						"	</tr>\n" . 
						"</form>\n";

		}

	}else{

		$list = isset($_POST['search']) && $_POST['search'] == "suchen" ? "<script>alert('Es wurden keine mit deiner Suchanfrage - " . $_SESSION[$order_session]["keyword"] . " - übereinstimmende Aufträge gefunden.')</script>\n" : "";

	}

}

$navigation = new navigation($conn, 3, "order_old");
$navigation->options['main_href_link_normal'] = "			<li class=\"nav-item\">\n				<a href=\"[href]\" class=\"nav-link\">[name]</a>\n			</li>\n";
$navigation->options['main_href_link_active'] = "			<li class=\"nav-item\">\n				<a href=\"[href]\" class=\"nav-link active\">[name]</a>\n			</li>\n";

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-7 col-md-7 col-sm-7 col-xs-7\">\n" . 
		"		<ul class=\"nav nav-pills\">\n" . 

		$navigation->show() . 

		"		</ul>\n" . 
		"	</div>\n" . 
		"	<div class=\"col-sm-5 text-right\">\n" . 
		"		<form action=\"" . $order_action . "\" method=\"post\">\n" . 
		"			<div class=\"form-group row mb-1\">\n" . 
		"				<div class=\"col-sm-12\">\n" . 
		"					<div class=\"btn-group\">\n" . 
		"						<input type=\"text\" id=\"keyword\" name=\"keyword\" value=\"" . (isset($_SESSION[$order_session]['keyword']) && $_SESSION[$order_session]['keyword'] != "" ? $_SESSION[$order_session]['keyword'] : "") . "\" placeholder=\"Suchbegriff / Barcode\" aria-label=\"Suchbegriff / Barcode\" class=\"form-control bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" style=\"border-radius: .25rem 0 0 .25rem\" />\n" . 
		"						<button type=\"submit\" name=\"search\" value=\"suchen\" class=\"btn btn-primary\"><i class=\"fa fa-search\" aria-hidden=\"true\"></i></button>\n" . 
		"					</div>\n" . 
		"				</div>\n" . 
		"			</div>\n" . 
		"		</form>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<hr />\n" . 
		"<div class=\"row\">\n" . 
		"	<div class=\"col-7\">\n" . 
		"		" . (isset($_POST['id']) && intval($_POST['id']) > 0 ? "<h3>Auftragsübersicht-Alt-Auftragsnummer: " . $row_order['rma'] . "</h3><p id=\"user_info\" class=\"mb-0\">" . ($row_order['companyname'] != "" ? "Firma: " . $row_order['companyname'] . ", " : "") . "Name: " . $row_order['firstname'] . " " . $row_order['lastname'] . "</p>" : "<h3>Auftragsübersicht-alt</h3>") . "\n" . 
		"	</div>\n" . 
		"	<div class=\"col-lg-5 col-md-5 col-sm-5 col-xs-5 text-right\">\n" . 
		"	</div>\n" . 
		"</div>\n";

if(!isset($_POST['edit']) && !isset($_POST['update'])){

	$html .= 	"<hr />\n" . 

				$pageNumberlist->getInfo() . 

				"<br />\n" . 

				$pageNumberlist->getNavi() . 

				"<div class=\"table-responsive\">\n" . 
				"	<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
				"		<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
				"			<th width=\"40\" scope=\"col\">\n" . 
				"				<div class=\"custom-control custom-checkbox mt-0 ml-2\">\n" . 
				"					<input type=\"checkbox\" id=\"order_sel_all_top\" class=\"custom-control-input\" onclick=\"var check = \$('#order_sel_all_bottom').prop('checked');\$('#order_sel_all_bottom').prop('checked', this.checked);\$('.order-list').each(function(){\$(this).prop('checked', !check);if(check == true){\$(this).closest('tr').removeClass('active');}else{\$(this).closest('tr').addClass('active');}});\" />\n" . 
				"					<label class=\"custom-control-label\" for=\"order_sel_all_top\"></label>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\">\n" . 
				"				<strong>Erstellt</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"140\" scope=\"col\">\n" . 
				"				<strong>Nr</strong>\n" . 
				"			</th>\n" . 
				"			<th scope=\"col\">\n" . 
				"				<strong>Kunde</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"140\" scope=\"col\">\n" . 
				"				<strong>Email</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"140\" align=\"center\" scope=\"col\" class=\"text-center\">\n" . 
				"				<strong>Aktion</strong>\n" . 
				"			</th>\n" . 
				"		</tr></thead>\n" . 

				$list . 

				"	</table>\n" . 
				"</div>\n" . 
				"<form action=\"" . $order_action . "\" method=\"post\">\n" . 
				"	<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm mb-0\">\n" . 
				"		<tr class=\"text-primary\">\n" . 
				"			<td width=\"40\">\n" . 
				"				<div class=\"custom-control custom-checkbox mt-1 ml-2\">\n" . 
				"					<input type=\"checkbox\" id=\"order_sel_all_bottom\" class=\"custom-control-input\" onclick=\"var check = \$('#order_sel_all_top').prop('checked');\$('#order_sel_all_top').prop('checked', this.checked);\$('.order-list').each(function(){\$(this).prop('checked', !check);if(check == true){\$(this).closest('tr').removeClass('active');}else{\$(this).closest('tr').addClass('active');}});\" />\n" . 
				"					<label class=\"custom-control-label\" for=\"order_sel_all_bottom\"></label>\n" . 
				"				</div>\n" . 
				"			</td>\n" . 
				"			<td width=\"350\">\n" . 
				"				<label for=\"order_sel_all_bottom\" class=\"mt-1\">alle auswählen (" . (1+($pos > $rows ? $rows : $pos)) . " bis " . (($pos + $amount_rows) > $rows ? $rows : ($pos + $amount_rows)) . " von " . $rows . " Einträgen)</label>\n" . 
				"			</td>\n" . 
				"			<td width=\"260\">\n" . 
				"				<input type=\"hidden\" id=\"ids\" name=\"ids\" value=\"\" />\n" . 
				"				<button type=\"submit\" name=\"update\" value=\"durchführen\" class=\"btn btn-sm btn-primary\" onclick=\"var ids='';$('.order-list').each(function(){if($(this).prop('checked')){ids+=ids==''?$(this).data('id'):','+$(this).data('id');}});$('#ids').val(ids);if(ids==''){alert('Bitte wählen Sie für diese Funktion ein oder mehrere Einträge aus!');return false;}else{return confirm('Wollen Sie wirklich den gewählten Status für die ausgewählten Einträge durchführen?');}\"><i class=\"fa fa-check\" aria-hidden=\"true\"></i></button>\n" . 
				"			</td>\n" . 
				"			<td align=\"right\">\n" . 
				"			</td>\n" . 
				"		</tr>\n" . 
				"	</table>\n" . 
				"</form>\n" . 
				"<br />\n" . 

				$pageNumberlist->getNavi();

}

if(isset($_POST['edit']) && $_POST['edit'] == "bearbeiten"){

	$description = "";

	$comment = "";

	$payment = "";

	$REPAIRSELECTTEXT = "";

	$REPAIRTEXT = "";

	$SHIPPING_PAID = "";

	$TRACKINGCODE = "";

	$files = "";

	$row_order = mysqli_fetch_array(mysqli_query($con2, "	SELECT 		`wnm_csv`.`rma` AS id, 
																		`wnm_csv`.`rma` AS rma, 
																		`wnm_csv`.`auftragsnummer` AS auftragsnummer, 
																		`wnm_csv`.`shipping_companyname` AS companyname, 
																		`wnm_csv`.`firstname` AS firstname, 
																		`wnm_csv`.`lastname` AS lastname, 
																		`wnm_csv`.`street` AS street, 
																		`wnm_csv`.`zipcode` AS zipcode, 
																		`wnm_csv`.`city` AS city, 
																		`wnm_csv`.`country` AS country, 
																		`wnm_csv`.`email` AS email, 
																		`wnm_csv`.`erstellungsdatum` AS erstellungsdatum 
															FROM 		`wnm_csv` 
															WHERE 		`wnm_csv`.`rma`='" . intval($_POST['id']) . "'"), MYSQLI_ASSOC);

	$row_wnm = mysqli_fetch_array(mysqli_query($con2, "	SELECT 	`wnm_value`.`wnmkey` AS wnmkey 
														FROM 	`wnm_value` 
														WHERE 	`wnm_value`.`attrname`='RMA' 
														AND 	`wnm_value`.`attrvalue`='" . intval($_POST['id']) . "'"), MYSQLI_ASSOC);

	$result = mysqli_query($con2, "SELECT * FROM `wnm_value` WHERE `wnm_value`.`wnmkey`='" . $row_wnm['wnmkey'] . "'");

	while($row_data = $result->fetch_array(MYSQLI_ASSOC)){

		if($row_data['attrname'] == "description"){
			$description = $row_data['attrvalue'];
		}

		if($row_data['attrname'] == "COMMENT"){
			$comment = $row_data['attrvalue'];
		}

		if($row_data['attrname'] == "PAYMENT"){
			$payment = $row_data['attrvalue'];
		}

		if($row_data['attrname'] == "REPAIRSELECTTEXT"){
			$REPAIRSELECTTEXT = $row_data['attrvalue'];
		}

		if($row_data['attrname'] == "REPAIRTEXT"){
			$REPAIRTEXT = $row_data['attrvalue'];
		}

		if($row_data['attrname'] == "SHIPPING_PAID"){
			$SHIPPING_PAID = $row_data['attrvalue'];
		}

		if($row_data['attrname'] == "TRACKINGCODE"){
			$TRACKINGCODE = $row_data['attrvalue'];
		}

		if(substr($row_data['attrname'], 0, 4) == "FILE"){
			$files .= "<a href=\"https://backend-old.eversafe.synology.me/uploads/" . $row_data['attrvalue'] . "\" target=\"_blank\">" . $row_data['attrvalue'] . "</a><br />\n";
		}

	}

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col-sm-6\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Details</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 
				"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-6 col-form-label\">Firma, Name:</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							" . ($row_order['companyname'] != "" ? $row_order['companyname'] . ", " : "") . $row_order['firstname'] . " " . $row_order['lastname'] . "\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-6 col-form-label\">Email:</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<a href=\"mailto: " . $row_order['email'] . "\">" . $row_order['email'] . "</a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-6 col-form-label\">Anschrift:</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							" . $row_order['street'] . "<br />" . $row_order['zipcode'] . " " . $row_order['city'] . "<br />" . $row_order['country'] . "\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-6 col-form-label\">Beschreibung:</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							" . $description . "\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-6 col-form-label\">Kommentare:</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							" . $comment . "\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-6 col-form-label\">Zahlungsweise:</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							" . $payment . "\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-6 col-form-label\">REPAIRSELECTTEXT:</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							" . $REPAIRSELECTTEXT . "\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-6 col-form-label\">REPAIRTEXT:</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							" . $REPAIRTEXT . "\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-6 col-form-label\">SHIPPING_PAID:</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							" . $SHIPPING_PAID . "\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-6 col-form-label\">TRACKINGCODE:</label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							" . $TRACKINGCODE . "\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"	<div class=\"col-sm-6\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Dateien</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				$files . 

				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br />\n" . 
				"<br />\n" . 
				"<br />\n";

}

?>