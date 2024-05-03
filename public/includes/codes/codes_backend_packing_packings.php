<?php 

@session_start();

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "packing_packings";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

include("includes/class_condition.php");

include("includes/class_navigation.php");

include('includes/class_page_number.php');

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$time = time();

$parameter = array();

$parameter['tab'] = "edit";
$parameter['link'] = "neue-packtische";

$packing_session = "packing";
$packing_action = "/crm/neue-packtische";
$packing_table = "packing_packings";
$packing_id_field = "packing_id";
$packing_mode = 0;
$packing_archiv_mode = 1;
$packing_hash = "";
$packing_templates_type = 7;
$packing_right = "packing_packings";
$packing_name = "Packtisch";

$tabs = array();

if(isset($_POST["extra_search"])){$_SESSION[$packing_session]["extra_search"] = strip_tags($_POST["extra_search"]);}
if(isset($_POST["user_extra_search"])){$_SESSION[$packing_session]["user_extra_search"] = strip_tags($_POST["user_extra_search"]);}
if(isset($_POST["rows"])){$_SESSION[$packing_session]["rows"] = intval($_POST["rows"]);}
if(isset($_POST["sorting_field"])){$_SESSION[$packing_session]["sorting_field"] = intval($_POST["sorting_field"]);}
if(isset($_POST["sorting_direction"])){$_SESSION[$packing_session]["sorting_direction"] = intval($_POST["sorting_direction"]);}
if(isset($_POST["keyword"])){$_SESSION[$packing_session]["keyword"] = str_replace(" ", "", strip_tags($_POST["keyword"]));}
if(isset($_POST["user_keyword"])){$_SESSION[$packing_session]["user_keyword"] = str_replace(" ", "", strip_tags($_POST["user_keyword"]));}
if(isset($_POST["email_template"])){$_SESSION["email_template"]["id"] = strip_tags($_POST["email_template"]);}

$directions = array(0 => "ASC", 1 => "DESC");

$sorting_direction_name = isset($_SESSION[$packing_session]["sorting_direction"]) ? $directions[$_SESSION[$packing_session]["sorting_direction"]] : "ASC";
$sorting_direction_value = isset($_SESSION[$packing_session]["sorting_direction"]) ? $_SESSION[$packing_session]["sorting_direction"] : 0;

if(isset($_POST['set_search_defaults']) && $_POST['set_search_defaults'] == "OK"){
	unset($_SESSION[$packing_session]);
}

if(isset($param['add']) && $param['add'] == "neuer-packtisch"){
	$_POST['add'] = "hinzufügen";
}

$amount_rows = isset($_SESSION[$packing_session]["rows"]) && $_SESSION[$packing_session]["rows"] > 0 ? $_SESSION[$packing_session]["rows"] : 500;
if(!isset($param['pos_shopin'])){
	$pos_shopin = 0;
}else{
	$pos_shopin = intval($param['pos_shopin']);
}
if(!isset($param['pos_intern'])){
	$pos_intern = 0;
}else{
	$pos_intern = intval($param['pos_intern']);
}
if(!isset($param['pos_packing'])){
	$pos_packing = 0;
}else{
	$pos_packing = intval($param['pos_packing']);
}

$emsg = "";
$emsg_shipment = "";

$inp_order_number = "";
$inp_message = "";

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

$order_number = "";
$message = "";

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

$package_template = 1;

$html_new_shipping_result = "";

if(isset($param['archiv']) && strip_tags($param['archiv']) == "archiv" && isset($param['id']) && intval($param['id']) > 0){

	$parameter['tab'] = "";
	$parameter['link'] = "neue-packtische";

	$_POST['id'] = intval($param['id']);
	$_POST['move'] = "Archiv";

}

if(isset($param['we_edit']) && strip_tags($param['we_edit']) == "we-bearbeiten-1" && isset($param['id']) && intval($param['id']) > 0){

	$parameter['tab'] = "edit";
	$parameter['link'] = "neue-packtische";

	$_POST['id'] = intval($param['id']);
	$_POST['shopin_order'] = "none";

}

if(isset($param['we_edit']) && strip_tags($param['we_edit']) == "we-bearbeiten-2" && isset($param['id']) && intval($param['id']) > 0){

	$parameter['tab'] = "edit";
	$parameter['link'] = "neue-packtische";

	$_POST['id'] = intval($param['id']);
	$_POST['shopin_none'] = "complete";

}

