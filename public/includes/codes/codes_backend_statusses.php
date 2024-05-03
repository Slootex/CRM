<?php 

@session_start();

include("includes/class_navigation.php");

include('includes/class_page_number.php');

$systemdata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `systemdata` WHERE `systemdata`.`id`='1'"), MYSQLI_ASSOC);

$page_right = "statusses";

if($_SESSION["admin"]["id"] < 1 || $_SESSION["admin"]["roles"][$page_right] != 1){
	header("Location: " . $systemdata['unlogin_index']);
	exit();
}

$maindata = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `maindata` WHERE `maindata`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

$statusses_session = "style_search";

if(isset($_POST["sorting_field"])){$_SESSION[$statusses_session]["sorting_field"] = intval($_POST["sorting_field"]);}
if(isset($_POST["sorting_direction"])){$_SESSION[$statusses_session]["sorting_direction"] = intval($_POST["sorting_direction"]);}
if(isset($_POST["keyword"])){$_SESSION[$statusses_session]["keyword"] = strip_tags($_POST["keyword"]);}
if(isset($_POST["rows"])){$_SESSION[$statusses_session]["rows"] = intval($_POST["rows"]);}

if(isset($_POST['set_search_defaults']) && $_POST['set_search_defaults'] == "OK"){
	unset($_SESSION[$statusses_session]);
}

$sorting = array();
$sorting[] = array(
	"name" => "Name", 
	"value" => "`statuses`.`name`"
);
$sorting[] = array(
	"name" => "ID", 
	"value" => "CAST(`statuses`.`id` AS UNSIGNED)"
);

$sorting_field_name = isset($_SESSION[$statusses_session]["sorting_field"]) ? $sorting[$_SESSION[$statusses_session]["sorting_field"]]["value"] : $sorting[0]["value"];
$sorting_field_value = isset($_SESSION[$statusses_session]["sorting_field"]) ? $_SESSION[$statusses_session]["sorting_field"] : 0;

$sorting_field_options = "";
foreach($sorting as $k => $v){
	$sorting_field_options .= "<option value=\"" . $k . "\"" . ($sorting_field_value == $k ? " selected=\"selected\"" : "") . ">" . $v["name"] . "</option>\n";
}

$directions = array(0 => "ASC", 1 => "DESC");

$sorting_direction_name = isset($_SESSION[$statusses_session]["sorting_direction"]) ? $directions[$_SESSION[$statusses_session]["sorting_direction"]] : "ASC";
$sorting_direction_value = isset($_SESSION[$statusses_session]["sorting_direction"]) ? $_SESSION[$statusses_session]["sorting_direction"] : 0;

$amount_rows = isset($_SESSION[$statusses_session]["rows"]) && $_SESSION[$statusses_session]["rows"] > 0 ? $_SESSION[$statusses_session]["rows"] : 500;
if(!isset($param['pos'])){
	$pos = 0;
}else{
	$pos = intval($param['pos']);
}

$pageNumberlist = new pageList();

$emsg = "";
$emsg_delete = "";

$inp_name = "";
$inp_color = "";
$inp_email_template = "";

$inp_level = "";
$inp_variant_1_text = "";
$inp_variant_1_time = "";
$inp_variant_2_text = "";
$inp_variant_2_time = "";
$inp_variant_3_text = "";
$inp_variant_3_time = "";

$name = "";
$color = "";
$email_template = 0;

$level = "";
$variant_1_text = "";
$variant_1_time = "";
$variant_2_text = "";
$variant_2_time = "";
$variant_3_text = "";
$variant_3_time = "";

if(isset($_POST['save']) && $_POST['save'] == "speichern"){

	if(strlen($_POST['name']) < 1 || strlen($_POST['name']) > 128){
		$emsg .= "<span class=\"error\">Bitte einen Name eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_name = " is-invalid";
	} else {
		$name = strip_tags($_POST['name']);
	}

	if(strlen($_POST['color']) < 7 || strlen($_POST['color']) > 7){
		$emsg .= "<span class=\"error\">Bitte einen Farbwert eingeben. (max. 7 Zeichen)</span><br />\n";
		$inp_color = " is-invalid";
	} else {
		$color = strip_tags($_POST['color']);
	}

	if(strlen($_POST['email_template']) < 1 || strlen($_POST['email_template']) > 3){
		$emsg .= "<span class=\"error\">Bitte eine Email-Vorlage auswählen.</span><br />\n";
		$inp_email_template = " is-invalid";
	} else {
		$email_template = intval($_POST['email_template']);
	}

	if($emsg == ""){

		mysqli_query($conn, "	INSERT 	`statuses` 
								SET 	`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`statuses`.`type`='" . mysqli_real_escape_string($conn, intval(isset($_POST['type']) ? $_POST['type'] : 0)) . "', 
										`statuses`.`name`='" . mysqli_real_escape_string($conn, $name) . "', 
										`statuses`.`color`='" . mysqli_real_escape_string($conn, $color) . "', 
										`statuses`.`email_template`='" . mysqli_real_escape_string($conn, $email_template) . "', 
										`statuses`.`status_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['status_status']) ? $_POST['status_status'] : 0)) . "', 
										`statuses`.`extra_search`='" . mysqli_real_escape_string($conn, intval(isset($_POST['extra_search']) ? $_POST['extra_search'] : 0)) . "', 
										`statuses`.`multi_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['multi_status']) ? $_POST['multi_status'] : 0)) . "', 
										`statuses`.`usermail`='" . mysqli_real_escape_string($conn, intval(isset($_POST['usermail']) ? $_POST['usermail'] : 0)) . "', 
										`statuses`.`adminmail`='" . mysqli_real_escape_string($conn, intval(isset($_POST['adminmail']) ? $_POST['adminmail'] : 0)) . "', 
										`statuses`.`public`='" . mysqli_real_escape_string($conn, intval(isset($_POST['public']) ? $_POST['public'] : 0)) . "'");

		$_POST["id"] = $conn->insert_id;

		$_POST['edit'] = "bearbeiten";

		$emsg = "<p>Der neue Status wurde erfolgreich hinzugefügt!</p>\n";

	}else{

		$_POST["add"] = "hinzufügen";

	}

}

if(isset($_POST['update']) && $_POST['update'] == "speichern"){

	if(strlen($_POST['name']) < 1 || strlen($_POST['name']) > 128){
		$emsg .= "<span class=\"error\">Bitte einen Name eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_name = " is-invalid";
	} else {
		$name = strip_tags($_POST['name']);
	}

	if(strlen($_POST['color']) < 7 || strlen($_POST['color']) > 7){
		$emsg .= "<span class=\"error\">Bitte einen Farbwert eingeben. (max. 7 Zeichen)</span><br />\n";
		$inp_color = " is-invalid";
	} else {
		$color = strip_tags($_POST['color']);
	}

	if(strlen($_POST['email_template']) < 1 || strlen($_POST['email_template']) > 3){
		$emsg .= "<span class=\"error\">Bitte eine Email-Vorlage auswählen.</span><br />\n";
		$inp_email_template = " is-invalid";
	} else {
		$email_template = intval($_POST['email_template']);
	}

	if($emsg == ""){

		mysqli_query($conn, "	UPDATE 	`statuses` 
								SET 	`statuses`.`type`='" . mysqli_real_escape_string($conn, intval(isset($_POST['type']) ? $_POST['type'] : 0)) . "', 
										`statuses`.`name`='" . mysqli_real_escape_string($conn, $name) . "', 
										`statuses`.`color`='" . mysqli_real_escape_string($conn, $color) . "', 
										`statuses`.`email_template`='" . mysqli_real_escape_string($conn, $email_template) . "', 
										`statuses`.`status_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['status_status']) ? $_POST['status_status'] : 0)) . "', 
										`statuses`.`extra_search`='" . mysqli_real_escape_string($conn, intval(isset($_POST['extra_search']) ? $_POST['extra_search'] : 0)) . "', 
										`statuses`.`multi_status`='" . mysqli_real_escape_string($conn, intval(isset($_POST['multi_status']) ? $_POST['multi_status'] : 0)) . "', 
										`statuses`.`usermail`='" . mysqli_real_escape_string($conn, intval(isset($_POST['usermail']) ? $_POST['usermail'] : 0)) . "', 
										`statuses`.`adminmail`='" . mysqli_real_escape_string($conn, intval(isset($_POST['adminmail']) ? $_POST['adminmail'] : 0)) . "', 
										`statuses`.`public`='" . mysqli_real_escape_string($conn, intval(isset($_POST['public']) ? $_POST['public'] : 0)) . "' 
								WHERE 	`statuses`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
								AND 	`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		$emsg = "<p>Der Status wurde erfolgreich geändert!</p>\n";

	}

	$_POST['edit'] = "bearbeiten";

}

if(isset($_POST['delete']) && $_POST['delete'] == "entfernen"){

	if(	$maindata['new_shipping_status'] != intval($_POST['id']) && 
		$maindata['pickup_status'] != intval($_POST['id']) && 
		$maindata['order_status_intern'] != intval($_POST['id']) && 
		$maindata['order_status'] != intval($_POST['id']) && 
		$maindata['shipping_status'] != intval($_POST['id']) && 
		$maindata['shipping_cancel_status'] != intval($_POST['id']) && 
		$maindata['email_status'] != intval($_POST['id']) && 
		$maindata['order_to_archive_status'] != intval($_POST['id']) && 
		$maindata['archive_to_order_status'] != intval($_POST['id']) && 
		$maindata['order_to_booking_status'] != intval($_POST['id']) && 
		$maindata['order_ending_status'] != intval($_POST['id']) && 
		$maindata['order_claim_status'] != intval($_POST['id']) && 
		$maindata['order_recall_status'] != intval($_POST['id']) && 
		$maindata['order_in_checkout_status'] != intval($_POST['id']) && 
		$maindata['order_extra_evaluation_status'] != intval($_POST['id']) && 
		$maindata['order_inspection_process_status'] != intval($_POST['id']) && 
		$maindata['order_extra_verification_status'] != intval($_POST['id']) && 
		$maindata['order_extra_edit_status'] != intval($_POST['id']) && 
		$maindata['order_extra_checkout_status'] != intval($_POST['id']) && 
		$maindata['user_status_intern'] != intval($_POST['id']) && 
		$maindata['user_status'] != intval($_POST['id']) && 
		$maindata['user_email_status'] != intval($_POST['id']) && 
		$maindata['interested_status_intern'] != intval($_POST['id']) && 
		$maindata['interested_status_intern_orderform_per_mail'] != intval($_POST['id']) && 
		$maindata['interested_status'] != intval($_POST['id']) && 
		$maindata['interested_email_status'] != intval($_POST['id']) && 
		$maindata['interested_to_archive_status'] != intval($_POST['id']) && 
		$maindata['archive_to_interested_status'] != intval($_POST['id']) && 
		$maindata['interested_to_order_status'] != intval($_POST['id']) && 
		$maindata['interested_success_status'] != intval($_POST['id'])
	){

		mysqli_query($conn, "	DELETE FROM	`statuses` 
								WHERE 		`statuses`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
								AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'");

		mysqli_query($conn, "	DELETE FROM	`statuses_level` 
								WHERE 		`statuses_level`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								AND 		`statuses_level`.`status_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

		$emsg_delete = "<p>Der Status wurde erfolgreich entfernt!</p>\n";

	}else{
		
		$emsg = "<p>Der Status kann nicht entfernt werden da er in Grunddaten verwendet wird!</p>\n";

		$_POST['edit'] = "bearbeiten";

	}

}