if(isset($param['we_edit']) && strip_tags($param['we_edit']) == "we-bearbeiten-3" && isset($param['id']) && intval($param['id']) > 0){

	$parameter['tab'] = "edit";
	$parameter['link'] = "neue-packtische";

	$_POST['id'] = intval($param['id']);
	$_POST['shopin_edit'] = "bearbeiten";

}

if(isset($param['intern_edit']) && strip_tags($param['intern_edit']) == "intern-bearbeiten" && isset($param['id']) && intval($param['id']) > 0){

	$parameter['tab'] = "edit";
	$parameter['link'] = "neue-packtische";

	$_POST['id'] = intval($param['id']);
	$_POST['intern_relocate_edit'] = "bearbeiten";

}

if(isset($_POST['save']) && $_POST['save'] == "speichern"){

	$parameter['tab'] = "edit";
	$parameter['link'] = "neuer-packtisch";

	$parameter['link_edit'] = "neue-packtische";

	$parameter['packing_status'] = "packing_status";

	include("includes/condition/admin_packing_save_speichern.php");

}

if(isset($_POST['id']) && $_POST['id'] > 0){

	$row_packing = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `packing_packings` WHERE `packing_packings`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `packing_packings`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'"), MYSQLI_ASSOC);

}

if(isset($_POST['add']) && $_POST['add'] == "hinzufügen"){

	$parameter['link'] = "neuer-packtisch";
	
}

if(isset($_POST['search']) && $_POST['search'] == "suchen"){

	$_SESSION[$packing_session]["keyword"] = strip_tags($_POST['searchword']);

}else{

	$_SESSION[$packing_session]["keyword"] = "";
	
}

$result_tabs = mysqli_query($conn, "SELECT 		* 
									FROM 		`rights` 
									WHERE 		`rights`.`parent_id`=(SELECT `rights`.`id` AS id FROM `rights` WHERE `rights`.`authorization`='" . $packing_right . "') 
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

					$radio_payment = $row_packing['radio_payment'];

				}

				include("includes/condition/" . $condition->phpFile());

			}

		}

	}

}

if(isset($_POST['move']) && $_POST['move'] == "Archiv"){

	$parameter['link'] = "neue-packtische";

	$parameter['packing_to_archive_status'] = "packing_to_archive_status";

	include("includes/condition/admin_packing_move_archiv.php");

}

if(isset($_POST['add_devices']) && $_POST['add_devices'] == "speichern"){

	$parameter['link'] = "neue-packtische";

	$_POST['pack'] = "user";

	include("includes/condition/admin_packing_add_devices_speichern.php");

	unset($_POST['edit']);

}

if(isset($_POST['shopin_add']) && $_POST['shopin_add'] == "store"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_shopin_add_store.php");

	unset($_POST['edit']);

}

if(isset($_POST['shopin_add']) && $_POST['shopin_add'] == "save"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_shopin_add_save.php");

	unset($_POST['edit']);

}

if(isset($_POST['shopin_add']) && $_POST['shopin_add'] == "aktualisieren"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_shopin_add_refresh.php");

	unset($_POST['edit']);

}

if(isset($_POST['shopin_add']) && $_POST['shopin_add'] == "hochladen"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_shopin_add_hochladen.php");

	unset($_POST['edit']);

}

if(isset($_POST['shopin_add']) && $_POST['shopin_add'] == "X"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_shopin_add_x.php");

	unset($_POST['edit']);

}

if(isset($_POST['shopin_at']) && $_POST['shopin_at'] == "speichern"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_shopin_at_speichern.php");

	unset($_POST['edit']);

}

if(isset($_POST['shopin_org']) && $_POST['shopin_org'] == "speichern"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_shopin_org_speichern.php");

	unset($_POST['edit']);

}

if(isset($_POST['shopin_add_undo']) && $_POST['shopin_add_undo'] == "rueckgaengig"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_shopin_add_undo_rueckgaengig.php");

	unset($_POST['edit']);

}

if(isset($_POST['shopin_none']) && $_POST['shopin_none'] == "store"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_shopin_none_store.php");

	unset($_POST['edit']);

}

if(isset($_POST['shopin_none']) && $_POST['shopin_none'] == "save"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_shopin_none_save.php");

	unset($_POST['edit']);

}

if(isset($_POST['shopin_none_undo']) && $_POST['shopin_none_undo'] == "rueckgaengig"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_shopin_none_undo_rueckgaengig.php");

	unset($_POST['edit']);

}

if(isset($_POST['shopin_relocate']) && $_POST['shopin_relocate'] == "store"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_shopin_relocate_store.php");

	unset($_POST['edit']);

}

if(isset($_POST['shopin_relocate']) && $_POST['shopin_relocate'] == "save"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_shopin_relocate_save.php");

	unset($_POST['edit']);

}

if(isset($_POST['shopin_relocate_undo']) && $_POST['shopin_relocate_undo'] == "rueckgaengig"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_shopin_relocate_rueckgaengig.php");

	unset($_POST['edit']);

}

if(isset($_POST['shopin_next_storage_undo']) && $_POST['shopin_next_storage_undo'] == "rueckgaengig"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_shopin_next_storage_undo_rueckgaengig.php");

	unset($_POST['edit']);

}

if(isset($_POST['shopin_device_reset']) && $_POST['shopin_device_reset'] == "zuruecksetzen"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_shopin_device_reset_zuruecksetzen.php");

	unset($_POST['edit']);

}

if(isset($_POST['shopin_order']) && $_POST['shopin_order'] == "search"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_shopin_order_search.php");

	unset($_POST['edit']);

}

if(isset($_POST['shopin_order']) && $_POST['shopin_order'] == "no_order_number"){

	$parameter['link'] = "neue-packtische";

	unset($_POST['order_number']);

	include("includes/condition/admin_packing_shopin_order_search.php");

	unset($_POST['edit']);

}

if(isset($_POST['shopin_order_save']) && $_POST['shopin_order_save'] == "speichern"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_shopin_add_order_speichern.php");

	unset($_POST['edit']);

}

if(isset($_POST['shopin_delete']) && $_POST['shopin_delete'] == "entfernen"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_shopin_delete_entfernen.php");

	unset($_POST['edit']);

}

if(isset($_POST['shopin_to_intern']) && $_POST['shopin_to_intern'] == "speichern"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_shopin_to_intern_speichern.php");

	unset($_POST['edit']);

}

if(isset($_POST['shopin_next_storage']) && $_POST['shopin_next_storage'] == "store"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_shopin_next_storage_store.php");

	unset($_POST['edit']);

}

if(isset($_POST['shopin_next_storage']) && $_POST['shopin_next_storage'] == "save"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_shopin_next_storage_save.php");

	unset($_POST['edit']);

}

if(isset($_POST['intern_photo_update']) && $_POST['intern_photo_update'] == "speichern"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_intern_photo_update_speichern.php");

	unset($_POST['edit']);

}

if(isset($_POST['intern_photo_ready']) && $_POST['intern_photo_ready'] == "fertig"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_intern_photo_ready_fertig.php");

	unset($_POST['edit']);

}

if(isset($_POST['intern_relocate_update']) && $_POST['intern_relocate_update'] == "speichern"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_intern_relocate_update_speichern.php");

	unset($_POST['edit']);

}

if(isset($_POST['intern_labeling_update']) && $_POST['intern_labeling_update'] == "speichern"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_intern_labeling_update_speichern.php");

	unset($_POST['edit']);

}

if(isset($_POST['intern_delete']) && $_POST['intern_delete'] == "entfernen"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_intern_delete_entfernen.php");

	unset($_POST['edit']);

}

if(isset($_POST['intern_relocate']) && $_POST['intern_relocate'] == "durchfuehren"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_intern_relocate_durchfuehren.php");

	unset($_POST['edit']);

}

if(isset($_POST['intern_labeling_ready']) && $_POST['intern_labeling_ready'] == "fertig"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_intern_labeling_ready_fertig.php");

	unset($_POST['edit']);

}

if(isset($_POST['device_delete']) && $_POST['device_delete'] == "X"){

	$parameter['link'] = "neue-packtische";

	$_POST['pack'] = "user";

	include("includes/condition/admin_packing_delete_device_x.php");

	unset($_POST['edit']);

}