if(isset($_POST['save_level']) && $_POST['save_level'] == "speichern"){

	if(strlen($_POST['level']) < 1 || strlen($_POST['level']) > 128){
		$emsg .= "<span class=\"error\">Bitte eine Stufe eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_level = " is-invalid";
	} else {
		$level = strip_tags($_POST['level']);
	}

	if(strlen($_POST['variant_1_text']) < 1 || strlen($_POST['variant_1_text']) > 1024){
		$emsg .= "<span class=\"error\">Bitte den Variantentext 1 eingeben. (max. 1024 Zeichen)</span><br />\n";
		$inp_variant_1_text = " is-invalid";
	} else {
		$variant_1_text = strip_tags($_POST['variant_1_text']);
	}

	if(strlen($_POST['variant_1_time']) < 1 || strlen($_POST['variant_1_time']) > 256){
		$emsg .= "<span class=\"error\">Bitte die Variantenzeit 1 eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_variant_1_time = " is-invalid";
	} else {
		$variant_1_time = strip_tags($_POST['variant_1_time']);
	}

	if(strlen($_POST['variant_2_text']) < 1 || strlen($_POST['variant_2_text']) > 1024){
		$emsg .= "<span class=\"error\">Bitte den Variantentext 2 eingeben. (max. 1024 Zeichen)</span><br />\n";
		$inp_variant_2_text = " is-invalid";
	} else {
		$variant_2_text = strip_tags($_POST['variant_2_text']);
	}

	if(strlen($_POST['variant_2_time']) < 1 || strlen($_POST['variant_2_time']) > 256){
		$emsg .= "<span class=\"error\">Bitte die Variantenzeit 2 eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_variant_2_time = " is-invalid";
	} else {
		$variant_2_time = strip_tags($_POST['variant_2_time']);
	}

	if(strlen($_POST['variant_3_text']) < 1 || strlen($_POST['variant_3_text']) > 1024){
		$emsg .= "<span class=\"error\">Bitte den Variantentext 3 eingeben. (max. 1024 Zeichen)</span><br />\n";
		$inp_variant_3_text = " is-invalid";
	} else {
		$variant_3_text = strip_tags($_POST['variant_3_text']);
	}

	if(strlen($_POST['variant_3_time']) < 1 || strlen($_POST['variant_3_time']) > 256){
		$emsg .= "<span class=\"error\">Bitte die Variantenzeit 3 eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_variant_3_time = " is-invalid";
	} else {
		$variant_3_time = strip_tags($_POST['variant_3_time']);
	}

	if($emsg == ""){

		mysqli_query($conn, "	INSERT 	`statuses_level` 
								SET 	`statuses_level`.`status_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "', 
										`statuses_level`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
										`statuses_level`.`level`='" . mysqli_real_escape_string($conn, $level) . "', 
										`statuses_level`.`variant_1_text`='" . mysqli_real_escape_string($conn, $variant_1_text) . "', 
										`statuses_level`.`variant_1_time`='" . mysqli_real_escape_string($conn, $variant_1_time) . "', 
										`statuses_level`.`variant_2_text`='" . mysqli_real_escape_string($conn, $variant_2_text) . "', 
										`statuses_level`.`variant_2_time`='" . mysqli_real_escape_string($conn, $variant_2_time) . "', 
										`statuses_level`.`variant_3_text`='" . mysqli_real_escape_string($conn, $variant_3_text) . "', 
										`statuses_level`.`variant_3_time`='" . mysqli_real_escape_string($conn, $variant_3_time) . "', 
										`statuses_level`.`pos`='" . mysqli_real_escape_string($conn, intval(isset($_POST['pos']) ? $_POST['pos'] : 0)) . "'");

		$_POST["level_id"] = $conn->insert_id;

		$_POST['edit_level'] = "bearbeiten";

		$emsg = "<p>Die neue Stufe wurde erfolgreich hinzugefügt!</p>\n";

	}else{

		$_POST["add_level"] = "hinzufügen";

	}

}

if(isset($_POST['update_level']) && $_POST['update_level'] == "speichern"){

	if(strlen($_POST['level']) < 1 || strlen($_POST['level']) > 128){
		$emsg .= "<span class=\"error\">Bitte eine Stufe eingeben. (max. 128 Zeichen)</span><br />\n";
		$inp_level = " is-invalid";
	} else {
		$level = strip_tags($_POST['level']);
	}

	if(strlen($_POST['variant_1_text']) < 1 || strlen($_POST['variant_1_text']) > 1024){
		$emsg .= "<span class=\"error\">Bitte den Variantentext 1 eingeben. (max. 1024 Zeichen)</span><br />\n";
		$inp_variant_1_text = " is-invalid";
	} else {
		$variant_1_text = strip_tags($_POST['variant_1_text']);
	}

	if(strlen($_POST['variant_1_time']) < 1 || strlen($_POST['variant_1_time']) > 256){
		$emsg .= "<span class=\"error\">Bitte die Variantenzeit 1 eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_variant_1_time = " is-invalid";
	} else {
		$variant_1_time = strip_tags($_POST['variant_1_time']);
	}

	if(strlen($_POST['variant_2_text']) < 1 || strlen($_POST['variant_2_text']) > 1024){
		$emsg .= "<span class=\"error\">Bitte den Variantentext 2 eingeben. (max. 1024 Zeichen)</span><br />\n";
		$inp_variant_2_text = " is-invalid";
	} else {
		$variant_2_text = strip_tags($_POST['variant_2_text']);
	}

	if(strlen($_POST['variant_2_time']) < 1 || strlen($_POST['variant_2_time']) > 256){
		$emsg .= "<span class=\"error\">Bitte die Variantenzeit 2 eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_variant_2_time = " is-invalid";
	} else {
		$variant_2_time = strip_tags($_POST['variant_2_time']);
	}

	if(strlen($_POST['variant_3_text']) < 1 || strlen($_POST['variant_3_text']) > 1024){
		$emsg .= "<span class=\"error\">Bitte den Variantentext 3 eingeben. (max. 1024 Zeichen)</span><br />\n";
		$inp_variant_3_text = " is-invalid";
	} else {
		$variant_3_text = strip_tags($_POST['variant_3_text']);
	}

	if(strlen($_POST['variant_3_time']) < 1 || strlen($_POST['variant_3_time']) > 256){
		$emsg .= "<span class=\"error\">Bitte die Variantenzeit 3 eingeben. (max. 256 Zeichen)</span><br />\n";
		$inp_variant_3_time = " is-invalid";
	} else {
		$variant_3_time = strip_tags($_POST['variant_3_time']);
	}

	if($emsg == ""){

		mysqli_query($conn, "	UPDATE 	`statuses_level` 
								SET 	`statuses_level`.`level`='" . mysqli_real_escape_string($conn, $level) . "', 
										`statuses_level`.`variant_1_text`='" . mysqli_real_escape_string($conn, $variant_1_text) . "', 
										`statuses_level`.`variant_1_time`='" . mysqli_real_escape_string($conn, $variant_1_time) . "', 
										`statuses_level`.`variant_2_text`='" . mysqli_real_escape_string($conn, $variant_2_text) . "', 
										`statuses_level`.`variant_2_time`='" . mysqli_real_escape_string($conn, $variant_2_time) . "', 
										`statuses_level`.`variant_3_text`='" . mysqli_real_escape_string($conn, $variant_3_text) . "', 
										`statuses_level`.`variant_3_time`='" . mysqli_real_escape_string($conn, $variant_3_time) . "', 
										`statuses_level`.`pos`='" . mysqli_real_escape_string($conn, intval(isset($_POST['pos']) ? $_POST['pos'] : 0)) . "' 
								WHERE 	`statuses_level`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
								AND 	`statuses_level`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['level_id'])) . "' 
								AND 	`statuses_level`.`status_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

		$emsg = "<p>Die Stufe wurde erfolgreich geändert!</p>\n";

	}

	$_POST['edit_level'] = "bearbeiten";

}

if(isset($_POST['delete_level']) && $_POST['delete_level'] == "entfernen"){

	mysqli_query($conn, "	DELETE FROM	`statuses_level` 
							WHERE 		`statuses_level`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
							AND 		`statuses_level`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['level_id'])) . "' 
							AND 		`statuses_level`.`status_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "'");

	$_POST['edit'] = "bearbeiten";

	$emsg = "<p>Die Stufe wurde erfolgreich entfernt!</p>\n";

}

if(isset($_POST['save']) && $_POST['save'] == "data"){

	if(!isset($_FILES['file']['error']) || (isset($_FILES['file']['error']) && ($_FILES['file']["error"] != UPLOAD_ERR_OK || $_FILES['file']["size"] == 0) )){

		$emsg .= "<span class=\"error\">Bitte eine status.csv wählen.</span><br />\n";

	}

	if($emsg == ""){

		$rows = 1;

		if (($handle = fopen($_FILES['file']['tmp_name'], "r")) !== FALSE){

			while(($data = fgetcsv($handle, 1000, ",", "\"", "\\")) !== FALSE){

				if($rows > 1){

					if(count($data) == 12){

						if(isset($_POST['mode']) && intval($_POST['mode']) == 1){

							mysqli_query($conn, "	INSERT 	`statuses` 
													SET 	`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
															`statuses`.`type`='" . mysqli_real_escape_string($conn, (isset($_POST['type']) && intval($_POST['type']) > 0 ? intval($_POST['type']) : intval($data[2]))) . "', 
															`statuses`.`name`='" . mysqli_real_escape_string($conn, $data[3]) . "', 
															`statuses`.`color`='" . mysqli_real_escape_string($conn, $data[4]) . "', 
															`statuses`.`email_template`='" . mysqli_real_escape_string($conn, $data[5]) . "', 
															`statuses`.`status_status`='" . mysqli_real_escape_string($conn, $data[6]) . "', 
															`statuses`.`extra_search`='" . mysqli_real_escape_string($conn, $data[7]) . "', 
															`statuses`.`multi_status`='" . mysqli_real_escape_string($conn, $data[8]) . "', 
															`statuses`.`usermail`='" . mysqli_real_escape_string($conn, $data[9]) . "', 
															`statuses`.`adminmail`='" . mysqli_real_escape_string($conn, $data[10]) . "', 
															`statuses`.`public`='" . mysqli_real_escape_string($conn, intval($data[11])) . "'");

						}else{

							mysqli_query($conn, "	UPDATE 	`statuses` 
													SET 	`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
															`statuses`.`type`='" . mysqli_real_escape_string($conn, (isset($_POST['type']) && intval($_POST['type']) > 0 ? intval($_POST['type']) : intval($data[2]))) . "', 
															`statuses`.`name`='" . mysqli_real_escape_string($conn, $data[3]) . "', 
															`statuses`.`color`='" . mysqli_real_escape_string($conn, $data[4]) . "', 
															`statuses`.`email_template`='" . mysqli_real_escape_string($conn, $data[5]) . "', 
															`statuses`.`status_status`='" . mysqli_real_escape_string($conn, $data[6]) . "', 
															`statuses`.`extra_search`='" . mysqli_real_escape_string($conn, $data[7]) . "', 
															`statuses`.`multi_status`='" . mysqli_real_escape_string($conn, $data[8]) . "', 
															`statuses`.`usermail`='" . mysqli_real_escape_string($conn, $data[9]) . "', 
															`statuses`.`adminmail`='" . mysqli_real_escape_string($conn, $data[10]) . "', 
															`statuses`.`public`='" . mysqli_real_escape_string($conn, intval($data[11])) . "' 
													WHERE 	`statuses`.`id`='" . mysqli_real_escape_string($conn, intval($data[0])) . "'");

						}

					}

				}

				$rows++;

			}

			fclose($handle);

		}

	}else{

		$_POST['data'] = "importieren";

	}

}

if(isset($_POST['save_level']) && $_POST['save_level'] == "data"){

	if(!isset($_FILES['file']['error']) || (isset($_FILES['file']['error']) && ($_FILES['file']["error"] != UPLOAD_ERR_OK || $_FILES['file']["size"] == 0) )){

		$emsg .= "<span class=\"error\">Bitte eine status_level.csv wählen.</span><br />\n";

	}

	if($emsg == ""){

		$rows = 1;

		if (($handle = fopen($_FILES['file']['tmp_name'], "r")) !== FALSE){

			while(($data = fgetcsv($handle, 1000, ",", "\"", "\\")) !== FALSE){

				if($rows > 1){

					if(count($data) == 11){

						if(isset($_POST['mode']) && intval($_POST['mode']) == 1){

							mysqli_query($conn, "	INSERT 	`statuses_level` 
													SET 	`statuses_level`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "', 
															`statuses_level`.`status_id`='" . mysqli_real_escape_string($conn, $data[2]) . "', 
															`statuses_level`.`level`='" . mysqli_real_escape_string($conn, $data[3]) . "', 
															`statuses_level`.`variant_1_text`='" . mysqli_real_escape_string($conn, $data[4]) . "', 
															`statuses_level`.`variant_1_time`='" . mysqli_real_escape_string($conn, $data[5]) . "', 
															`statuses_level`.`variant_2_text`='" . mysqli_real_escape_string($conn, $data[6]) . "', 
															`statuses_level`.`variant_2_time`='" . mysqli_real_escape_string($conn, $data[7]) . "', 
															`statuses_level`.`variant_3_text`='" . mysqli_real_escape_string($conn, $data[8]) . "', 
															`statuses_level`.`variant_3_time`='" . mysqli_real_escape_string($conn, $data[9]) . "', 
															`statuses_level`.`pos`='" . mysqli_real_escape_string($conn, intval($data[10])) . "'");

						}else{

							mysqli_query($conn, "	UPDATE 	`statuses` 
													SET 	`statuses_level`.`status_id`='" . mysqli_real_escape_string($conn, $data[2]) . "', 
															`statuses_level`.`level`='" . mysqli_real_escape_string($conn, $data[3]) . "', 
															`statuses_level`.`variant_1_text`='" . mysqli_real_escape_string($conn, $data[4]) . "', 
															`statuses_level`.`variant_1_time`='" . mysqli_real_escape_string($conn, $data[5]) . "', 
															`statuses_level`.`variant_2_text`='" . mysqli_real_escape_string($conn, $data[6]) . "', 
															`statuses_level`.`variant_2_time`='" . mysqli_real_escape_string($conn, $data[7]) . "', 
															`statuses_level`.`variant_3_text`='" . mysqli_real_escape_string($conn, $data[8]) . "', 
															`statuses_level`.`variant_3_time`='" . mysqli_real_escape_string($conn, $data[9]) . "', 
															`statuses_level`.`public`='" . mysqli_real_escape_string($conn, intval($data[10])) . "' 
													WHERE 	`statuses_level`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
													AND 	`statuses_level`.`id`='" . mysqli_real_escape_string($conn, intval($data[0])) . "'");

						}

					}

				}

				$rows++;

			}

			fclose($handle);

		}

	}else{

		$_POST['data_level'] = "importieren";

	}

}

$emsg = $emsg != "" ? $emsg . "<br />\n" : "";

$list = "";

$types = array(
	0 => "Abholen", 
	1 => "Aufträge", 
	2 => "Versand", 
	3 => "Kunden", 
	4 => "Interessenten", 
	5 => "Einkäufe", 
	6 => "Retouren", 
	7 => "Packtisch"
);

$where = 	isset($_SESSION[$statusses_session]["keyword"]) && $_SESSION[$statusses_session]["keyword"] != "" ? 
			"WHERE 	(`statuses`.`name` LIKE '%" . mysqli_real_escape_string($conn, $_SESSION[$statusses_session]["keyword"]) . "%') " : 
			"WHERE 	`statuses`.`id`>0";

$query = "	SELECT 		`statuses`.`id` AS id, 
						`statuses`.`type` AS type, 
						`statuses`.`name` AS name, 
						`statuses`.`color` AS color, 
						`templates`.`name` AS template_name, 
						`statuses`.`status_status` AS status_status, 
						`statuses`.`extra_search` AS extra_search, 
						`statuses`.`multi_status` AS multi_status, 
						`statuses`.`usermail` AS usermail, 
						`statuses`.`adminmail` AS adminmail, 
						`statuses`.`public` AS public, 
						(SELECT COUNT(*) AS amount FROM `statuses_level` WHERE`statuses_level`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses_level`.`status_id`=`statuses`.`id`) AS level_amount  
			FROM 		`statuses` 
			LEFT JOIN 	`templates` 
			ON 			`statuses`.`email_template`=`templates`.`id` 
			" . $where . "
			AND 		`statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
			AND 		`templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
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

while($row = $result->fetch_array(MYSQLI_ASSOC)){

	$checkIsInMaindata = (	
		$maindata['new_shipping_status'] != $row['id'] && 
		$maindata['pickup_status'] != $row['id'] && 
		$maindata['order_status_intern'] != $row['id'] && 
		$maindata['order_status'] != $row['id'] && 
		$maindata['shipping_status'] != $row['id'] && 
		$maindata['shipping_cancel_status'] != $row['id'] && 
		$maindata['email_status'] != $row['id'] && 
		$maindata['order_to_archive_status'] != $row['id'] && 
		$maindata['archive_to_order_status'] != $row['id'] && 
		$maindata['order_to_booking_status'] != $row['id'] && 
		$maindata['order_ending_status'] != $row['id'] && 
		$maindata['order_claim_status'] != $row['id'] && 
		$maindata['order_recall_status'] != $row['id'] && 
		$maindata['order_in_checkout_status'] != $row['id'] && 
		$maindata['order_extra_evaluation_status'] != $row['id'] && 
		$maindata['order_inspection_process_status'] != $row['id'] && 
		$maindata['order_extra_verification_status'] != $row['id'] && 
		$maindata['order_extra_edit_status'] != $row['id'] && 
		$maindata['order_extra_checkout_status'] != $row['id'] && 
		$maindata['user_status_intern'] != $row['id'] && 
		$maindata['user_status'] != $row['id'] && 
		$maindata['user_email_status'] != $row['id'] && 
		$maindata['interested_status_intern'] != $row['id'] && 
		$maindata['interested_status_intern_orderform_per_mail'] != $row['id'] && 
		$maindata['interested_status'] != $row['id'] && 
		$maindata['interested_email_status'] != $row['id'] && 
		$maindata['interested_to_archive_status'] != $row['id'] && 
		$maindata['archive_to_interested_status'] != $row['id'] && 
		$maindata['interested_to_order_status'] != $row['id'] && 
		$maindata['interested_success_status'] != $row['id']
	) ? "" : 
	" class=\"bg-danger text-white\"";

	$list .= 	"<form action=\"" . $page['url'] . "/pos/" . $pos . "\" method=\"post\">\n" . 
				"	<tr" . (isset($_POST['id']) && $_POST['id'] == $row['id'] ? " class=\"bg-primary text-white\"" : $checkIsInMaindata) . ">\n" . 
				"		<td scope=\"row\" class=\"text-center\">\n" . 
				"			<span>" . $row['id'] . "</span>\n" . 
				"		</td>\n" . 
				"		<td>\n" . 
				"			<span>" . $row['name'] . "</span>\n" . 
				"		</td>\n" . 
				"		<td>\n" . 
				"			<span>" . $types[$row['type']] . "</span>\n" . 
				"		</td>\n" . 
				"		<td style=\"background-color: " . $row['color'] . "\">\n" . 
				"			<span>" . strtoupper($row['color']) . "</span>\n" . 
				"		</td>\n" . 
				"		<td>\n" . 
				"			<span>" . $row['template_name'] . "</span>\n" . 
				"		</td>\n" . 
				"		<td class=\"text-center\">\n" . 
				"			<span>" . $row['level_amount'] . "</span>\n" . 
				"		</td>\n" . 
				"		<td class=\"text-center\">\n" . 
				"			<span>" . ($row['status_status'] == 1 ? "<i class=\"fa fa-check\"> </i>" : "") . "</span>\n" . 
				"		</td>\n" . 
				"		<td class=\"text-center\">\n" . 
				"			<span>" . ($row['extra_search'] == 1 ? "<i class=\"fa fa-check\"> </i>" : "") . "</span>\n" . 
				"		</td>\n" . 
				"		<td class=\"text-center\">\n" . 
				"			<span>" . ($row['multi_status'] == 1 ? "<i class=\"fa fa-check\"> </i>" : "") . "</span>\n" . 
				"		</td>\n" . 
				"		<td class=\"text-center\">\n" . 
				"			<span>" . ($row['usermail'] == 1 ? "<i class=\"fa fa-check\"> </i>" : "") . "</span>\n" . 
				"		</td>\n" . 
				"		<td class=\"text-center\">\n" . 
				"			<span>" . ($row['adminmail'] == 1 ? "<i class=\"fa fa-check\"> </i>" : "") . "</span>\n" . 
				"		</td>\n" . 
				"		<td class=\"text-center\">\n" . 
				"			<span>" . ($row['public'] == 1 ? "<i class=\"fa fa-check\"> </i>" : "") . "</span>\n" . 
				"		</td>\n" . 
				"		<td align=\"center\">\n" . 
				"			<input type=\"hidden\" name=\"id\" value=\"" . $row['id'] . "\" />\n" . 
				"			<button type=\"submit\" name=\"edit\" value=\"bearbeiten\" class=\"btn btn-sm btn-success\">bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>\n" . 
				"		</td>\n" . 
				"	</tr>\n" . 
				"</form>\n";

}

$html = "<div class=\"row\">\n" . 
		"	<div class=\"col-lg-7 col-md-7 col-sm-7 col-xs-7\">\n" . 
		"		<h3>Einstellungen - Status</h3>\n" . 
		"	</div>\n" . 
		"	<div class=\"col-sm-5 text-right\">\n" . 
		"		<form id=\"order_search\" action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"			<div class=\"btn-group btn-group-lg\">\n" . 
		"				<input type=\"text\" id=\"keyword\" name=\"keyword\" value=\"" . (isset($_SESSION[$statusses_session]['keyword']) && $_SESSION[$statusses_session]['keyword'] != "" ? $_SESSION[$statusses_session]['keyword'] : "") . "\" placeholder=\"Suchbegriff\" aria-label=\"Suchbegriff\" class=\"form-control form-control-lg bg-" . $_SESSION["admin"]["bgcolor_select"] . " text-" . $_SESSION["admin"]["color_select"] . " border border-" . $_SESSION["admin"]["border_select"] . "\" style=\"border-radius: .25rem 0 0 .25rem\" />\n" . 
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
		"				<h6 class=\"text-left mt-2\">Sortierfeld</h6>\n" . 
		"				<select id=\"sorting_field\" name=\"sorting_field\" class=\"custom-select text-primary border border-primary\" onchange=\"this.form.submit()\">\n" . 

		$sorting_field_options . 

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
		"<p>Hier können Sie die Statusse bearbeiten, entfernen oder anlegen.</p>\n" . 
		"<hr />\n" . 

		($emsg_delete != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg_delete . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

		"<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
		"	<div class=\"form-group row\">\n" . 
		"		<div class=\"col-sm-12 text-center\">\n" . 
		"			<div class=\"btn-group\">\n" . 
		"				<button type=\"submit\" name=\"add\" value=\"hinzufügen\" class=\"btn btn-primary\">Vorgang hinzufügen <i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i></button>&nbsp;\n" . 
		"				<a href=\"/crm/status-herunterladen\" class=\"btn btn-primary\">Vorgänge herunterladen <i class=\"fa fa-download\" aria-hidden=\"true\"></i></a>&nbsp;\n" . 
		"				<button type=\"submit\" name=\"data\" value=\"importieren\" class=\"btn btn-primary\">Vorgänge importieren <i class=\"fa fa-list-alt\" aria-hidden=\"true\"></i></button>&nbsp;\n" . 
		"				<a href=\"/crm/status-stufen-herunterladen\" class=\"btn btn-primary\">Stufen herunterladen <i class=\"fa fa-download\" aria-hidden=\"true\"></i></a>&nbsp;\n" . 
		"				<button type=\"submit\" name=\"data_level\" value=\"importieren\" class=\"btn btn-primary\">Stufen importieren <i class=\"fa fa-list-alt\" aria-hidden=\"true\"></i></button>\n" . 
		"			</div>\n" . 
		"		</div>\n" . 
		"	</div>\n" . 
		"</form>\n";

if(!isset($_POST['data'])){

	$html .= 	"<hr />\n" . 

				$pageNumberlist->getInfo() . 

				"<br />\n" . 

				$pageNumberlist->getNavi() . 

				"<div class=\"table-responsive\">\n" . 
				"	<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
				"		<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
				"			<th width=\"70\" scope=\"col\">\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(1, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(1, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline text-nowrap\"><strong>ID</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th>\n" . 
				"				<div class=\"d-block text-nowrap\">\n" . 
				"					<div class=\"d-inline\">\n" . 
				"						<div class=\"d-inline\" style=\"width: 10px\">\n" . 
				"							<a href=\"#\" onclick=\"orderSearchDirection(0, 0)\"><i class=\"fa fa-caret-up\"> </i></a><a href=\"#\" onclick=\"orderSearchDirection(0, 1)\"><i class=\"fa fa-caret-down\"> </i></a>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"d-inline text-nowrap\"><strong>Name</strong></div>\n" . 
				"				</div>\n" . 
				"			</th>\n" . 
				"			<th width=\"200\" scope=\"col\">\n" . 
				"				<strong>Bereich</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"80\" scope=\"col\">\n" . 
				"				<strong>Farbwert</strong>\n" . 
				"			</th>\n" . 
				"			<th scope=\"col\">\n" . 
				"				<strong>Email-Vorlage</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"80\" scope=\"col\" class=\"text-center\">\n" . 
				"				<strong>Stufen</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\" class=\"text-center\">\n" . 
				"				<strong>Neustatusoption</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\" class=\"text-center\">\n" . 
				"				<strong>Filteroption</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\" class=\"text-center\">\n" . 
				"				<strong>Multioption</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\" class=\"text-center\">\n" . 
				"				<strong>Kunden-Mail</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\" class=\"text-center\">\n" . 
				"				<strong>Admin-Mail</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" scope=\"col\" class=\"text-center\">\n" . 
				"				<strong>Öffentlich</strong>\n" . 
				"			</th>\n" . 
				"			<th width=\"120\" align=\"center\" scope=\"col\" class=\"text-center\">\n" . 
				"				<strong>Aktion</strong>\n" . 
				"			</th>\n" . 
				"		</tr></thead>\n" . 

				$list . 

				"	</table>\n" . 
				"</div>\n" . 
				"<br />\n" . 

				$pageNumberlist->getNavi() . 

				((isset($_POST['add']) && $_POST['add'] == "hinzufügen") || (isset($_POST['edit']) && $_POST['edit'] == "bearbeiten") ? "" : "<br />\n<br />\n<br />\n");

}

if(isset($_POST['add']) && $_POST['add'] == "hinzufügen"){

	$type_options = "";

	for($i = 0;$i < count($types);$i++){

		$type_options .= "<option value=\"" . $i . "\"" . (isset($_POST['type']) && $i == intval($_POST['type']) ? " selected=\"selected\"" : "") . ">" . $types[$i] . "</option>\n";

	}

	$result_templates = mysqli_query($conn, "SELECT * FROM `templates` WHERE `templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' ORDER BY CAST(`templates`.`type` AS UNSIGNED) ASC, CAST(`templates`.`id` AS UNSIGNED) ASC");

	$templates_options = "";

	while($t = $result_templates->fetch_array(MYSQLI_ASSOC)){

		$templates_options .= "<option value=\"" . $t['id'] . "\"" . (isset($_POST['email_template']) && $t['id'] == intval($_POST['email_template']) ? " selected=\"selected\"" : "") . ">" . $types[$t['type']] . ", " . $t['name'] . "</option>\n";

	}

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Hinzufügen</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"type\" class=\"col-sm-3 col-form-label\">Bereich <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier wählen Sie den Bereich des Vorgangs aus.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"type\" name=\"type\" class=\"custom-select\">\n" . 

				$type_options . 

				"							</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"name\" class=\"col-sm-3 col-form-label\">Name <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Name des Vorgangs ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"name\" name=\"name\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $name : "") . "\" class=\"form-control" . $inp_name . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"color\" class=\"col-sm-3 col-form-label\">Farbe <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Farbwert des Vorgangs ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"color\" id=\"color\" name=\"color\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $color : "#ffffff") . "\" class=\"form-control" . $inp_color . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"email_template\" class=\"col-sm-3 col-form-label\">Email-Vorlage <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Farbwert des Vorgangs ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"email_template\" name=\"email_template\" class=\"custom-select" . $inp_email_template . "\">" . $templates_options . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-3 col-form-label\">Neustatusoption <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an ob bei Tab-Email&Status dieser Vorgang als Status verwendet werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"status_status\" name=\"status_status\" value=\"1\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval(isset($_POST['status_status']) ? $_POST['status_status'] : 0) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"status_status\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-3 col-form-label\">Filteroption <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an ob der Suchfilter diesen Vorgang als Filteroption verwenden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"extra_search\" name=\"extra_search\" value=\"1\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval(isset($_POST['extra_search']) ? $_POST['extra_search'] : 0) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"extra_search\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-3 col-form-label\">Multioption <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an ob die Multi-Vorgang-Funktion diesen Vorgang als Multioption verwenden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"multi_status\" name=\"multi_status\" value=\"1\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval(isset($_POST['multi_status']) ? $_POST['multi_status'] : 0) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"multi_status\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-3 col-form-label\">Kunden-Mail <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an ob bei diesen Vorgang eine Kunden-Email versendet soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"usermail\" name=\"usermail\" value=\"1\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval(isset($_POST['usermail']) ? $_POST['usermail'] : 0) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"usermail\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-3 col-form-label\">Admin-Mail <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an ob bei diesen Vorgang eine Admin-Email versendet soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"adminmail\" name=\"adminmail\" value=\"1\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval(isset($_POST['adminmail']) ? $_POST['adminmail'] : 0) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"adminmail\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-3 col-form-label\">Öffentlich <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an ob bei diesen Vorgang öffentlich ist.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"public\" name=\"public\" value=\"1\"" . ((isset($_POST['save']) && $_POST['save'] == "speichern" ? intval(isset($_POST['public']) ? $_POST['public'] : 0) : 0) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"public\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<button type=\"submit\" name=\"save\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"							&nbsp;\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br />\n" . 
				"<br />\n" . 
				"<br />\n";

}

if(isset($_POST['edit']) && $_POST['edit'] == "bearbeiten"){

	$row = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `statuses` WHERE `statuses`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' AND `statuses`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "'"), MYSQLI_ASSOC);

	$type_options = "";

	for($i = 0;$i < count($types);$i++){

		$type_options .= "<option value=\"" . $i . "\"" . ($i == $row['type'] ? " selected=\"selected\"" : "") . ">" . $types[$i] . "</option>\n";

	}

	$result_templates = mysqli_query($conn, "SELECT * FROM `templates` WHERE `templates`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' ORDER BY CAST(`templates`.`type` AS UNSIGNED) ASC, CAST(`templates`.`id` AS UNSIGNED) ASC");

	$templates_options = "";

	while($t = $result_templates->fetch_array(MYSQLI_ASSOC)){

		$templates_options .= "<option value=\"" . $t['id'] . "\"" . ($t['id'] == $row['email_template'] ? " selected=\"selected\"" : "") . ">" . $types[$t['type']] . ", " . $t['name'] . "</option>\n";

	}

	$list_level = "";

	$result = mysqli_query($conn, "	SELECT 		* 
									FROM 		`statuses_level` 
									WHERE 		`statuses_level`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' 
									AND 		`statuses_level`.`status_id`='" . mysqli_real_escape_string($conn, intval($_POST['id'])) . "' 
									ORDER BY 	CAST(`statuses_level`.`pos` AS UNSIGNED) ASC");

	while($row_level = $result->fetch_array(MYSQLI_ASSOC)){

		$list_level .= 	"		<tr>\n" . 
						"			<td>" . $row_level['level'] . "</td>\n" . 
						"			<td>" . $row_level['variant_1_text'] . "</td>\n" . 
						"			<td>" . $row_level['variant_1_time'] . "</td>\n" . 
						"			<td>" . $row_level['variant_2_text'] . "</td>\n" . 
						"			<td>" . $row_level['variant_2_time'] . "</td>\n" . 
						"			<td>" . $row_level['variant_3_text'] . "</td>\n" . 
						"			<td>" . $row_level['variant_3_time'] . "</td>\n" . 
						"			<td align=\"center\">\n" . 
						"				<button type=\"submit\" name=\"edit_level\" value=\"bearbeiten\" class=\"btn btn-sm btn-success\" onclick=\"document.getElementById('level_id').value='" . $row_level['id'] . "';\">bearbeiten <i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></button>\n" . 
						"			</td>\n" . 
						"		</tr>\n";

	}

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Bearbeiten</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "/pos/" . $pos . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"type\" class=\"col-sm-3 col-form-label\">Bereich <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Bereich des Vorgangs ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"type\" name=\"type\" class=\"custom-select\">\n" . 

				$type_options . 

				"							</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"name\" class=\"col-sm-3 col-form-label\">Name <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Name des Vorgangs ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"name\" name=\"name\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $name : strip_tags($row["name"])) . "\" class=\"form-control" . $inp_name . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"color\" class=\"col-sm-3 col-form-label\">Farbwert <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Farbwert des Vorgangs ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"color\" id=\"color\" name=\"color\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $color : strip_tags($row["color"])) . "\" class=\"form-control" . $inp_color . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"email_template\" class=\"col-sm-3 col-form-label\">Email-Vorlage <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Email-Vorlage des Vorgangs ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"email_template\" name=\"email_template\" class=\"custom-select" . $inp_email_template . "\">" . $templates_options . "</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-3 col-form-label\">Neustatusoption <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an ob bei Tab-Email&Status dieser Vorgang als Status verwendet werden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"status_status\" name=\"status_status\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? (isset($_POST['status_status']) ? intval($_POST['status_status']) : 0) : intval($row['status_status'])) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"status_status\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-3 col-form-label\">Filteroption <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an ob der Suchfilter dieser Vorgang als Filteroption verwenden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"extra_search\" name=\"extra_search\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? (isset($_POST['extra_search']) ? intval($_POST['extra_search']) : 0) : intval($row['extra_search'])) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"extra_search\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-3 col-form-label\">Multioption <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an ob die Multi-Vorgang-Funktion diesen Vorgang als Multioption verwenden soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"multi_status\" name=\"multi_status\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? (isset($_POST['multi_status']) ? intval($_POST['multi_status']) : 0) : intval($row['multi_status'])) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"multi_status\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-3 col-form-label\">Kunden-Mail <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an ob bei diesen Vorgang eine Kunden-Email versendet soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"usermail\" name=\"usermail\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? (isset($_POST['usermail']) ? intval($_POST['usermail']) : 0) : intval($row['usermail'])) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"usermail\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-3 col-form-label\">Admin-Mail <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an ob bei diesen Vorgang eine Admin-Email versendet soll.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"adminmail\" name=\"adminmail\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? (isset($_POST['adminmail']) ? intval($_POST['adminmail']) : 0) : intval($row['adminmail'])) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"adminmail\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-3 col-form-label\">Öffentlich <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie an ob bei diesen Vorgang öffentlich ist.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<div class=\"custom-control custom-checkbox mt-2\">\n" . 
				"								<input type=\"checkbox\" id=\"public\" name=\"public\" value=\"1\"" . ((isset($_POST['update']) && $_POST['update'] == "speichern" ? (isset($_POST['public']) ? intval($_POST['public']) : 0) : intval($row['public'])) == 1 ? " checked=\"checked\"" : "") . " class=\"custom-control-input bootstrap-switch\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"public\">\n" . 
				"									Ja\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-12 col-form-label\">Stufen:</label>\n" . 
				"						<div class=\"col-sm-12\">\n" . 
				"							<div class=\"table-responsive\">\n" . 
				"								<table class=\"table table-" . $_SESSION["admin"]["bgcolor_table"] . " table-sm table-bordered table-hover mb-0\">\n" . 
				"									<thead><tr class=\"bg-" . $_SESSION["admin"]["bgcolor_table_head"] . " text-" . $_SESSION["admin"]["color_table_head"] . "\">\n" . 
				"										<th width=\"80\" scope=\"col\">\n" . 
				"											<strong>Name</strong>\n" . 
				"										</th>\n" . 
				"										<th scope=\"col\">\n" . 
				"											<strong>Variantentext 1</strong>\n" . 
				"										</th>\n" . 
				"										<th width=\"140\" scope=\"col\">\n" . 
				"											<strong>Variantenzeit 1</strong>\n" . 
				"										</th>\n" . 
				"										<th scope=\"col\">\n" . 
				"											<strong>Variantentext 2</strong>\n" . 
				"										</th>\n" . 
				"										<th width=\"140\" scope=\"col\">\n" . 
				"											<strong>Variantenzeit 2</strong>\n" . 
				"										</th>\n" . 
				"										<th scope=\"col\">\n" . 
				"											<strong>Variantentext 3</strong>\n" . 
				"										</th>\n" . 
				"										<th width=\"140\" scope=\"col\">\n" . 
				"											<strong>Variantenzeit 3</strong>\n" . 
				"										</th>\n" . 
				"										<th width=\"120\" align=\"center\" scope=\"col\" class=\"text-center\">\n" . 
				"											<strong>Aktion</strong>\n" . 
				"										</th>\n" . 
				"									</tr></thead>\n" . 

				$list_level . 

				"								</table>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
				"							<input type=\"hidden\" id=\"level_id\" name=\"level_id\" value=\"0\" />\n" . 
				"							<button type=\"submit\" name=\"update\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
				"							<button type=\"submit\" name=\"add_level\" value=\"hinzufügen\" class=\"btn btn-primary\">Stufe hinzufügen <i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i></button>\n" . 
				"							<button type=\"submit\" name=\"save\" value=\"speichern\" class=\"btn btn-primary\">neu speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"							<button type=\"submit\" name=\"delete\" value=\"entfernen\" onclick=\"return confirm('Wollen Sie den Eintrag wircklich entfernen?')\" class=\"btn btn-danger\">entfernen <i class=\"fa fa-ban\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br />\n" . 
				"<br />\n" . 
				"<br />\n";

}

if(isset($_POST['add_level']) && $_POST['add_level'] == "hinzufügen"){

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Stufe hinzufügen</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "/pos/" . $pos . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"level\" class=\"col-sm-3 col-form-label\">Stufe <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Name der Stufe ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"level\" name=\"level\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $level : "") . "\" class=\"form-control" . $inp_level . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"variant_1_text\" class=\"col-sm-3 col-form-label\">Variantentext 1 <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Variantentext 1 der Stufe ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"variant_1_text\" name=\"variant_1_text\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $variant_1_text : "") . "\" class=\"form-control" . $inp_variant_1_text . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"variant_1_time\" class=\"col-sm-3 col-form-label\">Variantenzeit 1 <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie die Variantenzeit 1 der Stufe ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"variant_1_time\" name=\"variant_1_time\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $variant_1_time : "") . "\" class=\"form-control" . $inp_variant_1_time . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"variant_2_text\" class=\"col-sm-3 col-form-label\">Variantentext 2 <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Variantentext 2 der Stufe ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"variant_2_text\" name=\"variant_2_text\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $variant_2_text : "") . "\" class=\"form-control" . $inp_variant_2_text . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"variant_2_time\" class=\"col-sm-3 col-form-label\">Variantenzeit 2 <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie die Variantenzeit 2 der Stufe ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"variant_2_time\" name=\"variant_2_time\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $variant_2_time : "") . "\" class=\"form-control" . $inp_variant_2_time . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"variant_3_text\" class=\"col-sm-3 col-form-label\">Variantentext 3 <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie den Variantentext 3 der Stufe ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"variant_3_text\" name=\"variant_3_text\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $variant_3_text : "") . "\" class=\"form-control" . $inp_variant_3_text . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"variant_3_time\" class=\"col-sm-3 col-form-label\">Variantenzeit 3 <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie die Variantenzeit 3 der Stufe ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"variant_3_time\" name=\"variant_3_time\" value=\"" . (isset($_POST['save']) && $_POST['save'] == "speichern" ? $variant_3_time : "") . "\" class=\"form-control" . $inp_variant_3_time . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"pos\" class=\"col-sm-3 col-form-label\">Reihenfolge <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier geben Sie die Variantenzeit 3 der Stufe ein.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"number\" id=\"pos\" name=\"pos\" value=\"" . intval(isset($_POST['save']) && $_POST['save'] == "speichern" ? $_POST['pos'] : 0) . "\" class=\"form-control\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
				"							<button type=\"submit\" name=\"save_level\" value=\"speichern\" class=\"btn btn-primary\">Stufe speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"							&nbsp;\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br />\n" . 
				"<br />\n" . 
				"<br />\n";

}

if(isset($_POST['edit_level']) && $_POST['edit_level'] == "bearbeiten"){

	$row = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `statuses_level` WHERE`statuses_level`.`company_id`='" . mysqli_real_escape_string($conn, intval($_SESSION["admin"]["company_id"])) . "' AND `statuses_level`.`id`='" . mysqli_real_escape_string($conn, intval($_POST['level_id'])) . "'"), MYSQLI_ASSOC);

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Stufe bearbeiten</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "/pos/" . $pos . "\" method=\"post\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"level\" class=\"col-sm-3 col-form-label\">Stufe <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Name der Stufe ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"level\" name=\"level\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $level : strip_tags($row["level"])) . "\" class=\"form-control" . $inp_level . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"variant_1_text\" class=\"col-sm-3 col-form-label\">Variantentext 1 <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Variantentext 1 der Stufe ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"variant_1_text\" name=\"variant_1_text\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $variant_1_text : strip_tags($row["variant_1_text"])) . "\" class=\"form-control" . $inp_variant_1_text . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"variant_1_time\" class=\"col-sm-3 col-form-label\">Variantenzeit 1 <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Variantenzeit 1 der Stufe ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"variant_1_time\" name=\"variant_1_time\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $variant_1_time : strip_tags($row["variant_1_time"])) . "\" class=\"form-control" . $inp_variant_1_time . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"variant_2_text\" class=\"col-sm-3 col-form-label\">Variantentext 2 <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Variantentext 2 der Stufe ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"variant_2_text\" name=\"variant_2_text\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $variant_2_text : strip_tags($row["variant_2_text"])) . "\" class=\"form-control" . $inp_variant_2_text . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"variant_2_time\" class=\"col-sm-3 col-form-label\">Variantenzeit 2 <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Variantenzeit 2 der Stufe ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"variant_2_time\" name=\"variant_2_time\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $variant_2_time : strip_tags($row["variant_2_time"])) . "\" class=\"form-control" . $inp_variant_2_time . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"variant_3_text\" class=\"col-sm-3 col-form-label\">Variantentext 3 <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Variantentext 3 der Stufe ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"variant_3_text\" name=\"variant_3_text\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $variant_3_text : strip_tags($row["variant_3_text"])) . "\" class=\"form-control" . $inp_variant_3_text . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"variant_3_time\" class=\"col-sm-3 col-form-label\">Variantenzeit 3 <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die Variantenzeit 3 der Stufe ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"text\" id=\"variant_3_time\" name=\"variant_3_time\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? $variant_3_time : strip_tags($row["variant_3_time"])) . "\" class=\"form-control" . $inp_variant_3_time . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"pos\" class=\"col-sm-3 col-form-label\">Reihenfolge <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Name der Stufe ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"number\" id=\"pos\" name=\"pos\" value=\"" . (isset($_POST['update']) && $_POST['update'] == "speichern" ? intval($_POST['pos']) : intval($row["pos"])) . "\" class=\"form-control" . $inp_level . "\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"hidden\" name=\"id\" value=\"" . intval($_POST['id']) . "\" />\n" . 
				"							<input type=\"hidden\" name=\"level_id\" value=\"" . intval($_POST['level_id']) . "\" />\n" . 
				"							<button type=\"submit\" name=\"update_level\" value=\"speichern\" class=\"btn btn-primary\">speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
				"							<button type=\"submit\" name=\"save_level\" value=\"speichern\" class=\"btn btn-primary\">neu speichern <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"							<button type=\"submit\" name=\"delete_level\" value=\"entfernen\" onclick=\"return confirm('Wollen Sie die Stufe wircklich entfernen?')\" class=\"btn btn-danger\">entfernen <i class=\"fa fa-ban\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br />\n" . 
				"<br />\n" . 
				"<br />\n";

}

if(isset($_POST['data']) && $_POST['data'] == "importieren"){

	$type_options = "								<option value=\"0\">nicht ändern</option>\n";

	for($i = 0;$i < count($types);$i++){

		$type_options .= "<option value=\"" . $i . "\">" . $types[$i] . "</option>\n";

	}

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Importieren</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "\" method=\"post\" enctype=\"multipart/form-data\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"file\" class=\"col-sm-3 col-form-label\">Datei <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die CSV-Datei angeben.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"file\" id=\"file\" name=\"file\" value=\"\" class=\"form-control\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-3 col-form-label\">Mode <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Name dieses Benutzers ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-4 mt-2\">\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"mode_0\" name=\"mode\" value=\"0\" checked=\"checked\" class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"mode_0\">\n" . 
				"									aktualisieren\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"mode_1\" name=\"mode\" value=\"1\" class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"mode_1\">\n" . 
				"									hinzufügen\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"type\" class=\"col-sm-3 col-form-label\">Bereich <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Bereich auswählen.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<select id=\"type\" name=\"type\" class=\"custom-select\">\n" . 

				$type_options . 

				"							</select>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<button type=\"submit\" name=\"save\" value=\"data\" class=\"btn btn-primary\">Import durchführen <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"							&nbsp;\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br />\n" . 
				"<br />\n" . 
				"<br />\n";

}

if(isset($_POST['data_level']) && $_POST['data_level'] == "importieren"){

	$html .= 	"<hr />\n" . 
				"<div class=\"row\">\n" . 
				"	<div class=\"col\">\n" . 
				"		<div class=\"card card-maximize bg-" . $_SESSION["admin"]["bgcolor_card"] . " text-" . $_SESSION["admin"]["color_card"] . "\">\n" . 
				"			<div class=\"card-header\">\n" . 
				"				<h4 class=\"mb-0\">Importieren</h4>\n" . 
				"			</div>\n" . 
				"			<div class=\"card-body px-3 pt-3 pb-0\">\n" . 

				($emsg != "" ? "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">\n" . $emsg . "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>\n" : "") . 

				"				<form action=\"" . $page['url'] . "\" method=\"post\" enctype=\"multipart/form-data\">\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label for=\"file\" class=\"col-sm-3 col-form-label\">Datei <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie die CSV-Datei angeben.\">?</span></label>\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<input type=\"file\" id=\"file\" name=\"file\" value=\"\" class=\"form-control\" />\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"					<div class=\"form-group row\">\n" . 
				"						<label class=\"col-sm-3 col-form-label\">Mode <span class=\"badge badge-pill badge-" . $_SESSION["admin"]["bgcolor_badge"] . "\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Hier können Sie den Name dieses Benutzers ändern.\">?</span></label>\n" . 
				"						<div class=\"col-sm-4 mt-2\">\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"mode_0\" name=\"mode\" value=\"0\" checked=\"checked\" class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"mode_0\">\n" . 
				"									aktualisieren\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"							<div class=\"custom-control custom-radio d-inline mr-3\">\n" . 
				"								<input type=\"radio\" id=\"mode_1\" name=\"mode\" value=\"1\" class=\"custom-control-input\" />\n" . 
				"								<label class=\"custom-control-label\" for=\"mode_1\">\n" . 
				"									hinzufügen\n" . 
				"								</label>\n" . 
				"							</div>\n" . 
				"						</div>\n" . 
				"					</div>\n" . 

				"					<div class=\"row px-0 card-footer\">\n" . 
				"						<div class=\"col-sm-6\">\n" . 
				"							<button type=\"submit\" name=\"save_level\" value=\"data\" class=\"btn btn-primary\">Import durchführen <i class=\"fa fa-floppy-o\" aria-hidden=\"true\"></i></button>\n" . 
				"						</div>\n" . 
				"						<div class=\"col-sm-6\" align=\"right\">\n" . 
				"							&nbsp;\n" . 
				"						</div>\n" . 
				"					</div>\n" . 
				"				</form>\n" . 
				"			</div>\n" . 
				"		</div>\n" . 
				"	</div>\n" . 
				"</div>\n" . 
				"<br />\n" . 
				"<br />\n" . 
				"<br />\n";

}

?>