if(isset($_POST['packing_user']) && $_POST['packing_user'] == "speichern"){

	$parameter['link'] = "neue-packtische";

	$_POST['pack'] = "user";

	include("includes/condition/admin_packing_packing_user_speichern.php");

	unset($_POST['edit']);

}

if(isset($_POST['add_devices_technic']) && $_POST['add_devices_technic'] == "speichern"){

	$parameter['link'] = "neue-packtische";

	$_POST['pack'] = "technic";

	include("includes/condition/admin_packing_add_devices_speichern.php");

	unset($_POST['edit']);

}

if(isset($_POST['device_delete_technic']) && $_POST['device_delete_technic'] == "X"){

	$parameter['link'] = "neue-packtische";

	$_POST['pack'] = "technic";

	include("includes/condition/admin_packing_delete_device_x.php");

	unset($_POST['edit']);

}

if(isset($_POST['packing_technic']) && $_POST['packing_technic'] == "speichern"){

	$parameter['link'] = "neue-packtische";

	$_POST['pack'] = "technic";

	include("includes/condition/admin_packing_packing_technic_speichern.php");

	unset($_POST['edit']);

}

if(isset($_POST['packing_technic_address']) && $_POST['packing_technic_address'] == "auswaehlen"){

	$parameter['link'] = "neue-packtische";

	$_POST['pack'] = "technic";

	include("includes/condition/admin_packing_packing_technic_address_auswaehlen.php");

	unset($_POST['edit']);

}

if(isset($_POST['packing_extern']) && $_POST['packing_extern'] == "speichern"){

	$parameter['link'] = "neue-packtische";

	$_POST['pack'] = "extern";

	include("includes/condition/admin_packing_packing_extern_speichern.php");

	unset($_POST['edit']);

}

if(isset($_POST['packing_extern_blank']) && $_POST['packing_extern_blank'] == "speichern"){

	$parameter['link'] = "neue-packtische";

	$_POST['pack'] = "extern_blank";

	include("includes/condition/admin_packing_packing_extern_blank_speichern.php");

	unset($_POST['edit']);

}

if(isset($_POST['packing']) && $_POST['packing'] == "verpacken"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_packing_verpacken.php");

	unset($_POST['edit']);

}

if(isset($_POST['packing_user']) && $_POST['packing_user'] == "verpacken"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_packing_user_verpacken.php");

	unset($_POST['edit']);

}

if(isset($_POST['packing_technic']) && $_POST['packing_technic'] == "verpacken"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_packing_technic_verpacken.php");

	unset($_POST['edit']);

}

if(isset($_POST['packing_blank']) && $_POST['packing_blank'] == "verpacken"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_packing_blank_verpacken.php");

	unset($_POST['edit']);

}

if(isset($_POST['packing_adding_technic_shipping']) && $_POST['packing_adding_technic_shipping'] == "durchfuehren"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_packing_adding_technic_shipping_durchfuehren.php");

	unset($_POST['edit']);

}

if(isset($_POST['packing_adding_technic_shipping']) && $_POST['packing_adding_technic_shipping'] == "durchfuehren ohne Sendung"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_packing_adding_technic_shipping_durchfuehren_without_send.php");

	unset($_POST['edit']);

}

if(isset($_POST['packing_adding_extern_shipping']) && $_POST['packing_adding_extern_shipping'] == "durchfuehren"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_packing_adding_extern_shipping_durchfuehren.php");

	unset($_POST['edit']);

}

if(isset($_POST['packing_adding_extern_shipping_blank']) && $_POST['packing_adding_extern_shipping_blank'] == "durchfuehren"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_packing_adding_extern_shipping_blank_durchfuehren.php");

	unset($_POST['edit']);

}

if(isset($_POST['error']) && $_POST['error'] == "melden"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_error_melden.php");

	unset($_POST['edit']);

}

if(isset($_POST['packing_close']) && $_POST['packing_close'] == "schliessen"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_packing_close_schliessen.php");

	unset($_POST['edit']);

}

if(isset($_POST['packing_delete']) && $_POST['packing_delete'] == "entfernen"){

	$parameter['link'] = "neue-packtische";

	include("includes/condition/admin_packing_packing_delete_entfernen.php");

	unset($_POST['edit']);

}

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$navigation = new navigation($conn, 7, ($parameter['link'] == "neue-packtische" ? "packing_packings" : ($parameter['link'] == "packtische-archiv" ? "packing_archive" : ($parameter['link'] == "neuer-packtisch" ? "packing_new" : ""))));
$navigation->options['main_href_link_normal'] = "			<li class=\"nav-item\">\n				<a href=\"[href]\" class=\"nav-link btn-lg\">[name]</a>\n			</li>\n";
$navigation->options['main_href_link_active'] = "			<li class=\"nav-item\">\n				<a href=\"[href]\" class=\"nav-link btn-lg active\">[name]</a>\n			</li>\n";

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-7 col-md-7 col-sm-7 col-xs-7\">\n" . 
		"		<ul class=\"nav nav-pills\">\n" . 

		$navigation->show() . 

		"		</ul>\n" . 
		"	</div>\n" . 
		"	<div class=\"col-sm-5 text-right\">\n" . 
		"		<form action=\"" . $packing_action . "\" method=\"post\">\n" . 
		"			<div class=\"btn-group btn-group-lg\">\n" . 
		"				<input type=\"text\" name=\"searchword\" value=\"" . strip_tags($_SESSION[$packing_session]["keyword"]) . "\" class=\"form-control form-control-lg border border-success text-success\" style=\"border-radius: .25rem 0 0 .25rem\" placeholder=\"Suchbegriff / Barcode\" />\n" . 
		"				<button type=\"submit\" name=\"search\" value=\"suchen\" class=\"btn btn-success\"><i class=\"fa fa-search\" aria-hidden=\"true\"></i></button>\n" . 
		"				<button type=\"submit\" name=\"set_search_defaults\" value=\"OK\" class=\"btn btn-primary\"><i class=\"fa fa-eraser\" aria-hidden=\"true\"></i></button>\n" . 
		"				<button type=\"button\" class=\"btn btn-secondary dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" onclick=\"$('.my-dropdown-menu').slideToggle(0)\" onfocus=\"this.blur()\">Filter</button>\n" . 
		"			</div>\n" . 
		"			<div class=\"my-dropdown-menu bg-white rounded-bottom border border-primary p-3 mr-3\" style=\"position: absolute;top: 50px;right: 0px;margin-bottom: 30px;width: 200px;display: none;box-shadow: 0 0 4px #000;z-Index: 1000\">\n" . 
		"				<h6 class=\"text-left\">Einträge&nbsp;pro&nbsp;Seite</h6>\n" . 
		"				<select id=\"rows\" name=\"rows\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 
		"					<option value=\"10\"" . ($amount_rows == 10 ? " selected=\"selected\"" : "") . ">10</option>\n" . 
		"					<option value=\"20\"" . ($amount_rows == 20 ? " selected=\"selected\"" : "") . ">20</option>\n" . 
		"					<option value=\"40\"" . ($amount_rows == 40 ? " selected=\"selected\"" : "") . ">40</option>\n" . 
		"					<option value=\"50\"" . ($amount_rows == 50 ? " selected=\"selected\"" : "") . ">50</option>\n" . 
		"					<option value=\"60\"" . ($amount_rows == 60 ? " selected=\"selected\"" : "") . ">60</option>\n" . 
		"					<option value=\"80\"" . ($amount_rows == 80 ? " selected=\"selected\"" : "") . ">80</option>\n" . 
		"					<option value=\"100\"" . ($amount_rows == 100 ? " selected=\"selected\"" : "") . ">100</option>\n" . 
		"					<option value=\"200\"" . ($amount_rows == 200 ? " selected=\"selected\"" : "") . ">200</option>\n" . 
		"					<option value=\"400\"" . ($amount_rows == 400 ? " selected=\"selected\"" : "") . ">400</option>\n" . 
		"					<option value=\"500\"" . ($amount_rows == 500 ? " selected=\"selected\"" : "") . ">500</option>\n" . 
		"				</select>\n" . 
		"				<h6 class=\"text-left mt-2\">Sortierrichtung</h6>\n" . 
		"				<select id=\"sorting_direction\" name=\"sorting_direction\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 
		"					<option value=\"0\"" . ($sorting_direction_value == 0 ? " selected=\"selected\"" : "") . ">Aufsteigend</option>\n" . 
		"					<option value=\"1\"" . ($sorting_direction_value == 1 ? " selected=\"selected\"" : "") . ">Absteigend</option>\n" . 
		"				</select>\n" . 
		"			</div>\n" . 
		"		</form>\n" . 
		"	</div>\n" . 
		"</div>\n" . 
		"<hr />\n" . 
		"<div class=\"row\">\n" . 
		"	<div class=\"col-7\">\n" . 
		"		<h3>Packtisch</h3>\n" . 
		"	</div>\n" . 
		"	<div class=\"col-lg-5 col-md-5 col-sm-5 col-xs-5 text-right\">\n" . 
		"		&nbsp;\n" . 
		"	</div>\n" . 
		"</div>\n";

if(!isset($_POST['id']) && !isset($_POST['add'])){

	$html .= 	"<hr />\n" . 

				"<form action=\"" . $packing_action . "\" method=\"post\">\n" . 
				"	<div class=\"row\">\n" . 
				"		<div class=\"col-sm-2\">\n" . 
				"			<h3 class=\"mt-1\">Wareneingang</h3>\n" . 
				"		</div>\n" . 
				"		<div class=\"col-sm-4\">\n" . 
				"			<div class=\"btn-group btn-group-lg mb-2\">\n" . 
				"				<div class=\"btn-group btn-group-toggle\" data-toggle=\"buttons\">\n" . 
				"					<label class=\"btn btn-lg btn-light border border-success\">\n" . 
				"						<input type=\"radio\" id=\"atot_mode_change\" name=\"atot_mode\" value=\"1\" class=\"custom-control-input\" /> Austauschteil\n" . 
				"					</label>\n" . 
				"					<label class=\"btn btn-lg btn-light border border-success active\">\n" . 
				"						<input type=\"radio\" id=\"atot_mode_original\" name=\"atot_mode\" value=\"2\" checked=\"checked\" class=\"custom-control-input\" /> Originalteil\n" . 
				"					</label>\n" . 
				"				</div>\n" . 
				"				<div class=\"btn-group\">\n" . 
				"					<input type=\"text\" id=\"order_number\" name=\"order_number\" value=\"\" class=\"form-control form-control-lg border rounded-0 border-success text-success\" placeholder=\"|||||||| Auftrag / Gerät\" onKeyPress=\"if(event.keyCode == '13'){document.getElementById('shopin_order').click();return false;}\" />\n" . 
				"					<button type=\"submit\" id=\"shopin_order\" name=\"shopin_order\" value=\"search\" class=\"btn btn-lg btn-success\"><i class=\"fa fa-plus\" aria-hidden=\"true\"></i></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n" . 
				"				</div>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"		<div class=\"col-sm-6\">\n" . 
				"			<button type=\"submit\" name=\"shopin_order\" value=\"no_order_number\" class=\"btn btn-danger btn-lg\">Kein Barcode <i class=\"fa fa-exclamation\" aria-hidden=\"true\"></i></button>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</form>\n";

	include("includes/condition/admin_packing_table_shopin.php");

	include("includes/condition/admin_packing_table_intern.php");

	include("includes/condition/admin_packing_table_packing.php");

	$html .=	"<br />\n" . 
				"<br />\n";

}

if(isset($_POST['add']) && $_POST['add'] == "hinzufügen"){

	include("includes/condition/admin_packing_add_hinzufuegen.php");

}

if(isset($_POST['shopin_edit']) && $_POST['shopin_edit'] == "bearbeiten"){

	include("includes/condition/admin_packing_shopin_edit.php");

}

if(isset($_POST['shopin_add_device']) && $_POST['shopin_add_device'] == "hinzufügen"){

	include("includes/condition/admin_packing_shopin_add_device.php");

}

if(isset($_POST['shopin_add_device']) && $_POST['shopin_add_device'] == "complete"){

	include("includes/condition/admin_packing_shopin_add_device_complete.php");

}

if(isset($_POST['shopin_next_storage']) && $_POST['shopin_next_storage'] == "hinzufügen"){

	include("includes/condition/admin_packing_shopin_next_storage.php");

}

if(isset($_POST['shopin_next_storage']) && $_POST['shopin_next_storage'] == "complete"){

	include("includes/condition/admin_packing_shopin_next_storage_complete.php");

}

if(isset($_POST['shopin_order']) && $_POST['shopin_order'] == "none"){

	include("includes/condition/admin_packing_shopin_order_none.php");

}

if(isset($_POST['shopin_none']) && $_POST['shopin_none'] == "complete"){

	include("includes/condition/admin_packing_shopin_none_complete.php");

}

if(isset($_POST['shopin_relocate']) && $_POST['shopin_relocate'] == "hinzufügen"){

	include("includes/condition/admin_packing_shopin_relocate.php");

}

if(isset($_POST['shopin_relocate']) && $_POST['shopin_relocate'] == "complete"){

	include("includes/condition/admin_packing_shopin_relocate_complete.php");

}

if(isset($_POST['shopin_used']) && $_POST['shopin_used'] == "benutzt"){

	include("includes/condition/admin_packing_shopin_used.php");

}

if(isset($_POST['shopin_storage_space_id']) && $_POST['shopin_storage_space_id'] == "empty"){

	include("includes/condition/admin_packing_shopin_storage_space_id_empty.php");

}

if(isset($_POST['shopin_order_id']) && $_POST['shopin_order_id'] == "empty"){

	include("includes/condition/admin_packing_shopin_order_id_empty.php");

}

if(isset($_POST['intern']) && $_POST['intern'] == "photo"){

	include("includes/condition/admin_packing_intern_photo.php");

}

if(isset($_POST['intern_photo_edit']) && $_POST['intern_photo_edit'] == "bearbeiten"){

	include("includes/condition/admin_packing_intern_photo_edit.php");

}

if(isset($_POST['intern']) && $_POST['intern'] == "relocate"){

	include("includes/condition/admin_packing_intern_relocate.php");

}

if(isset($_POST['intern_relocate_edit']) && $_POST['intern_relocate_edit'] == "bearbeiten"){

	include("includes/condition/admin_packing_intern_relocate_edit.php");

}

if(isset($_POST['intern']) && $_POST['intern'] == "labeling"){

	include("includes/condition/admin_packing_intern_labeling.php");

}

if(isset($_POST['intern_labeling_edit']) && $_POST['intern_labeling_edit'] == "bearbeiten"){

	include("includes/condition/admin_packing_intern_labeling_edit.php");

}

if(isset($_POST['edit']) && $_POST['edit'] == "bearbeiten"){

	include("includes/condition/admin_packing_edit_bearbeiten.php");

}

if(isset($_POST['pack']) && $_POST['pack'] == "technic"){

	include("includes/condition/admin_packing_pack_technic.php");

}

if(isset($_POST['pack']) && $_POST['pack'] == "user"){

	include("includes/condition/admin_packing_pack_user.php");

}

if(isset($_POST['pack']) && $_POST['pack'] == "extern"){

	include("includes/condition/admin_packing_pack_extern.php");

}

if(isset($_POST['pack']) && $_POST['pack'] == "extern_blank"){

	include("includes/condition/admin_packing_pack_extern_blank.php");

}

if(isset($_POST['pack']) && $_POST['pack'] == "packing"){

	include("includes/condition/admin_packing_pack_packing.php");

}

if(isset($_POST['pack_user']) && $_POST['pack_user'] == "packing"){

	include("includes/condition/admin_packing_pack_user_packing.php");

}

if(isset($_POST['pack_technic']) && $_POST['pack_technic'] == "packing"){

	include("includes/condition/admin_packing_pack_technic_packing.php");

}

if(isset($_POST['pack_blank']) && $_POST['pack_blank'] == "packing"){

	include("includes/condition/admin_packing_pack_blank_packing.php");

}

if(isset($_POST['pack_adding_technic_shipping']) && $_POST['pack_adding_technic_shipping'] == "bearbeiten"){

	include("includes/condition/admin_packing_pack_adding_technic_shipping.php");

}

if(isset($_POST['pack_adding_extern_shipping']) && $_POST['pack_adding_extern_shipping'] == "bearbeiten"){

	include("includes/condition/admin_packing_pack_adding_extern_shipping.php");

}

if(isset($_POST['pack_adding_extern_shipping_blank']) && $_POST['pack_adding_extern_shipping_blank'] == "bearbeiten"){

	include("includes/condition/admin_packing_pack_adding_extern_shipping_blank.php");

}

?>